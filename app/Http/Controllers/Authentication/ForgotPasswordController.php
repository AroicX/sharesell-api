<?php

namespace App\Http\Controllers\Authentication;


use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function sendResetEmail(Request $request)
    {
        $user = User::where('email', '=', $request->get('email'))->first();

        if(!$user) {
            throw new NotFoundHttpException();
        }

        $broker = $this->getPasswordBroker();
        $sendingResponse = $broker->sendResetLink($request->only('email'));

        if($sendingResponse !== Password::RESET_LINK_SENT) {
            throw new HttpException(500);
        }

        return response()->json([
            'status' => 'ok'
        ], 200);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    private function getPasswordBroker()
    {
        return Password::broker();
    }

    public function forget_password(Request $request){
        $phone = $request->phone;
        $this->validateParameter('phone', $phone, INTEGER, true);
        $user_exist = User::where('phone', $phone)->first();
        if(!$user_exist){
            return $this->jsonFormat(200, 'success', "OTP would be sent to the phone number if it's exist");
        }
        else {
            $phone_exist = DB::table('password_resets')->where('email', $phone)->first();
            if($phone_exist){
                DB::table('password_resets')->where('email', $phone)->delete();
            }
            $random = sprintf('%06d', mt_rand(1, 999999));
            $receiverNumber = '+234'. substr($phone, strlen($phone) - 10);
            $message = 'Your OTP for your password reset is ' . $random . ' expires in 5mins.';
            DB::table('password_resets')->insert([
                "email" => $phone,
                "token" => $random,
                "created_at" => Carbon::now()
            ]);
            try{
                Http::withHeaders([
                    'apiKey' => getenv("AT_KEY"),
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Accept' => 'application/json'
                ])->asForm()->post('https://api.africastalking.com/version1/messaging', [
                    'username' => getenv("AT_USERNAME"),
                    'to' => $receiverNumber,
                    "message" => $message,
                    "enqueue" => '1'
                ]);  
            }catch (Exception $e){
                return response()->json([$e->getMessage()]);
            }
            return $this->jsonFormat(200, 'success', "OTP would be sent to the phone number if it's exist");
        }
        return $this->jsonFormat(500, 'error', "An Error Occured");
    }
    public function reset_password(Request $request){
        $otp = $request->otp;
        $password = $request->password;
        $re_password = $request->re_password;

        $this->validateParameter('otp', $otp, INTEGER, true);
        $this->validateParameter('password', $password, STRING, true);
        $this->validateParameter('re_password', $re_password, STRING, true);

        if($password !== $re_password){
            return $this->jsonFormat(422, 'error', "Password and Confirm Password must match");
        }

        $passwordReset = DB::table('password_resets')->where('token', $otp)->first();

        if(!$passwordReset){
            return $this->jsonFormat(422, 'error', "Invalid OTP");
        }else {
            $date_created = Carbon::parse($passwordReset->created_at)->addMinutes(5);
            if(Carbon::now()->lt($date_created)){
                $user = User::where('phone', $passwordReset->email)->update([
                    "password" => Hash::make($password)
                ]);
                DB::table('password_resets')->where('token', $otp)->delete();
                return $this->jsonFormat(200, 'success', 'Password Successfully Updated');
            }else {
                DB::table('password_resets')->where('token', $otp)->delete();
               return $this->jsonFormat(403, 'error', "Token has expired, please try again");
            }
        }
        return $this->jsonFormat(500, 'error', "An Error Occured");
    }
}

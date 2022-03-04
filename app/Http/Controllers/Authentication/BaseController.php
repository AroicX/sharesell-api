<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Events\UserRegistrationEvent;
use App\Reseller;
use App\Supplier;
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use Exception;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Http;
// use Nexmo\Laravel\Facade\Nexmo;
use Twilio\Rest\Client;

class BaseController extends Controller
{
    public function check_phone_number(Request $request)
    {
        $role = $request->type;
        $phone = $request->phone;
        $this->validateParameter('phone', $phone, INTEGER, true);
        $this->validateParameter('role', $role, INTEGER, true);
        $user = User::where('phone', $phone)->first();
        $random = sprintf('%06d', mt_rand(1, 999999));

        if ($user) {
            return $this->jsonFormat(200, 'success', 'User found', $user);
        } else {
            $new_user = new User();
            $new_user->user_id = $this->getLastUserId();
            $new_user->phone = $phone;
            $new_user->primary_role = $role;
            $new_user->one_time_password = $random;

            // try {
            //     Nexmo::message()->send([
            //         'to' => $phone,
            //         'from' => 'Sharesell Africa',
            //         'text' => 'Your OTP is' . $random . ' expires in 5mins.',
            //     ]);
            // } catch (Exception $e) {
            //     return response()->json([$e->getMessage()]);
            // }
            $receiverNumber = ['234'. substr($phone, strlen($phone) - 10)];
            $message = 'Your OTP is ' . $random . ' expires in 5mins.';
            try {
                // $account_sid = getenv("TWILIO_SID");
                // $auth_token = getenv("TWILIO_TOKEN");
                // $twilio_number = getenv("TWILIO_FROM");
    
                // $client = new Client($account_sid, $auth_token);
                // $client->messages->create($receiverNumber, [
                //     'from' => $twilio_number, 
                //     'body' => $message]);
                sendchamp()->sendSms($message, "Sharesell", $receiverNumber, '');

            } catch (Exception $e) {
                return response()->json([$e->getMessage()]);
            }

            switch ($role) {
                case '3':
                    $new_user->save();
                    $supplier = new Supplier();
                    $supplier->user_id = $new_user->user_id;
                    $supplier->save();

                    break;
                case '2':
                    $new_user->save();
                    $reseller = new Reseller();
                    $reseller->user_id = $new_user->user_id;
                    $reseller->save();

                    break;

                default:
                    return $this->jsonFormat(
                        404,
                        'error',
                        'Role id  ' . $role . ' not found',
                        null
                    );
                    break;
            }

            return $this->jsonFormat(
                200,
                'success',
                'OTP has been sent',
                $new_user
            );
        }
    }

    public function one_time_password(Request $request)
    {
        $one_time_password = $request->otp;
        $user = User::where('one_time_password', $one_time_password)->first();
        if ($user) {
            $last_updated = Carbon::parse($user->updated_at)->addMinutes(5);

            if(Carbon::now()->lt($last_updated)){
                $user->email_verified = true;
                $user->email_verified_at = Carbon::now();
                $user->registration_steps = 'verify-otp';
                $user->save();
                return $this->jsonFormat(
                    200,
                    'success',
                    'One time password verified! ',
                    $user
                );
            }else {
                return $this->jsonFormat(403, "error", "One time Password has Expired, click the resend OTP link");
            }
        } else {
            return $this->jsonFormat(
                404,
                'error',
                'One time password is invaild',
                ['otp' => $one_time_password]
            );
        }
    }

    public function resend_one_time_password(Request $request){
        $phone = $request->phone;
        $user = User::where('phone', $phone);
        if($user) {
            $random = sprintf('%06d', mt_rand(1, 999999));
            $user->update(['one_time_password' => $random]);
            $receiverNumber = ['234'. substr($phone, strlen($phone) - 10)];
            $message = 'Your OTP is ' . $random . ' expires in 5mins.';
            try {
                sendchamp()->sendSms($message, "Sharesell", $receiverNumber, '');

            } catch (Exception $e) {
                return response()->json([$e->getMessage()]);
            }
            return $this->jsonFormat(200, "success", "One Time Password has been sent to your Phone");
        }else {
            return $this->jsonFormat(404, 'error', "Invalid Phone Number");
        }
    }

    public function step_three_create_account(
        Request $request,
        JWTAuth $JWTAuth
    ) {
        $user_id = $request->user_id;
        $role_check = User::where('user_id', $user_id)
            ->with('role')
            ->first();

        $business_name = $request->business_name;
        $bvn_number = $request->bvn_number;
        $isRegistered = $request->isRegistered;
        $email = $request->email;
        $password = $request->password;
        $re_password = $request->re_password;
        $this->validateParameter('isRegistered', $isRegistered, BOOLEAN, false);
        $this->validateParameter('business_name', $business_name, STRING, true);
        $this->validateParameter('bvn_number', $bvn_number, STRING, true);
        $this->validateParameter('email', $email, STRING, true);
        $this->validateParameter('password', $password, STRING, true);
        $this->validateParameter('re_password', $re_password, STRING, true);

        if (!User::where('user_id', $user_id)->first()) {
            return $this->jsonFormat(
                404,
                'error',
                'Account with id ' . $user_id . ' not found.',
                null
            );
        }

        try {
            //save user
            $user = User::where('user_id', $user_id)->first();
            $user->email = $email;
            $user->password = $password;
            $user->registration_steps = 'quick-registration';
            $user->save();

            $_user = null;
            // 3 means suppliers
            if (intval($role_check->primary_role) === intval(3)) {
                //save supplier
                $supplier = Supplier::where('user_id', $user_id)->first();
                $supplier->business_name = $business_name;
                $supplier->business_registered = $isRegistered;
                $supplier->bvn = $bvn_number;
                $supplier->save();

                $_user = User::where('user_id', $user_id)
                    ->with('supplier')
                    ->first();
            }
            // 2 means resellers
            if (intval($role_check->primary_role) === intval(2)) {
                //save resellers
                $supplier = Reseller::where('user_id', $user_id)->first();
                $supplier->business_name = $business_name;
                $supplier->business_registered = $isRegistered;
                $supplier->bvn = $bvn_number;
                $supplier->save();

                $_user = User::where('user_id', $user_id)
                    ->with('reseller')
                    ->first();
            }

            $credentials = $request->only(['email', 'password']);
            // UserRegistrationEvent::dispatch($_user);
            $authBearer = 'Bearer '. getenv("SENDCHAMP_PUBLIC_KEY");
            $response = Http::post('https://api.sendchamp.com/api/v1/whatsapp/message/send', [
                'body' => '{"sender":"2347067959173","recipient":"2348146810457","template_code":"ef874fe0-ef77-4f06-9f33-1344d92af734,"type":"template","custom_data":{"Body":{"1":"Bamidele","2":"Oluwatobi","3":"noon","4":"12345"}}}',
                'headers' => [
                  'Accept' => 'application/json',
                  'Authorization' => "Bearer sendchamp_pk_live_$2y$10\$x2rNQ1mtvgz0i9fkKE05l.47d.iofeoA8MAWokbPebUswHwCd9kMG",
                  'Content-Type' => 'application/json',
                ],
              ]);
              return $response;
            try {
                $token = auth()
                    ->guard('api')
                    ->attempt($credentials);
                if (!$token) {
                    throw new AccessDeniedHttpException();
                }
            } catch (JWTException $e) {
                throw new HttpException(500);
            }
            return $this->jsonFormat(
                200,
                'success',
                'Account created successfully',
                ['user' => $_user, 'token' => $token]
            );
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    //
}

<?php

namespace App\Http\Controllers\Authentication;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use \Carbon\Carbon;
use Redirect, DB;

class EmailVerificationController extends Controller
{
    /**
     * @method email_verification
     * verify email.
     * the user clicnks on the link sent to his email
     * @param App\Http\Requests\TokenRequest $request
     * @return \Illuminate\Http\Response
     */

    public static function email_verification(string $token)
    {
    	try {
            $email =  \Crypt::decrypt($token);
            // return $email;

	    	if(!self::email_exist($email))
	    	{
	            $url = config('app.url');
                return Redirect::to($url);
	    	}
	    	$user = User::where('email', $email)->select('id', 'email_verified_at')->first();
	    	$user->email_verified = true;
	    	$user->email_verified_at = Carbon::now();
	    	$user->status = 'active';
	    	$user->save();


            return response()->json([
                'status' => 'success',
                'message' => 'Activation Successful...',
                'payload' => $user
            ]);

    	} catch (Exception $e) {

    	}

    }

    /**
     * get user email verified status
     *
     * @method user_email_verification_status
     * @param  \App\User  $emailList
     * @return \Illuminate\Http\Response
     */
    public static function resend_activation_link(Request $request)
    {
        $validatedData = $request->validate([
            "email" => "required",
        ]);
        $data = $request->all();
        try {
            if(!self::email_exist($data['email']))
            {
                return response()->json(['status' => 'error', 'msg' => 'Oops!! this email does not exist on our system']);
            }
            if(self::user_email_verification_status($data['email']))
            {
                return response()->json(['status' => 'error', 'msg' => 'this email is already verified, please login. or change password if you\'ve forgotten']);
            }
            $user = User::where('email', $data['email'])->first();
            #send activation mail job
            return response()->json(['status' => 'ok', 'msg' => 'Operation successful, Please click on the activation link sent to your email']);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    /**
     * get user email verified status
     *
     * @method user_email_verification_status
     * @param  \App\User  $emailList
     * @return \Illuminate\Http\Response
     */
    public static function user_email_verification_status($email)
    {
        try {
            $user_status = User::where('email', $email)->select('id', 'email_verified')->first()->email_verified;
            return $user_status;

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    /**
     * check if email resource exist.
     *
     * @param  \App\User  $emailList
     * @return \Illuminate\Http\Response
     */
    public static function email_exist($email)
    {
        try {
            $check = User::where('email', $email)->first();
            if($check){
                return 1;
            }
            return 0;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * send password token during reset request
     *
     * @method send_reset_password_token
     * @param  \App\User  $emailList
     * @return \Illuminate\Http\Response
     */
    public static function send_reset_password_token(Request $request)
    {
        $validatedData = $request->validate([
            "email" => "required",
        ]);
        $data = $request->all();
        try {
            if(!self::email_exist($data['email']))
            {
                return response()->json(['status' => 'error', 'msg' => 'Oops!! this email does not exist on our system']);
            }
            $user = User::where('email', $data['email'])->first();
            #save token to reset_password table
            $token = rand(00000, 99999);
            $store = DB::table('password_resets')->insert(
                ['email' => $user->email, 'token' =>  $token, 'created_at' => Carbon::now() ]
            );
            #send activation mail job

            return response()->json(['status' => 'ok', 'msg' => 'Operation successful, Please a reset code (One Time Password) has been sent to your email']);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function reset_password_with_token(Request $request)
    {
        // $validatedData = $request->validate([
        //     "email" => "required",
        //     "token" => "required",
        //     'password' => 'required',
        //     'password_confirm' => 'required',
        // ]);
        $data = $request->all();
        try {
            if(!self::email_exist($data['email']))
            {
                return response()->json(['status' => 'error', 'msg' => 'Oops!! this email does not exist on our system']);
            }
            //compare provided ton with hash token
            $reset_data = DB::table('password_resets')->where('email', $data['email'])->orderBy('created_at', 'desc')->first();

            if($reset_data->token == $data['token'])
            {
                $user = User::where('email', $data['email'])->first();
                #save token to reset_password table

                $user->password = Hash::make($data['password']);
                $user->save();

                #send password change notification mail job

                return response()->json(['status' => 'ok', 'msg' => 'Operation successful, password change successful, please login with your new password']);
            }else{
                return response()->json(['status' => 'error', 'msg' => 'Token not corrct']);
            }


        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    /**
     * @method update_password
     * update user password
     * @param $request
     * @return response
     */
    public static function update_password(Request $request)
    {
        $validatedData = $request->validate([
            "id" => "required",
            'password' => 'required',
            'password_confirm' => 'required',
        ]);
        $data = $request->all();
        try {
            $user = User::where('id', $data['id'])->select('id', 'password')->first();
            $user->password = bcrypt($data['password']);
            $user->save();

            #send password change notification mail job

            return response()->json(['status' => 'ok', 'msg' => 'Operation successful, password change successful, please login with your new password']);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

}

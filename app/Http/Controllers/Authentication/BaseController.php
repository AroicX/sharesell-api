<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Supplier;
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

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
            $new_user->save();

            switch ($role) {
                case '3':
                    $supplier = new Supplier();
                    $supplier->user_id = $new_user->user_id;
                    $supplier->save();
                    break;

                default:
                    # code...
                    break;
            }

            return $this->jsonFormat(
                200,
                'success',
                'No user found',
                $new_user
            );
        }
    }

    public function one_time_password(Request $request)
    {
        $one_time_password = $request->otp;
        $user = User::where('one_time_password', $one_time_password)->first();
        if ($user) {
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
        } else {
            return $this->jsonFormat(
                404,
                'erro',
                'One time password is invaild',
                ['otp' => $one_time_password]
            );
        }
    }

    public function step_three_create_account(
        Request $request,
        JWTAuth $JWTAuth
    ) {
        $user_id = $request->user_id;
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

            //save supplier
            $supplier = Supplier::where('user_id', $user_id)->first();
            $supplier->business_name = $business_name;
            $supplier->business_registered = $isRegistered;
            $supplier->bvn = $bvn_number;
            $supplier->save();

            $_user = User::where('user_id', $user_id)
                ->with('supplier')
                ->first();

            $credentials = $request->only(['email', 'password']);

            try {
                $token = Auth::attempt($credentials);
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

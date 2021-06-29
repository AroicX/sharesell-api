<?php

namespace App\Http\Controllers\Authentication;

use App\User;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Log the user in
     *
     * @param LoginRequest $request
     * @param JWTAuth $JWTAuth
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request, JWTAuth $JWTAuth)
    {
        $credentials = $request->only(['email', 'password']);

        $last_login = new Carbon();

        $last_ip = [
            'user_ip' => $_SERVER['REMOTE_ADDR'],
            'browserAgent' => $_SERVER['HTTP_USER_AGENT'],
        ];

        try {
            $validate = User::where('email', $request->email)->first();
            if (!$validate) {
                return [
                    'status' => 'info',
                    'message' => 'Email or Password is incorrect',
                ];
            } elseif (!$validate->email_verified) {
                return [
                    'status' => 'info',
                    'message' => 'Please your verify email account.',
                ];
            }

            $token = Auth::guard()->attempt($credentials);

            // return $token;

            if (!$token) {
                throw new AccessDeniedHttpException();
            }
        } catch (JWTException $e) {
            throw new HttpException(500);
        }

        User::where('user_id', Auth::user()->user_id)->update([
            'last_login' => $last_login->today()->toDateString(),
            'last_ip_used' => json_encode($last_ip),
        ]);

        $current_user = User::where('user_id', Auth::user()->user_id)->first();

        return response()->json([
            'status' => '200',
            'user' => $current_user,
            'message' => 'Authentication Successfully',
            'token' => $token,

            // 'expires_in' => Auth::guard()->factory()->getTTL() * 60
        ]);
    }
}
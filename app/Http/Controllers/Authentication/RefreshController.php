<?php

namespace App\Http\Controllers\Authentication;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Auth;

class RefreshController extends Controller
{
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        // return dd(apache_request_headers());

        $token = auth()
            ->guard('api')
            ->refresh();

        return response()->json([
            'status' => 'ok',
            'token' => $token,
            'expires_in' =>
                auth()
                    ->guard('api')
                    ->factory()
                    ->getTTL() * 60,
        ]);
    }
}

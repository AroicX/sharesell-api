<?php

namespace App\Http\Middleware;

use Closure;
// use Auth;
// use Config;
// use Illuminate\Auth\Middleware\Authenticate as Middleware;

class UsersMiddleware extends JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // $isUser = Config::get('helper.roles.user');
        // $isArtisan = Config::get('helper.roles.artisan');
        // $isAdmin = Config::get('helper.roles.administrator');

        // $user = Auth::User()->primary_role;

        // if(intval($user) === intval($isAdmin)){
        return $next($request);
        // }elseif (intval($user) === intval($isUser)){
        //     return $next($request);
        // }else{
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'unauthorized user access denied'
        //     ]);

        // }
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Config;
use Auth;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AdministratorMiddleware extends Middleware
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
        $user = Auth::User();
        if($user->primary_role != Config::get('helper.roles.administrator')){
            return response()->json([
                'status' => 'error',
                'message' => 'unauthorized user access denied'
            ]);
        }else{
            return $next($request);
        }
    }
}

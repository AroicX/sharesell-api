<?php

namespace App\Http\Controllers\Authentication;


use App\Artisan;
use Config;
use DB;
use App\User;
use App\Profile;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use App\Mail\RegistrationMailer;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Mail;

class RegistrationController extends Controller
{


    public function register(RegistrationRequest $request, JWTAuth $JWTAuth)
    {




        try {

            $email = $request->email;

            // create new user
            $user = new User();
            $user->user_id = $this->getLastUserId();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = $request->password;
            $user->primary_role = $request->primary_role ? $request->primary_role : null;
            $user->save();


            //create new profile
            $profile = new Profile();
            $profile->profile_id = $this->getLastProfileId();
            $profile->user_id = $user->user_id;
            $profile->gender = $request->gender;
            $profile->save();

            //add if artisan
//            if($request->primary_role === Config::get('helper.roles.user'){
//                $artisan = new Artisan();
//                $artisan->
//            }

            if(!$user->save()) {
                throw new HttpException(500);
            }
            if(!$profile->save()) {
                throw new HttpException(500);
            }




            Mail::to($email)->send(new RegistrationMailer($user));

            $token = $JWTAuth->fromUser($user);
            return response()->json([
                'status' => 'ok',
                'user' => $user,
                'profile' => $profile
            ], 201);




        } catch (\Throwable $th) {
           return $th->getMessage();
        }


    }
}

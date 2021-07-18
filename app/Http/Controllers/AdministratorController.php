<?php

namespace App\Http\Controllers;

use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdministratorController extends Controller
{
    //

    public function login()
    {
        return view('admin.authentication.login');
    }
    public function loginSubmit(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // $user = User::where('email', $request->email)->first();

        if (Auth::attempt($credentials)) {
            $response = [
                'message' => 'Login successfully.',
                'alert' => 'success',
            ];

            return redirect('/administrator/dashboard')->with($response);
        } else {
            throw ValidationException::withMessages([
                'error' => 'Invalid login credentials provided',
            ]);

            $response = [
                'message' => 'Invalid login credentials provided',
                'alert' => 'error',
            ];

            return redirect()
                ->back()
                ->with($response);
        }
    }

    public function addAdministrator(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|unique:users',
            'email' => 'required|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = new User();
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->username = $request->username;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->referral_code = $request->referral_code;
        $user_id = substr(time(), 3, 9) . rand(10, 100);
        $user->user_id = $user_id;
        $user->evc = substr(rand(), 0, 5);
        $user->save();

        if ($user) {
            $response = [
                'message' => 'Huraay, welcome onboard',
                'alert' => 'success',
            ];

            return redirect('backoffice/login')->with($response);
        } else {
            $response = [
                'message' => 'Error! Use a different referral code',
                'alert' => 'error',
            ];
            return redirect('backoffice/signup')->with($response);
        }
    }

    public function getDashboard()
    {
        // return Auth::user();
        return view('admin.dashboard');
    }
}

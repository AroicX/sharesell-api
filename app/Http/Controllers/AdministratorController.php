<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdministratorController extends Controller
{
    //

    public function login()
    {
        return view('admin.authentication.login');
    }
    public function loginSubmit(Request $request)
    {
        return $request->all();
    }
}

<?php

namespace App\Http\Controllers;

use App\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    //

    public function index()
    {
        $current_user = auth()
            ->guard('api')
            ->user()->user_id;
        $res = Address::where('user_id', $current_user)->get();

        if ($res) {
            return $this->jsonFormat(200, 'success', 'Address found', $res);
        } else {
            return $this->jsonFormat(
                404,
                'error',
                'User with id ' . $current_user . ' not found.',
                null
            );
        }
    }
    public function create(Request $request)
    {
        $current_user = auth()
            ->guard('api')
            ->user()->user_id;

        // return $current_user;

        $address = new Address();
        $address->user_id = $current_user;
        $address->address = $request->address;
        $address->save();

        if ($address) {
            return $this->jsonFormat(200, 'success', 'Address Saved', $address);
        } else {
            return $this->jsonFormat(
                404,
                'error',
                'User with id ' . $current_user . ' not found.',
                null
            );
        }
    }
    public function edit(Request $request, $id = null)
    {
        $current_user = auth()
            ->guard('api')
            ->user()->user_id;

        $address = Address::where('id', $id)->first();

        $address->user_id = $current_user;
        $address->address = $request->address;
        $address->status = $request->status ? $request->status : null;
        $address->save();

        if ($address) {
            return $this->jsonFormat(
                200,
                'success',
                'Address Updated',
                $address
            );
        } else {
            return $this->jsonFormat(
                404,
                'error',
                'User with id ' . $current_user . ' not found.',
                null
            );
        }
    }
    public function delete($id = null)
    {
        $current_user = auth()
            ->guard('api')
            ->user()->user_id;

        $address = Address::where('id', $id)->delete();

        if ($address) {
            return $this->jsonFormat(
                200,
                'success',
                'Address Deleted',
                $address
            );
        } else {
            return $this->jsonFormat(
                404,
                'error',
                'User with id ' . $current_user . ' not found.',
                null
            );
        }
    }
}

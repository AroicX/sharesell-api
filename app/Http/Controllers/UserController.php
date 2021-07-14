<?php

namespace App\Http\Controllers;

use App\Supplier;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //

    public function updateBusinessDetails(Request $request)
    {
        $user_id = $request->user_id;
        $this->validateParameter('user_id', $user_id, INTEGER, true);
        $this->validateParameter(
            'business_name',
            $request->business_name,
            STRING,
            true
        );
        $this->validateParameter(
            'bvn_number',
            $request->bvn_number,
            INTEGER,
            true
        );
        $this->validateParameter(
            'current_address',
            $request->current_address,
            STRING,
            true
        );
        $this->validateParameter('state', $request->state, STRING, true);
        $this->validateParameter('city', $request->city, STRING, true);

        $suppiler = Supplier::where('user_id', $user_id)->first();
        if (!$suppiler) {
            return $this->jsonFormat(
                404,
                'error',
                'Account with id ' . $user_id . ' not found.',
                null
            );
        }

        try {
            $suppiler->business_name = $request->business_name;
            $suppiler->business_registered = $request->business_registered;
            $suppiler->bvn = $request->bvn_number;
            $suppiler->current_address = $request->current_address;
            $suppiler->state = $request->state;
            $suppiler->city = $request->city;
            $suppiler->save();

            return $this->jsonFormat(
                200,
                'success',
                'Updated successfully',
                $suppiler
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function updateContactPerson(Request $request)
    {
        $user_id = $request->user_id;
        $this->validateParameter('user_id', $user_id, INTEGER, true);
        $this->validateParameter(
            'firstname',
            $request->firstname,
            STRING,
            true
        );
        $this->validateParameter('lastname', $request->lastname, STRING, true);
        $this->validateParameter('gender', $request->gender, STRING, true);
        $this->validateParameter('email', $request->email, STRING, true);
        $this->validateParameter(
            'phone_number',
            $request->phone_number,
            INTEGER,
            true
        );
        $user = User::where('user_id', $user_id)
            ->with('supplier')
            ->first();

        if (!$user) {
            return $this->jsonFormat(
                404,
                'error',
                'Account with id ' . $user_id . ' not found.',
                null
            );
        }

        try {
            $user->first_name = $request->firstname;
            $user->last_name = $request->lastname;
            $user->email = $request->email;
            $user->gender = $request->gender;
            $user->phone = $request->phone_number;
            $user->save();
            return $this->jsonFormat(
                200,
                'success',
                'Updated successfully',
                $user
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateBVN(Request $request)
    {
        $user_id = $request->user_id;

        $this->validateParameter('bvn', $request->bvn, INTEGER, true);
        $user = User::where('user_id', $user_id)
            ->with('supplier')
            ->first();

        if (!$user) {
            return $this->jsonFormat(
                404,
                'error',
                'Account with id ' . $user_id . ' not found.',
                null
            );
        }
        try {
            $user->bvn = $request->bvn;
            $user->save();
            return $this->jsonFormat(
                200,
                'success',
                'Updated successfully',
                $user
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateNextOfKin(Request $request)
    {
        $user_id = $request->user_id;
        $this->validateParameter('user_id', $user_id, INTEGER, true);
        $this->validateParameter(
            'firstname',
            $request->firstname,
            STRING,
            true
        );
        $this->validateParameter('lastname', $request->lastname, STRING, true);
        $this->validateParameter('gender', $request->gender, STRING, true);
        $this->validateParameter('email', $request->email, STRING, true);
        $this->validateParameter(
            'relationship',
            $request->relationship,
            STRING,
            true
        );
        $this->validateParameter(
            'phone_number',
            $request->phone_number,
            INTEGER,
            true
        );
        $supplier = Supplier::where('user_id', $user_id)
            ->with('getUser')
            ->first();

        if (!$supplier) {
            return $this->jsonFormat(
                404,
                'error',
                'Account with id ' . $user_id . ' not found.',
                null
            );
        }

        try {
            $supplier->next_of_kin_name =
                $request->firstname . ' ' . $request->lastname;
            $supplier->next_of_kin_email = $request->email;
            $supplier->next_of_kin_relationship = $request->relationship;
            $supplier->next_of_kin_gender = $request->gender;
            $supplier->next_of_kin_number = $request->phone_number;
            $supplier->save();
            return $this->jsonFormat(
                200,
                'success',
                'Updated successfully',
                $supplier
            );
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}

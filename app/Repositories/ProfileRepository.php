<?php

namespace App\Repositories;

use App\Http\Controllers\Controller;
use Auth;
use App\Profile;
use App\User;

class ProfileRepository extends Controller implements ProfileRepositoryInterface
{
    public function all()
    {
        return 'all';
    }

    public function show()
    {
        return User::find(Auth::id())
            ->with('profile')
            ->first();
    }

    function update($id, $data)
    {
        Profile::findOrFail($id)->update($data);
        return $this->jsonFormat(
            'success',
            'Profile Updated Successfully',
            Profile::findOrFail($id)
        );
    }

    public function destroy($id)
    {
        $profile = Profile::findOrFail($id);
        $profile->user->delete();
        return $this->jsonFormat('success', 'Profile Deleted Successfully', []);
    }
}

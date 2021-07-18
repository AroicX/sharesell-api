<?php

use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);

        $user = new User();
        $user->user_id = '9920';
        $user->primary_role = 4;
        $user->first_name = 'Gabriel';
        $user->last_name = 'Okunola';
        $user->email = 'admin@sharesell.com';
        $user->password = 'sharesell@flutter_app_2021';
        $user->status = 'active';
        $user->save();
    }
}

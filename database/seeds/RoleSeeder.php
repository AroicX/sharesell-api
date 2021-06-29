<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $role->role_id = 1;
        $role->name = 'User';
        $role->description = 'User hire Artisan to work and get paid';
        $role->save();

        $role = new Role();
        $role->role_id = 2;
        $role->name = 'Resellers';
        $role->description =
            'Reseller\'s offer their services to user in return for payment';
        $role->save();

        $role = new Role();
        $role->role_id = 3;
        $role->name = 'Suppliers';
        $role->description =
            'Supplier\'s offer their services to reselle\'s in return for payment';
        $role->save();

        $role = new Role();
        $role->role_id = 4;
        $role->name = 'Administrator';
        $role->description = 'Supervision';
        $role->save();
    }
}

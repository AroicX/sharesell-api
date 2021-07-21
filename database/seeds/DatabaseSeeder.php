<?php

use App\ProductCategory;
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
        $user->user_id = '001';
        $user->primary_role = 4;
        $user->first_name = 'Gabriel';
        $user->last_name = 'Okunola';
        $user->email = 'admin@sharesell.com';
        $user->password = 'sharesell@flutter_app_2021';
        $user->status = 'active';
        $user->save();

        $categories = [
            'Men’s Fashion ',
            'Women’s Fashion',
            'Kids’ Fashion',
            'Beauty & Cosmetics',
            'Gifts',
            'Home & Kitchen',
            'Jewelries & Accessories',
            'Groceries & Beverages',
            'Toys & Baby Products',
            'Sports & Fitness',
            'Health & Wellness',
        ];

        foreach ($categories as $value) {
            $category = new ProductCategory();
            $category->category_id = sprintf('%06d', mt_rand(1, 9999));
            $category->category_name = $value;
            $category->category_type = $value;
            $category->save();
        }
    }
}

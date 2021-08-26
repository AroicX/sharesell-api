<?php

use App\User;
use App\ProductCategories;
use App\Reseller;
use App\Supplier;
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

        $reseller = new User();
        $reseller->user_id = '0002021';
        $reseller->primary_role = 2;
        $reseller->first_name = 'ShareSell';
        $reseller->last_name = 'Reseller';
        $reseller->email = 'reseller@sharesell.com';
        $reseller->email_verified = true;
        $reseller->password = 'password';
        $reseller->status = 'active';
        $reseller->save();

        $store_resller = new Reseller();
        $store_resller->user_id = $reseller->user_id;
        $store_resller->business_name = 'Penny Wise Ventures';
        $store_resller->business_registered = false;
        $store_resller->bvn = '23424242';
        $store_resller->current_address =
            'No 34a barnawa close, Kaduna Nigeria';
        $store_resller->state = 'Lagos';
        $store_resller->city = 'Lagos';
        $store_resller->status = 'active';
        $store_resller->save();

        $supplier = new User();
        $supplier->user_id = '0002022';
        $supplier->primary_role = 3;
        $supplier->first_name = 'ShareSell';
        $supplier->last_name = 'Supplier';
        $supplier->email = 'supplier@sharesell.com';
        $supplier->email_verified = true;
        $supplier->password = 'password';
        $supplier->status = 'active';
        $supplier->save();

        $store_supplier = new Supplier();
        $store_supplier->user_id = $supplier->user_id;
        $store_supplier->business_name = 'Penny Wise Ventures';
        $store_supplier->business_registered = false;
        $store_supplier->bvn = '23424242';
        $store_supplier->current_address =
            'No 34a barnawa close, Kaduna Nigeria';
        $store_supplier->state = 'Lagos';
        $store_supplier->city = 'Lagos';
        $supplier->status = 'active';
        $store_supplier->save();

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
            $category = new ProductCategories();
            $category->category_id = sprintf('%06d', mt_rand(1, 9999));
            $category->category_name = $value;
            $category->category_type = $value;
            $category->save();
        }
    }
}

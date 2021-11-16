<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Dingo\Api\Routing\Router;

/** @var Router $api */
$api = app(Router::class);

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$api->version('v1', function (Router $api) {
    /* api routes for auths */

    $api->group(['prefix' => 'auth'], function (Router $api) {
        $api->post(
            'check-phone-number',
            'App\\Http\\Controllers\\Authentication\\BaseController@check_phone_number'
        );
        $api->post(
            'quick-register',
            'App\\Http\\Controllers\\Authentication\\BaseController@step_three_create_account'
        );
        $api->post(
            'verify_one_time_password',
            'App\\Http\\Controllers\\Authentication\\BaseController@one_time_password'
        );
        $api->post(
            'register',
            'App\\Http\\Controllers\\Authentication\\RegistrationController@register'
        );
        $api->post(
            'login',
            'App\\Http\\Controllers\\Authentication\\LoginController@login'
        );

        $api->post(
            'refresh',
            'App\\Http\Controllers\\Authentication\\RefreshController@refresh'
        );
    });

    $api->group(['middleware' => 'protected.auth'], function (Router $api) {
        $api->get('test', function () {
            return response()->json([
                'status' => 200,
                'message' => 'Welcome to Artisan Atlas Api V1',
            ]);
        });

        $api->group(
            ['prefix' => 'user', 'middleware' => 'user.roles'],
            function (Router $api) {
                $api->get(
                    'profile',
                    'App\\Http\\Controllers\\UserController@getProfile'
                );
                $api->post(
                    'change-password',
                    'App\\Http\\Controllers\\UserController@updatePassword'
                );
                $api->get(
                    'profile/{user_id}',
                    'App\\Http\\Controllers\\UserController@getProfile'
                );
                $api->get(
                    'address',
                    'App\\Http\\Controllers\\AddressController@index'
                );
                $api->post(
                    'address/create',
                    'App\\Http\\Controllers\\AddressController@create'
                );
                $api->put(
                    'address/update/{address_id}',
                    'App\\Http\\Controllers\\AddressController@edit'
                );
                $api->delete(
                    'address/delete/{address_id}',
                    'App\\Http\\Controllers\\AddressController@delete'
                );
            }
        );
        $api->group(
            ['prefix' => 'update-profile', 'middleware' => 'user.roles'],
            function (Router $api) {
                $api->post(
                    'business-details',
                    'App\\Http\\Controllers\\UserController@updateBusinessDetails'
                );
                $api->post(
                    'contact-person',
                    'App\\Http\\Controllers\\UserController@updateContactPerson'
                );
                $api->post(
                    'update-bvn',
                    'App\\Http\\Controllers\\UserController@updateBVN'
                );
                $api->post(
                    'next-of-kin',
                    'App\\Http\\Controllers\\UserController@updateNextOfKin'
                );
            }
        );
        $api->group(['prefix' => 'products'], function (Router $api) {
            $api->get(
                '/categories',
                'App\\Http\\Controllers\\ProductCategoryController@api'
            );
            //get products in category
            $api->get(
                '/category/{category_id}',
                'App\\Http\\Controllers\\ProductCategoryController@getCategoryProducts'
            );
            //get recent products
            $api->get(
                '/recent-products',
                'App\\Http\\Controllers\\ProductController@getRecentProducts'
            );
            //
            $api->get('/', 'App\\Http\\Controllers\\ProductController@index');
            $api->get(
                '/search/{name}',
                'App\\Http\\Controllers\\ProductController@searchProducts'
            );
            $api->post(
                'add-products',
                'App\\Http\\Controllers\\ProductController@create'
            );
            $api->post(
                'add-product-images/{product_id}',
                'App\\Http\\Controllers\\ProductController@uploadImages'
            );
            $api->put(
                'update-product',
                'App\\Http\\Controllers\\ProductController@update'
            );
            $api->delete(
                'delete-product/{category_id}',
                'App\\Http\\Controllers\\ProductController@delete'
            );
        });
        $api->group(['prefix' => 'shipping'], function (Router $api) {
            $api->post(
                '/generate-payment-link',
                'App\\Http\\Controllers\\ShippingController@quote'
            );
        });
    });

    $api->group(['prefix' => 'transaction'], function (Router $api) {
        // $api->get(
        //     'get-transactions',
        //     'App\\Http\\Controllers\\TranscationsController@getTrans'
        // );
        $api->post(
            'create',
            'App\\Http\\Controllers\\TranscationsController@create'
        );
    });
});

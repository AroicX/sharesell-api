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
    });

    $api->group(['middleware' => 'protected.auth'], function (Router $api) {
        $api->get('test', function () {
            return response()->json([
                'status' => 200,
                'message' => 'Welcome to Artisan Atlas Api V1',
            ]);
        });

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
            $api->get('/', 'App\\Http\\Controllers\\ProductController@index');
            $api->post(
                'add-products',
                'App\\Http\\Controllers\\ProductController@create'
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
    });
});

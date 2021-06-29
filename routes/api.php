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
        $api->get(
            'verify/{token}',
            'App\\Http\\Controllers\\Authentication\\EmailVerificationController@email_verification'
        );
        $api->post(
            'recovery',
            'App\\Http\Controllers\\Authentication\\ForgotPasswordController@sendResetEmail'
        );
        $api->post(
            'reset',
            'App\\Http\Controllers\\Authentication\\ResetPasswordController@resetPassword'
        );

        $api->post(
            'logout',
            'App\\Http\Controllers\\Authentication\\LogoutController@logout'
        );
        $api->post(
            'refresh',
            'App\\Http\Controllers\\Authentication\\RefreshController@refresh'
        );
        // $api->get('me', 'App\\Api\\V1\\Controllers\\Authentication\\UserController@me');
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
                    'get-profile',
                    'App\\Http\\Controllers\\ProfileController@show'
                );
                $api->post(
                    'update-profile/{user_id}',
                    'App\\Http\\Controllers\\ProfileController@update'
                );
            }
        );

        /**
         * Artisan Prefixed Routes Only
         */

        $api->group(
            ['prefix' => 'artisan', 'middleware' => 'artisan.roles'],
            function (Router $api) {
                $api->get(
                    '/',
                    'App\\Http\\Controllers\\ArtisanController@index'
                );
                $api->get(
                    '/profile/{artisan_id}',
                    'App\\Http\\Controllers\\ArtisanController@show'
                );
                $api->post(
                    '/update/{artisan_id}',
                    'App\\Http\\Controllers\\ArtisanController@update'
                );
                $api->post(
                    '/destroy/{artisan_id}',
                    'App\\Http\\Controllers\\ArtisanController@destroy'
                );
            }
        );

        /**
         * Administrator Prefixed Routes only
         */

        $api->group(
            ['prefix' => 'administrator', 'middleware' => 'admins.roles'],
            function (Router $api) {
                /**
                 * Profile Crud
                 */
                $api->get(
                    'delete-profile/{user_id}',
                    'App\\Http\\Controllers\\ProfileController@delete'
                );
            }
        );
    });
});

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

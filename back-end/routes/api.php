<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the 'api' middleware group. Enjoy building your API!
|
*/

Route::group([
    'middleware' =>
    'auth:freelancer',
    'namespace' =>
    'Api'
], function () {
    /* API -> v1 */
    Route::group([
        'namespace' => 'v1',
        'as' => '.v1',
        'prefix' => 'v1'
    ], function () {
        /* Api -> v1  -> freelancer */
        Route::group([
            'namespace' => 'Freelancer',
            'prefix' => 'freelancer',
            'as' => '.freelancer'
        ], function () {
            /*** Freelancer skills. Route used to access API via http methods. In our case, we use vueJs Axios. See front-end ***/
            Route::get('/{id}/skills', [
                'as' => '.freelancer-skills',
                'uses' => 'FreelancerController@freelancerSkills'
            ]);
        });
    });
});

<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->name('api.v1.')->namespace('Api\V1')->group(function () {

Route::get('/status', function () {
    return response()->json(['status' => 'OK']);
})->name('status');


Route::get('chats/getNewMessagesAlert', 'ChatController@getNewMessagesAlert');


Route::apiResource('roles', 'RoleController');
Route::apiResource('users', 'UserController');
Route::apiResource('permission', 'PermissionController');
Route::apiResource('chats', 'ChatController');


Route::post('users/store-user-role', 'UserController@storeUserRole');
Route::post('users/store-user-permission', 'UserController@storeUserPermission');
Route::delete('users/destroy-user-permission', 'UserController@storeUserPermission');
Route::post('role/store-role-permission', 'UserController@storeUserPermission');
Route::delete('role/destroy-role-permission', 'UserController@storeUserPermission');






 });


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth',
], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::get('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});


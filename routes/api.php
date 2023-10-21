<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\StoreController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::group([

    'middleware' => 'api',
    'prefix' => 'auth',
    'role:super-admin|admin',
    'setlocale'

], function ($router) {

    Route::post('login', [AuthController::class,'login']);

   // Route::post('logout', 'AuthController@logout');
   // Route::post('refresh', 'AuthController@refresh');
   // Route::post('me', 'AuthController@me');

});



Route::group([

    'middleware' => ['auth.jwt', 'setlocale'],
    'prefix' => 'admin',

], function ($router) {
Route::get('List-user', [UserController::class,'getUser']);

Route::post('add-store', [StoreController::class,'addStore'])->name('add.store');

Route::get('list-stores', [StoreController::class,'listStores'])->name('list.stores');

Route::put('edit-stores/{id}', [StoreController::class,'editStore'])->name('edit.stores');

Route::delete('delete-stores/{id}', [StoreController::class,'deleteStore'])->name('delete.stores');
});

Route::post('send-email-otp',[EmailController::class,'sandEmailOTP'])->name('send.email');
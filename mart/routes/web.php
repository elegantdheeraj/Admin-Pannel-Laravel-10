<?php

use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuth;
use App\Http\Controllers\Backend\Users;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('auth-login', function () {
    return view('auth-login');
});
Route::post('authenticate', [UserAuth::class, 'authenticate']);
Route::get('logout', [UserAuth::class, 'logout']);
Route::get('auth-forgot', function () {
    return view('auth-forgot');
});
// Route::fallback(function () {
//     return view('errors.404');
// });
// Route::prefix('backend')->group(function () {
//     Route::get('/', function () {
//         return view('backend.dashboard');
//     });
//     Route::prefix('user')->group(function () {
//         Route::get('list', [Users::class, 'index']);
//         Route::get('create', [Users::class, 'create']);
//         Route::get('edit/{id}', [Users::class, 'edit']);
//         Route::get('approve/{id}', [Users::class, 'approve']);
//         Route::get('delete/{id}', [Users::class, 'delete']);
//         Route::get('roles', [Users::class, 'roles']);
//     });
// })->middleware(Authenticate::class);

Route::middleware(['auth', 'checkAccess'])->group(function() {
    Route::prefix('backend')->group(function () {
        Route::get('/', function () {
            return view('backend.dashboard');
        });
        Route::prefix('user')->group(function () {
            Route::get('list', [Users::class, 'index']);
            Route::post('add', [Users::class, 'add_user']);
            Route::get('editForm/{id}', [Users::class, 'getEditUserForm']);
            Route::post('edit', [Users::class, 'edit_user']);
            Route::get('approve/{id}', [Users::class, 'approve_user']);
            Route::get('delete/{id}', [Users::class, 'delete_user']);
            Route::get('roles', [Users::class, 'roles']);
        });
        Route::prefix('role')->group(function() {
            Route::post('add', [Users::class, 'add_role']);
            Route::post('edit', [Users::class, 'edit_role']);
        });
    });
});

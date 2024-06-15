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

Route::middleware(['auth'])->group(function() {
    Route::prefix('backend')->group(function () {
        Route::get('/', function () {
            return view('backend.dashboard');
        })->middleware('checkAccess');
        Route::prefix('user')->group(function () {
            Route::get('list', [Users::class, 'index'])->middleware('checkAccess');
            Route::post('add', [Users::class, 'add_user'])->middleware('checkAccess');
            Route::get('editForm/{id}', [Users::class, 'getEditUserForm']);
            Route::post('edit', [Users::class, 'edit_user'])->middleware('checkAccess');
            Route::get('approve/{id}', [Users::class, 'approve_user'])->middleware('checkAccess');
            Route::get('delete/{id}', [Users::class, 'delete_user'])->middleware('checkAccess');
            Route::get('roles', [Users::class, 'roles'])->middleware('checkAccess');
        });
        Route::prefix('role')->group(function() {
            Route::post('add', [Users::class, 'add_role'])->middleware('checkAccess');
            Route::post('edit', [Users::class, 'edit_role'])->middleware('checkAccess');
        });
    });
});

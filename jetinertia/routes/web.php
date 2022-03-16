<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\User;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

/*Route::middleware(['auth:sanctum', 'verified'])->get('/user', function () {

    $users = User::all();

    return Inertia::render('User',compact('users'));
})->name('user.index');*/

//Route::middleware(['auth:sanctum', 'verified'])->resource('/dashboard/user', UserController::class)->parameters(['user' => 'customer']);
Route::group(['middleware'=>['auth:sanctum', 'verified'], 'prefix'=>'dashboard'],function(){
    Route::resource('user', UserController::class)->parameters(['user' => 'customer']);
    Route::delete('user/avatar/delete/{customer}', [UserController::class,'deleteAvatar'])->name('user.deleteAvatar');
});
//Route::middleware(['auth:sanctum', 'verified'])->delete('/dashboard/user/avatar/delete/{customer}', [UserController::class,'deleteAvatar']);

<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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
    return redirect()->route('login');
});

Route::get('/dashboard', 'App\Http\Controllers\DashboardController@index')->middleware(['auth'])->name('dashboard');
Route::get('/acc-profile', 'App\Http\Controllers\DashboardController@index')->middleware(['auth'])->name('profile');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::get('/admin/dashboard', 'App\Http\Controllers\admin\DashboardController@index')->name('admin-dashboard');
    Route::post('/admin/add-dashboard', 'App\Http\Controllers\admin\DashboardController@add')->name('admin-add-product');
    Route::post('/admin/update-dashboard', 'App\Http\Controllers\admin\DashboardController@update')->name('admin-update-product');
    Route::post('/admin/delete-dashboard', 'App\Http\Controllers\admin\DashboardController@delete')->name('admin-delete-product');

    Route::get('/admin/bidding', 'App\Http\Controllers\admin\BiddingController@index')->name('admin-bidding');

    Route::get('/admin/winners', 'App\Http\Controllers\admin\WinnerController@index')->name('admin-winners');
});

Route::group(['middleware' => ['auth', 'role:user']], function () {
    Route::get('/user/dashboard', 'App\Http\Controllers\user\DashboardController@index')->name('user-dashboard');

    Route::post('/user/place-bid', 'App\Http\Controllers\user\DashboardController@bid')->name('user-place-bid');
});

require __DIR__.'/auth.php';

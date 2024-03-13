<?php

use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\Admin\NewsController;
use Illuminate\Support\Facades\Auth;
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
    return view('welcome');
});

Auth::routes();

Route::match(['get', 'post'], '/register',
function(){
    return redirect('/login');
}
);

//Route for News using Resource

//Route for Category using resource


Route::middleware('auth')->group(function(){
    Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/profile', [App\Http\Controllers\Profile\ProfileController::class, 'index'])->name('profile.index');
    Route::get('/change-password', [\App\Http\Controllers\Profile\ProfileController::class, 'changePassword'])->name('profile.change-password');
    Route::put('/update-password', [App\Http\Controllers\Profile\ProfileController::class, 'updatePassword'])->name('profile.update-password');

    //route for admin
    Route::middleware(['auth', 'admin'])->group(function () {
        //route for news using resource
        Route::resource('news', NewsController::class);
        //route for news using resource
        Route::resource('category', CategoryController::class)->except('show');
    });
});
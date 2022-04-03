<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\PollController;
use App\Http\Controllers\ThirdPartyLoginController;

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


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/polls/{poll}', [PollController::class, 'show'])->name('poll.show');

Auth::routes();

Route::group(['middleware' => 'guest'], function(){
    
    Route::group(['as' => 'github.'], function(){
        Route::get('/sign-in/github', [ThirdPartyLoginController::class, 'githubLogin'])->name('login');
        Route::get('/sign-in/github/redirect', [ThirdPartyLoginController::class, 'githubRedirect'])->name('redirect');
    });

});

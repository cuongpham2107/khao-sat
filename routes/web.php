<?php

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


Route::get('/login',[App\Http\Controllers\Page\LoginController::class, 'showLoginForm']);
Route::post('/login',[App\Http\Controllers\Page\LoginController::class, 'login'])->name('login');

Route::group(['middleware' => 'member_auth'], function () {
    Route::get('/', [App\Http\Controllers\Page\HomeController::class, 'index'])->name('home');
    Route::post('/send-evaluation', [App\Http\Controllers\Page\HomeController::class, 'send_evaluation'])->name('send.evaluation');
});






Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
    Route::post('/create-evaluation/{id}', [\App\Http\Controllers\Admin\EvaluationController::class, 'store'])->name('voyager.create_evaluation');
});

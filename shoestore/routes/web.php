<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreController;

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

Route::get('/', [StoreController::class, showArticles]);

Route::get('article/{id}', [Storecontroller::class, getArticle]);

Route::get('/checkout', [StoreController::class, checkout])
    ->middleware('auth');

Route::get('/dashboard', [StoreController::class, dashboard])
    ->middleware('auth')
    ->name('dashboard');

Route::post('/postPurchase', [StoreController::class, postPurchase])
    ->middleware('auth');

Route::post('/postComment', [StoreController::class, postComment])
    ->middleware('auth');

Route::put('/updateComment/{id}', [StoreController::class, updateComment])
    ->middleware('auth');

Route::delete('/deleteComment/{id}', [StoreController::class, deleteComment])
    ->middleware('auth');

require __DIR__.'/auth.php';

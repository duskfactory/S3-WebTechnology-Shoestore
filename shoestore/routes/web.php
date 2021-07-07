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

Route::get('/', [StoreController::class, 'showArticles'])
    ->name('welcome');

Route::get('article/{id}', [Storecontroller::class, 'getArticle'])
    ->name('article');

Route::get('/checkout', [StoreController::class, 'checkout'])
    ->middleware('auth')
    ->name('checkout');

Route::get('/dashboard', [StoreController::class, 'dashboard'])
    ->middleware('auth')
    ->name('dashboard');

Route::post('/postPurchase', [StoreController::class, 'postPurchase'])
    ->middleware('auth')
    ->name('postPurchase');

Route::post('/postComment', [StoreController::class, 'postComment'])
    ->middleware('auth')
    ->name('postComment');

Route::put('/updateComment/{id}', [StoreController::class, 'updateComment'])
    ->middleware('auth')
    ->name('updateComment');

Route::delete('/deleteComment/{id}', [StoreController::class, 'deleteComment'])
    ->middleware('auth')
    ->name('deleteComment');

Route::get('/addToBasket/{id}', [StoreController::class, 'addToBasket'])
    ->middleware('auth')
    ->name('addToBasket');

require __DIR__.'/auth.php';

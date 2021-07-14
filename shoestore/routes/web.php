<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ViewController;

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

Route::get('/', [ViewController::class, 'showArticles'])
    ->name('welcome');

Route::get('article/{id}', [Viewcontroller::class, 'getArticle'])
    ->name('article');

Route::get('/checkout', [ViewController::class, 'checkout'])
    ->middleware('auth')
    ->name('checkout');

Route::get('/dashboard', [ViewController::class, 'dashboard'])
    ->middleware('auth')
    ->name('dashboard');

Route::get('/postPurchase', [PurchaseController::class, 'postPurchase'])
    ->middleware('auth')
    ->name('postPurchase');

Route::post('/postComment', [CommentController::class, 'postComment'])
    ->middleware('auth')
    ->name('postComment');

Route::get('/deleteComment/{id}', [CommentController::class, 'deleteComment'])
    ->middleware('auth')
    ->name('deleteComment');

Route::get('/addToBasket/{id}', [PurchaseController::class, 'addToBasket'])
    ->middleware('auth')
    ->name('addToBasket');

Route::get('/removeFromBasket/{id}', [PurchaseController::class, 'removeFromBasket'])
    ->middleware('auth')
    ->name('removeFromBasket');

require __DIR__.'/auth.php';

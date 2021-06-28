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

Route::get('/checkout', [StoreController::class, checkout]);

Route::get('/dashboard', [StoreController::class, dashboard])
    ->middleware(['auth'])
    ->name('dashboard');

require __DIR__.'/auth.php';

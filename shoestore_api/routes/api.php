<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResource('articles', ArticleController::class);

Route::apiResource('comments', CommentController::class)->except([
    'index', 'show'
]);

Route::apiResource('users', UserController::class)->except(['index']);

Route::get('/users/login', [UserController::class, 'show']);

Route::put('/users/makePurchase', [UserController::class, 'makePurchase']);

Route::get('/test', function() {
    return "ok";
});

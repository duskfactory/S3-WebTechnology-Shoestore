<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::apiResource('articles', ArticleController::class)->except([
    'store', 'update', 'destroy'
]);

Route::apiResource('comments', CommentController::class)->except([
    'index', 'show'
]);

Route::post('/uploadImage/{id}', [CommentController::class, 'uploadImage']);

Route::apiResource('users', UserController::class)->except(['index']);

Route::post('/makePurchase', [UserController::class, 'makePurchase']);

Route::get('/test', function() {
    return "ok";
});

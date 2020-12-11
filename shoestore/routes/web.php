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

Route::get('/', function () {
    return view('main');
})->name('home');

Route::get('/article/{id}', function($id) {
    return view('article', ['aricle_id' => $id]);
})->name('article');

Route::get('/profile', function() {
    return view('user');
})->name('profile');

Route::get('/error', function() {
    return view('error');
})->name('error');

Route::get('/login', function() {
    return view('login');
})->name('login');

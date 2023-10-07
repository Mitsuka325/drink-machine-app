<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
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

// Authルート
Auth::routes();

// トップページへのアクセス時にログイン画面にリダイレクト
Route::get('/',function(){
    return redirect()->route('login');
});

// 各ルート設定
Route::resource('products', App\Http\Controllers\ProductController::class);

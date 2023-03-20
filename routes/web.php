<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Models\Category;
use App\Models\Post;
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

Route::get('post/{post:slug}', [PostController::class, 'show'])->name('post');

Route::name('category.')->group(function () {
    Route::get('category/{category:slug}/post/{post:slug}', [CategoryController::class, 'post'])->name('post');
    Route::get('category/{category:slug}', [CategoryController::class, 'show'])->name('detail');
});

//Route::get('/category/{category:slug}', function (Category $category) {
//    dd(request()->route()->named('category.detail'));
//})->whereAlpha('category')->name('category.detail');

//Route::get('/category/{category:slug}', [CategoryController::class, 'show']);
//Route::get('/category', [CategoryController::class, 'index']);

Route::get('/', [PostController::class, 'index']);

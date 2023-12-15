<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::group(['namespace' => 'App\Http\Controllers\Main'], function () {
    Route::get('/', 'IndexController')->name('main.index');
});

Route::group(['namespace' => 'App\Http\Controllers\Post', 'prefix' => 'posts'], function () {
    Route::get('/', 'IndexController')->name('post.index');
    Route::get('/{post}', 'ShowController')->name('post.show');

    Route::group(['namespace' => 'Comment', 'prefix' => '{post}/comments'], function () {
        Route::post('/', 'StoreController')->name('post.comment.store');
    });

    Route::group(['namespace' => 'Like', 'prefix' => '{post}/likes'], function () {
        Route::post('/', 'StoreController')->name('post.like.store');
    });
});

Route::group(['namespace' => 'App\Http\Controllers\Category', 'prefix' => 'categories'], function () {
    Route::get('/', 'IndexController')->name('category.index');

    Route::group(['namespace' => 'Post', 'prefix' => '{category}/posts'], function () {
        Route::get('/', 'IndexController')->name('category.post.index');
    });
});

Route::group(['namespace' => 'App\Http\Controllers\Personal', 'prefix' => 'personal', 'middleware' => ['auth', 'verified']], function () {
    Route::group(['namespace' => 'Main', 'prefix' => 'main'], function () {
        Route::get('/', 'IndexController')->name('personal.main.index');
    });
    Route::group(['namespace' => 'Liked', 'prefix' => 'liked'], function () {
        Route::get('/', 'IndexController')->name('personal.liked.index');
        Route::delete('/{post}', 'DeleteController')->name('personal.liked.delete');
    });
    Route::group(['namespace' => 'Comment', 'prefix' => 'comments'], function () {
        Route::get('/', 'IndexController')->name('personal.comment.index');
        Route::get('/{comment}/edit', 'EditController')->name('personal.comment.edit');
        Route::patch('/{comment}', 'UpdateController')->name('personal.comment.update');
        Route::delete('/{comment}', 'DeleteController')->name('personal.comment.delete');
    });
});

Route::group([
    'namespace' => 'App\Http\Controllers\Admin',
    'prefix' => 'admin',
    'middleware' => ['auth', 'admin', 'verified'],
    'as' => 'admin.'
], function () {
    Route::group([
        'namespace' => 'Main',
        'as' => 'main.'
    ], function () {
        Route::get('/', 'IndexController')->name('index');
    });

    Route::group([
        'namespace' => 'Post',
        'prefix' => 'posts',
        'as' => 'post.'
    ], function () {
        Route::get('/', 'IndexController')->name('index');
        Route::get('/create', 'CreateController')->name('create');
        Route::post('/', 'StoreController')->name('store');
        Route::get('/{post}', 'ShowController')->name('show');
        Route::get('/{post}/edit', 'EditController')->name('edit');
        Route::patch('/{post}', 'UpdateController')->name('update');
        Route::delete('/{post}', 'DeleteController')->name('delete');
    });

    Route::group([
        'namespace' => 'Category',
        'prefix' => 'categories',
        'as' => 'category.'
    ], function () {
        Route::get('/', 'IndexController')->name('index');
        Route::get('/create', 'CreateController')->name('create');
        Route::post('/', 'StoreController')->name('store');
        Route::get('/{category}', 'ShowController')->name('show');
        Route::get('/{category}/edit', 'EditController')->name('edit');
        Route::patch('/{category}', 'UpdateController')->name('update');
        Route::delete('/{category}', 'DeleteController')->name('delete');
    });

    Route::group([
        'namespace' => 'Tag',
        'prefix' => 'tags',
        'as' => 'tag.'
    ], function () {
        Route::get('/', 'IndexController')->name('index');
        Route::get('/create', 'CreateController')->name('create');
        Route::post('/', 'StoreController')->name('store');
        Route::get('/{tag}', 'ShowController')->name('show');
        Route::get('/{tag}/edit', 'EditController')->name('edit');
        Route::patch('/{tag}', 'UpdateController')->name('update');
        Route::delete('/{tag}', 'DeleteController')->name('delete');
    });

    Route::group([
        'namespace' => 'User',
        'prefix' => 'users',
        'as' => 'user.'
    ], function () {
        Route::get('/', 'IndexController')->name('index');
        Route::get('/create', 'CreateController')->name('create');
        Route::post('/', 'StoreController')->name('store');
        Route::get('/{user}', 'ShowController')->name('show');
        Route::get('/{user}/edit', 'EditController')->name('edit');
        Route::patch('/{user}', 'UpdateController')->name('update');
        Route::delete('/{user}', 'DeleteController')->name('delete');
    });
});

Auth::routes(['verify' => true]);

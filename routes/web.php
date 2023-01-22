<?php

use App\Http\Controllers\TestController;
use App\Http\Livewire\Publish\PosShowController;
use App\Http\Livewire\Publish\PostController;
use App\Http\Livewire\Publish\PostIndexController;
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
    // return view('test');
    return view('welcome');
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    // Blog Posts...
    Route::prefix('/publish')->group(function () {
        // Route::get('/posts', [PostController::class, 'index'])->name('publish.posts.index');
        Route::get('/posts', PostIndexController::class)->name('publish.posts.index');
        Route::get('/posts/new', PostController::class)->name('publish.posts.store');
        Route::get('/posts/edit/{id}', PostController::class)->name('publish.posts.edit');
        Route::get('/posts/show/{post}', PosShowController::class)->name('publish.posts.show');
    });


    Route::post('/test', [TestController::class, 'store'])->name('test');



    // Route::get('/posts/{id?}', [PostsController::class, 'show'])->name('posts.show');
    // Route::post('/posts/{id}', [PostsController::class, 'store'])->name('posts.store');
    // Route::delete('/posts/{id}', [PostsController::class, 'delete'])->name('posts.delete');
});

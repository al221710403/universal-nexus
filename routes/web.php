<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ImageController;
use App\Http\Livewire\Publish\PostController;
use App\Http\Livewire\ToDo\TaskIndexController;
use App\Http\Livewire\Publish\PosShowController;
use App\Http\Controllers\PredefinedFileController;
use App\Http\Livewire\Publish\PostIndexController;

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

// Route::get('/', function () {
//     // return 'hola';
//     return view('welcome');
// });
Route::redirect('/', '/publish/posts');

Route::get('/ajax', [TestController::class, 'ajaxView']);



Route::post('miJqueryAjax', [TestController::class, 'ajax']);





Route::get('/test', [TestController::class, 'test']);
Route::post('/test-store', [TestController::class, 'store'])->name('test.store');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    // Blog Posts...
    Route::prefix('/publish')->group(function () {
        Route::get('/posts', PostIndexController::class)->name('publish.posts.index');
        Route::get('/posts/new', PostController::class)->name('publish.posts.store');
        Route::get('/posts/edit/{id}', PostController::class)->name('publish.posts.edit');
        Route::get('/posts/show/{post}', PosShowController::class)->name('publish.posts.show');
        Route::post('image/upload', [ImageController::class, 'upload'])->name('publish.posts.image.uplodad');
    });

    // To Do List...
    Route::prefix('/to-do')->group(function () {
        Route::get('/task', TaskIndexController::class)->name('toDo.task.index');
    });

    //Predefined Files
    Route::get('/archivos-pre', [PredefinedFileController::class, 'create'])->name('predefined.create');
    Route::post('/archivos-pre/store', [PredefinedFileController::class, 'store'])->name('predefined.store');
});

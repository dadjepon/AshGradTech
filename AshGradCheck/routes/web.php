<?php

use Illuminate\Support\Facades\Route;
use App\Http\controllers\Auth\RegisterController;
use App\Http\controllers\Auth\LoginController;
use App\Http\controllers\DashboardController;
use App\Http\controllers\Auth\LogoutController;
use App\Http\controllers\PostController;
use App\Http\controllers\UploadController;
use App\Http\controllers\EditProfileController;
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
/*
* Ideally we have to send these to controllers to be maintainable
* Chaining the Route to register using '->name' so that eve if the 
* the path is changed, it would still work
*/
Route::get('/', function(){
    return view('home');
})->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);

Route::post('/logout', [LogoutController::class, 'store']) -> name('logout');

Route::get('/posts', [PostController::class, 'index'])->name('posts');
Route::post('/posts', [PostController::class, 'store']);

// Storing file to database
Route::post('/storeupload', [UploadController::class, 'storeUpload'])->name('storeupload');

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);


Route::get('/profile/edit', [EditProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile/update', [EditProfileController::class, 'update'])->name('profile.update');

// Delete file from database
Route::delete('/deletefile/{id}', [UploadController::class, 'deleteFile'])->name('deletefile');


Route::get('/filecount', [UploadController::class, 'getFileCount'])->name('filecount');

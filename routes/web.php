<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

// Route::get('go', function () {
//     Artisan::call('migrate:fresh --seed');
//     dd('done');
// });

Route::middleware('guest')->group(function(){
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'authenticate']);
});

Route::middleware('auth')->group(function(){
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::view('/', 'index');
    
    Route::middleware('admin')->group(function(){
        Route::get('field', [FieldController::class, 'index'])->name('field.index');
        Route::post('field', [FieldController::class, 'store'])->name('field.store');
        Route::get('field/{id}', [FieldController::class, 'edit'])->name('field.edit');
        Route::put('field', [FieldController::class, 'update'])->name('field.update');
        Route::delete('field/{id}', [FieldController::class, 'destroy'])->name('field.destroy');
        
        Route::get('admin', [AdminController::class, 'index'])->name('admin.index');
        Route::get('admin/create', [AdminController::class, 'create'])->name('admin.create');
        Route::post('admin', [AdminController::class, 'store'])->name('admin.store');
        Route::get('admin/{admin}', [AdminController::class, 'show'])->name('admin.show');
        Route::get('admin/{admin}/edit', [AdminController::class, 'edit'])->name('admin.edit');
        Route::put('admin/{admin}', [AdminController::class, 'update'])->name('admin.update');
        Route::delete('admin/{admin}', [AdminController::class, 'destroy'])->name('admin.destroy');
        
        Route::get('user', [UserController::class, 'index'])->name('user.index');
        Route::get('user/create', [UserController::class, 'create'])->name('user.create');
        Route::post('user', [UserController::class, 'store'])->name('user.store');
        Route::get('user/{admin}', [UserController::class, 'show'])->name('user.show');
        Route::get('user/{admin}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('user/{admin}', [UserController::class, 'update'])->name('user.update');
        Route::delete('user/{admin}', [UserController::class, 'destroy'])->name('user.destroy');
    });
    
    // photo
    Route::get('gallery/{gallery}/photo', [PhotoController::class, 'index'])->name('photo.index');
    Route::get('gallery/{gallery}/photo/create', [PhotoController::class, 'create'])->name('photo.create');
    Route::post('gallery/{gallery}/photo', [PhotoController::class, 'store'])->name('photo.store');
    Route::get('gallery/{gallery}/photo/{photo}', [PhotoController::class, 'show'])->name('photo.show');
    Route::get('gallery/{gallery}/photo/{photo}/edit', [PhotoController::class, 'edit'])->name('photo.edit');
    Route::put('gallery/{gallery}/photo/{photo}', [PhotoController::class, 'update'])->name('photo.update');
    Route::delete('gallery/{gallery}/photo/{photo}', [PhotoController::class, 'destroy'])->name('photo.destroy');
    // end photo

    // video
    Route::get('gallery/{gallery}/video', [VideoController::class, 'index'])->name('video.index');
    Route::get('gallery/{gallery}/video/create', [VideoController::class, 'create'])->name('video.create');
    Route::post('gallery/{gallery}/video', [VideoController::class, 'store'])->name('video.store');
    // end video
    
    // uploader
    Route::post('upload/media', [UploadController::class, 'uploadMedia'])->name('upload.media');
    Route::delete('destroy/media', [UploadController::class, 'destroyMedia'])->name('destroy.media');
    Route::post('upload/avatar', [UploadController::class, 'avatar'])->name('upload.avatar');
    Route::post('upload/video', [UploadController::class, 'video'])->name('upload.video');
    // uploader
    
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
});

<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\VillageController;
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

    // change password
    Route::get('/change-password', [ChangePasswordController::class, 'index']);
    Route::put('/change-password', [ChangePasswordController::class, 'update']);
    // end change password
    
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

        // village
        Route::get('/village', [VillageController::class, 'index'])->name('village.index');
        Route::get('/village/create', [VillageController::class, 'create']);
        Route::post('/village', [VillageController::class, 'store']);
        Route::get('/village/{id}/show', [VillageController::class, 'show']);
        Route::get('/village/{id}', [VillageController::class, 'edit']);
        Route::put('/village/{id}', [VillageController::class, 'update']);
        Route::delete('/village/{id}', [VillageController::class, 'destroy']);
        // end village
    });
    
    // photo
    Route::get('gallery/{gallery}/photo', [PhotoController::class, 'index'])->name('photo.index');
    Route::get('gallery/{gallery}/photo/create', [PhotoController::class, 'create'])->name('photo.create');
    Route::post('gallery/{gallery}/photo', [PhotoController::class, 'store'])->name('photo.store');
    Route::get('gallery/{gallery}/photo/{photo}', [PhotoController::class, 'show'])->name('photo.show');
    Route::get('gallery/{gallery}/photo/{photo}/edit', [PhotoController::class, 'edit'])->name('photo.edit');
    Route::put('gallery/{gallery}/photo/{photo}', [PhotoController::class, 'update'])->name('photo.update');
    Route::delete('gallery/{gallery}/photo/{photo}', [PhotoController::class, 'destroy'])->name('photo.destroy');
    Route::get('gallery/{gallery}/photo/{photo}/download', [PhotoController::class, 'download'])->name('photo.download');
    // end photo

    // video
    Route::get('gallery/{gallery}/video', [VideoController::class, 'index'])->name('video.index');
    Route::get('gallery/{gallery}/video/create', [VideoController::class, 'create'])->name('video.create');
    Route::post('gallery/{gallery}/video', [VideoController::class, 'store'])->name('video.store');
    Route::get('gallery/{gallery}/video/{video}', [VideoController::class, 'show'])->name('video.show');
    Route::get('gallery/{gallery}/video/{video}/edit', [VideoController::class, 'edit'])->name('video.edit');
    Route::put('gallery/{gallery}/video/{video}', [VideoController::class, 'update'])->name('video.update');
    Route::delete('gallery/{gallery}/video/{video}', [VideoController::class, 'destroy'])->name('video.destroy');
    Route::get('gallery/{gallery}/video/{video}/download', [VideoController::class, 'download'])->name('video.download');
    // end video
    
    // uploader
    Route::post('upload/media', [UploadController::class, 'uploadMedia'])->name('upload.media');
    Route::delete('delete/media', [UploadController::class, 'destroyMedia'])->name('destroy.media');
    Route::delete('/delete/photo/{id}', [UploadController::class, 'deletePhoto']);
    // uploader
    
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
});

<?php

use App\Http\Controllers\ActiveVillageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\LeterCController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UtilitiesController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\Village\PhotoController as VillagePhotoController;
use App\Http\Controllers\Village\VideoController as VillageVideoController;
use App\Http\Controllers\VillageUserController;
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
    
    Route::middleware('role:admin')->group(function(){
        Route::get('field', [FieldController::class, 'index'])->name('field.index');
        Route::post('field', [FieldController::class, 'store'])->name('field.store');
        Route::get('field/{id}', [FieldController::class, 'edit'])->name('field.edit');
        Route::put('field', [FieldController::class, 'update'])->name('field.update');
        Route::delete('field/{id}', [FieldController::class, 'destroy'])->name('field.destroy');
        
        Route::get('admin', [AdminController::class, 'index'])->name('admin.index');
        Route::get('admin/create', [AdminController::class, 'create'])->name('admin.create');
        Route::post('admin', [AdminController::class, 'store'])->name('admin.store');
        Route::get('admin/{id}', [AdminController::class, 'show'])->name('admin.show');
        Route::get('admin/{id}/edit', [AdminController::class, 'edit'])->name('admin.edit');
        Route::put('admin/{id}', [AdminController::class, 'update'])->name('admin.update');
        Route::delete('admin/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
        
        Route::get('user', [UserController::class, 'index'])->name('user.index');
        Route::get('user/create', [UserController::class, 'create'])->name('user.create');
        Route::post('user', [UserController::class, 'store'])->name('user.store');
        Route::get('user/{id}', [UserController::class, 'show'])->name('user.show');
        Route::get('user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('user/{id}', [UserController::class, 'update'])->name('user.update');
        Route::delete('user/{id}', [UserController::class, 'destroy'])->name('user.destroy');

        // village
        Route::get('/active-village', [ActiveVillageController::class, 'index'])->name('village.index');
        Route::get('/active-village/create', [ActiveVillageController::class, 'create']);
        Route::post('/active-village', [ActiveVillageController::class, 'store']);
        Route::get('/active-village/{id}/show', [ActiveVillageController::class, 'show']);
        Route::get('/active-village/{id}', [ActiveVillageController::class, 'edit']);
        Route::put('/active-village/{id}', [ActiveVillageController::class, 'update']);
        Route::delete('/active-village/{id}', [ActiveVillageController::class, 'destroy']);
        // end village

        // village user
        Route::get('/village-user', [VillageUserController::class, 'index']);
        Route::get('/village-user/create', [VillageUserController::class, 'create']);
        Route::post('/village-user', [VillageUserController::class, 'store']);
        Route::get('/village-user/{id}/show', [VillageUserController::class, 'show']);
        Route::get('/village-user/{id}', [VillageUserController::class, 'edit']);
        Route::put('/village-user/{id}', [VillageUserController::class, 'update']);
        Route::delete('/village-user/{id}', [VillageUserController::class, 'destroy']);
        // end village user
    });

    Route::middleware('role:admin|village')->name('village.')->group(function(){
        Route::get('/{village}/leter-c', [LeterCController::class, 'index'])->name('leterC.index');
        Route::get('/{village}/leter-c/create', [LeterCController::class, 'create']);
        Route::post('/{village}/leter-c', [LeterCController::class, 'store']);
        Route::get('/{village}/leter-c/{id}/show', [LeterCController::class, 'show']);
        Route::get('/{village}/leter-c/{id}', [LeterCController::class, 'edit']);
        Route::put('/{village}/leter-c/{id}', [LeterCController::class, 'update']);
        Route::delete('/{village}/leter-c/{id}', [LeterCController::class, 'destroy']);

         // photo
        Route::prefix('village-photo')->group(function(){
            Route::get('/{village}', [VillagePhotoController::class, 'index'])->name('photo.index');
            Route::get('/{village}/create', [VillagePhotoController::class, 'create'])->name('photo.create');
            Route::post('/{village}', [VillagePhotoController::class, 'store'])->name('photo.store');
            Route::get('/{village}/{photo}/show', [VillagePhotoController::class, 'show'])->name('photo.show');
            Route::get('/{village}/{photo}', [VillagePhotoController::class, 'edit'])->name('photo.edit');
            Route::put('/{village}/{photo}', [VillagePhotoController::class, 'update'])->name('photo.update');
            Route::delete('/{village}/{photo}', [VillagePhotoController::class, 'destroy'])->name('photo.destroy');
            Route::get('/{village}/{photo}/download', [VillagePhotoController::class, 'download'])->name('photo.download');
        });
        // end photo

        Route::prefix('village-video')->group(function(){
            // video
            Route::get('/{village}/video', [VillageVideoController::class, 'index'])->name('video.index');
            Route::get('/{village}/video/create', [VillageVideoController::class, 'create'])->name('video.create');
            Route::post('/{village}/video', [VillageVideoController::class, 'store'])->name('video.store');
            Route::get('/{village}/video/{video}', [VillageVideoController::class, 'show'])->name('video.show');
            Route::get('/{village}/video/{video}/edit', [VillageVideoController::class, 'edit'])->name('video.edit');
            Route::put('/{village}/video/{video}', [VillageVideoController::class, 'update'])->name('video.update');
            Route::delete('/{village}/video/{video}', [VillageVideoController::class, 'destroy'])->name('video.destroy');
            Route::get('/{village}/video/{video}/download', [VillageVideoController::class, 'download'])->name('video.download');
            // end video
        });
    });
    
    // photo
    Route::get('/{field}/photo', [PhotoController::class, 'index'])->name('photo.index');
    Route::get('/{field}/photo/create', [PhotoController::class, 'create'])->name('photo.create');
    Route::post('/{field}/photo', [PhotoController::class, 'store'])->name('photo.store');
    Route::get('/{field}/photo/{photo}/show', [PhotoController::class, 'show'])->name('photo.show');
    Route::get('/{field}/photo/{photo}', [PhotoController::class, 'edit'])->name('photo.edit');
    Route::put('/{field}/photo/{photo}', [PhotoController::class, 'update'])->name('photo.update');
    Route::delete('/{field}/photo/{photo}', [PhotoController::class, 'destroy'])->name('photo.destroy');
    Route::get('/{field}/photo/{photo}/download', [PhotoController::class, 'download'])->name('photo.download');
    // end photo

    // video
    Route::get('/{field}/video', [VideoController::class, 'index'])->name('video.index');
    Route::get('/{field}/video/create', [VideoController::class, 'create'])->name('video.create');
    Route::post('/{field}/video', [VideoController::class, 'store'])->name('video.store');
    Route::get('/{field}/video/{video}', [VideoController::class, 'show'])->name('video.show');
    Route::get('/{field}/video/{video}/edit', [VideoController::class, 'edit'])->name('video.edit');
    Route::put('/{field}/video/{video}', [VideoController::class, 'update'])->name('video.update');
    Route::delete('/{field}/video/{video}', [VideoController::class, 'destroy'])->name('video.destroy');
    Route::get('/{field}/video/{video}/download', [VideoController::class, 'download'])->name('video.download');
    // end video
    
    // uploader
    Route::post('upload/media', [UploadController::class, 'uploadMedia'])->name('upload.media');
    Route::delete('delete/media', [UploadController::class, 'destroyMedia'])->name('destroy.media');
    Route::delete('/delete/photo/{media}/{id}', [UploadController::class, 'deletePhoto']);
    Route::delete('/village-media/delete/photo/{media}/{id}', [UploadController::class, 'deletePhotoVillage']);
    Route::delete('/delete/video/{media}/{id}', [UploadController::class, 'deleteVideo']);
    // uploader

    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    // utilities
    Route::get('/utilities/province', [UtilitiesController::class, 'province']);
    Route::get('/utilities/regency', [UtilitiesController::class, 'regency']);
    Route::get('/utilities/district', [UtilitiesController::class, 'district']);
    Route::get('/utilities/village', [UtilitiesController::class, 'village']);
    // end utilities
});

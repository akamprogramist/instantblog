<?php

use Illuminate\Support\Facades\View;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmbedController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowsController;
use App\Http\Controllers\InstantController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PublicTagController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\PublicPostController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


Route::get('admin', [AdminController::class, 'index'])->name('admin');
Route::group(
   ['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']],
   function () {
      Route::get('/', [PublicPostController::class, 'index']);
      Route::get('home', [HomeController::class, 'index'])->name('home');
      Route::get('posts/{post}', [PublicPostController::class, 'show']);
      Route::get('archives', [PublicPostController::class, 'archives']);
      Route::get('archiveposts', [PublicPostController::class, 'archiveposts']);
      Route::get('popular', [PublicPostController::class, 'popular']);
      Route::get('posts/{post}/amp', [PublicPostController::class, 'ampShow']);
      Route::get('page/{page}', [PublicPostController::class, 'showPage']);
      Route::get('feed', [PublicPostController::class, 'feedControl']);
      Route::get('search', [PublicPostController::class, 'search']);

      Route::post('post/{id}/click', [LikeController::class, 'likePost']);

      Route::get('/categories', [PublicTagController::class, 'tags']);
      Route::get('/category/{tag}', [PublicTagController::class, 'index']);

      Route::get('adminprofile', [UserController::class, 'adminProfile']);
      Route::put('adminprofile/{id}', [UserController::class, 'adminUpdate']);

      Route::get('notifications', [ProfileController::class, 'usernotifications']);
      Route::get('delnotifications', [ProfileController::class, 'delnotifications']);
      Route::get('deleteaccount', [ProfileController::class, 'confirm']);
      Route::get('followers/{user:username}', [ProfileController::class, 'followers']);
      Route::get('following/{user:username}', [ProfileController::class, 'following']);
      Route::put('homepreference/{id}', [ProfileController::class, 'homepage']);

      Route::post('follow/{user}', [FollowsController::class, 'store']);

      Route::get('settings', [SettingController::class, 'index']);
      Route::put('settings/{id}', [SettingController::class, 'update']);

      Route::get('home/add', [HomeController::class, 'addpost']);

      Route::post('siteinstant', [InstantController::class, 'siteCheck']);
      Route::get('deactivate', [InstantController::class, 'deactivatePage']);
      Route::get('deactivation-result', [InstantController::class, 'deactivateResult']);
      Route::post('deactivateinstant', [InstantController::class, 'deactivateScript']);

      Route::post('admincp/uploadImg', [FileUploadController::class, 'postImage']);
      Route::post('admincp/deleteImg', [FileUploadController::class, 'deleteFile']);

      Route::post('admincp/postEmbed', [EmbedController::class, 'fetchEmbed']);
      Route::post('admincp/deleteEmbed', [EmbedController::class, 'deleteEmbed']);

      Route::post('cnt/multiple', [PostController::class, 'multiple']);
      Route::get('unpublished', [PostController::class, 'unpublished']);
      Route::get('publishpost/{id}', [PostController::class, 'publishpost']);

      Route::resource('cats', TagController::class);
      Route::resource('home', HomeController::class);
      Route::resource('users', UserController::class);
      Route::resource('pages', PageController::class);
      Route::resource('contents', PostController::class);
      Route::resource('comments', CommentController::class);
      Route::resource('profile', ProfileController::class);

      Route::get('auth/{driver}', [LoginController::class, 'redirectToProvider']);
      Route::get('auth/{driver}/callback', [LoginController::class, 'handleProviderCallback']);

      Route::get('instant/clear', function () {
         Artisan::call('cache:clear');
         Artisan::call('config:clear');
         Artisan::call('view:clear');
         Artisan::call('route:clear');
         session()->flash('message', __('admin.cleared'));
         return redirect('/');
      });
   }
);
require __DIR__ . '/auth.php';

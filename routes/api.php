<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\PublicPostController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('/posts', [PublicPostController::class, 'index']);
Route::group(
    ['prefix' => 'api'],
    function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        Route::group(
            ['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']],
            function () {
                Route::get('/register', [RegisteredUserController::class, 'create'])
                    ->middleware('guest')
                    ->name('register');

                Route::post('/register', [RegisteredUserController::class, 'store'])
                    ->middleware('guest');

                Route::get('/login', [AuthenticatedSessionController::class, 'create'])
                    ->middleware('guest')
                    ->name('login');

                Route::post('/login', [AuthenticatedSessionController::class, 'store'])
                    ->middleware('guest');

                Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
                    ->middleware('guest')
                    ->name('password.request');

                Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
                    ->middleware('guest')
                    ->name('password.email');

                Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
                    ->middleware('guest')
                    ->name('password.reset');

                Route::post('/reset-password', [NewPasswordController::class, 'store'])
                    ->middleware('guest')
                    ->name('password.update');

                Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])
                    ->middleware('auth')
                    ->name('verification.notice');

                Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                    ->middleware(['auth', 'signed', 'throttle:6,1'])
                    ->name('verification.verify');

                Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                    ->middleware(['auth', 'throttle:6,1'])
                    ->name('verification.send');

                Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
                    ->middleware('auth')
                    ->name('password.confirm');

                Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])
                    ->middleware('auth');

                Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
                    ->middleware('auth')
                    ->name('logout');
                Route::get('admin', [AdminController::class, 'index'])->name('admin');
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

                Route::get('categories', [PublicTagController::class, 'tags']);
                Route::get('category/{tag}', [PublicTagController::class, 'index']);

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
                Route::resource('money', MoneyController::class);

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
    }
);



/// this is old
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

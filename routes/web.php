<?php

use App\Livewire\ShowPost;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FacebookController;
use App\Http\Controllers\UserPostController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VirusScanController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\ProfessionalPostController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\UserManagementController;

Route::get('/', [HomeController::class, 'index'])->name('home.index');
// Load more posts endpoint for infinite scroll
Route::get('/posts/load-more', [HomeController::class, 'loadMore'])->name('posts.loadMore');
Route::get('/posts/{post:slug}', [HomeController::class, 'show'])->name('posts.show');


Route::get('/posts/{post:slug}/edit', [PostController::class, 'edit'])->name('posts.edit');
Route::put('/posts/{post:slug}', [PostController::class, 'update'])->name('posts.update');
Route::delete('/posts/{post:slug}/destroy', [PostController::class, 'destroy'])->name('posts.destroy');


Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/search/{id}', [SearchController::class, 'show'])->name('search.show');


Route::post('/posts/{post}/like', [PostController::class, 'like'])->name('posts.like');
Route::post('/posts/{post}/unlike', [PostController::class, 'unlike'])->name('posts.unlike');


Route::post('/posts/{id}/like', [PostController::class, 'like'])->name('posts.like');
Route::get('/posts/{postId}', ShowPost::class)->name('posts.show');


Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');


Route::get('/contact', function () {
    return view('contact');
})->name('contact');
Route::post('/contact', [ContactController::class, 'sendMail'])->name('contact.send');

// Ensure the user is authenticated to access the profile page
Route::middleware(['auth'])->get('/profile', [ProfileController::class, 'show'])->name('dashboard.profile');
Route::middleware(['auth'])->put('/profile', [ProfileController::class, 'update'])->name('profile.update');

Route::get('/users/{user}', [ProfessionalPostController::class, 'show'])->name('users.posts');


Route::get('auth/google', [GoogleController::class, 'redirect'])->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'callback']);

// Facebook OAuth Routes
Route::get('/auth/facebook/redirect', [FacebookController::class, 'redirect'])->name('auth.facebook');
Route::get('/auth/facebook/callback', [FacebookController::class, 'callback'])->name('callback');

Route::get('/auth/{provider}/redirect', [SocialiteController::class, 'redirectToProvider'])->name('social.redirect');
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'handleProviderCallback']);

Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::get('/refresh-csrf', function () {
    return response()->json(['token' => csrf_token()]);
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

// Notifications
Route::middleware('auth')->get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
Route::middleware('auth')->post('/notifications/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');


Route::get('/dashboard/create', [PostController::class, 'create'])->middleware(['auth'])->name('dashboard.create');
Route::post('/dashboard/create', [PostController::class, 'store'])->middleware(['auth'])->name('dashboard.store');
Route::get('/show{id}', [PostController::class, 'show'])->middleware(['auth'])->name('show');

Route::middleware(['auth', 'user_type:super_admin'])->group(function () {
    Route::get('/admin/dashboard', [UserManagementController::class, 'index'])->name('admin.dashboard');
    Route::PUT('/admin/users/{user}/user_type', [UserManagementController::class, 'updateRole'])->name('admin.updateRole');
});

Route::middleware('auth')->group(function () {
Route::get('/scan', [VirusScanController::class, 'index'])->name('scan.index');
Route::post('/scan', [VirusScanController::class, 'scanUrl'])->name('scan.submit');
});

require __DIR__.'/auth.php';


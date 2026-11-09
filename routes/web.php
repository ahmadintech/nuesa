<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Public;
use App\Http\Controllers\Student;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public NUESA Portal Routes
|--------------------------------------------------------------------------
*/
Route::get('/', Public\HomeController::class)->name('home');
Route::get('/about', Public\AboutController::class)->name('about');
Route::get('/resources', Public\ResourceController::class)->name('resources');
Route::get('/gallery', Public\GalleryController::class)->name('gallery');
Route::get('/album', Public\AlbumController::class)->name('album');
Route::get('/news', [Public\NewsController::class, 'index'])->name('news');
Route::get('/news/{slug}', [Public\NewsController::class, 'show'])->name('news.show');
Route::get('/team', Public\TeamController::class)->name('team');
Route::get('/contact', Public\ContactController::class)->name('contact');

use App\Http\Controllers\Auth\StudentAuthController;

Route::get('/login', [StudentAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [StudentAuthController::class, 'login'])->middleware('throttle:10,1')->name('login.submit');
Route::post('/logout', [StudentAuthController::class, 'logout'])->name('student.logout');

/*
|--------------------------------------------------------------------------
| Receipt Routes
|--------------------------------------------------------------------------
*/
Route::get('/receipt/download/{uuid}', [Student\ReceiptController::class, 'downloadReceipt'])->name('receipt.download');
Route::get('/receipt/demo', [Student\ReceiptController::class, 'generateDemoReceipt'])->name('receipt.demo');

/*
|--------------------------------------------------------------------------
| Student Portal Routes
|--------------------------------------------------------------------------
*/
Route::prefix('student')->name('student.')->middleware(\App\Http\Middleware\EnsureUserIsStudent::class)->group(function () {
    Route::get('/dashboard', Student\DashboardController::class)->name('dashboard');
    Route::get('/digital-id', Student\DigitalIdController::class)->name('digital-id');
    Route::get('/dues', [Student\DuesController::class, 'index'])->name('dues');

    Route::post('/pay-dues', [Student\DuesController::class, 'payDues'])->name('payDues');
    Route::get('/vault', [Student\VaultController::class, 'index'])->name('vault');

    Route::get('/elections', [Student\ElectionsController::class, 'index'])->name('elections');
    Route::post('/elections/vote', [Student\ElectionsController::class, 'vote'])->name('elections.vote');
    Route::get('/profile', [Student\ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [Student\ProfileController::class, 'update'])->name('profile.update');
});
Route::get('/dashboard', fn() => redirect()->route('student.dashboard'));


/*
|--------------------------------------------------------------------------
| Admin Executive Authentication & Portal Routes
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [Admin\AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [Admin\AdminAuthController::class, 'login'])->middleware('throttle:10,1')->name('admin.login.submit');
Route::post('/admin/logout', [Admin\AdminAuthController::class, 'logout'])->name('admin.logout');

Route::prefix('admin')->name('admin.')->middleware(\App\Http\Middleware\EnsureUserIsAdmin::class)->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [Admin\DashboardController::class, 'users'])->middleware('permission:manage-students')->name('users');
    Route::post('/users/{id}/toggle-verification', [Admin\DashboardController::class, 'toggleVerification'])->middleware('permission:manage-students')->name('users.toggleVerification');
    Route::delete('/users/{id}', [Admin\DashboardController::class, 'destroyUser'])->middleware('permission:manage-students')->name('users.destroy');

    Route::get('/payments', [Admin\DashboardController::class, 'payments'])->middleware('permission:manage-payments')->name('payments');
    Route::post('/payments', [Admin\PaymentController::class, 'store'])->middleware('permission:manage-payments')->name('payments.store');
    Route::post('/payments/{id}/approve', [Admin\PaymentController::class, 'approve'])->middleware('permission:manage-payments')->name('payments.approve');
    Route::delete('/payments/{id}', [Admin\PaymentController::class, 'destroy'])->middleware('permission:manage-payments')->name('payments.destroy');

    Route::get('/elections', [Admin\ElectionController::class, 'index'])->middleware('permission:manage-elections')->name('elections');
    Route::post('/elections/candidate', [Admin\ElectionController::class, 'storeCandidate'])->middleware('permission:manage-elections')->name('elections.candidate.store');
    Route::put('/elections/candidate/{id}', [Admin\ElectionController::class, 'updateCandidate'])->middleware('permission:manage-elections')->name('elections.candidate.update');
    Route::delete('/elections/candidate/{id}', [Admin\ElectionController::class, 'destroyCandidate'])->middleware('permission:manage-elections')->name('elections.candidate.destroy');
    Route::post('/elections/parameters', [Admin\ElectionController::class, 'updateParameters'])->middleware('permission:manage-elections')->name('elections.parameters.update');
    Route::post('/elections/status', [Admin\ElectionController::class, 'updateStatus'])->middleware('permission:manage-elections')->name('elections.status.update');
    Route::post('/elections/reset-votes', [Admin\ElectionController::class, 'resetVotes'])->middleware('permission:manage-elections')->name('elections.reset-votes');

    Route::get('/posts', [Admin\DashboardController::class, 'posts'])->middleware('permission:manage-posts')->name('posts');
    Route::get('/posts/create', [Admin\PostController::class, 'create'])->middleware('permission:manage-posts')->name('posts.create');
    Route::post('/posts', [Admin\PostController::class, 'store'])->middleware('permission:manage-posts')->name('posts.store');
    Route::get('/posts/{id}/edit', [Admin\PostController::class, 'edit'])->middleware('permission:manage-posts')->name('posts.edit');
    Route::put('/posts/{id}', [Admin\PostController::class, 'update'])->middleware('permission:manage-posts')->name('posts.update');
    Route::delete('/posts/{id}', [Admin\PostController::class, 'destroy'])->middleware('permission:manage-posts')->name('posts.destroy');

    Route::get('/about', [Admin\DashboardController::class, 'about'])->middleware('permission:manage-settings')->name('about');
    Route::post('/about/settings', [Admin\DashboardController::class, 'updateAboutSettings'])->middleware('permission:manage-settings')->name('about.settings.update');
    Route::post('/about/exco', [Admin\ExcoController::class, 'store'])->middleware('permission:manage-settings')->name('about.exco.store');
    Route::put('/about/exco/{id}', [Admin\ExcoController::class, 'update'])->middleware('permission:manage-settings')->name('about.exco.update');
    Route::delete('/about/exco/{id}', [Admin\ExcoController::class, 'destroy'])->middleware('permission:manage-settings')->name('about.exco.destroy');

    Route::get('/gallery', [Admin\DashboardController::class, 'gallery'])->middleware('permission:manage-gallery')->name('gallery');
    Route::post('/gallery', [Admin\GalleryController::class, 'store'])->middleware('permission:manage-gallery')->name('gallery.store');
    Route::delete('/gallery/{id}', [Admin\GalleryController::class, 'destroy'])->middleware('permission:manage-gallery')->name('gallery.destroy');

    Route::get('/album', [Admin\AlbumController::class, 'index'])->middleware('permission:manage-gallery')->name('album');
    Route::post('/album', [Admin\AlbumController::class, 'store'])->middleware('permission:manage-gallery')->name('album.store');
    Route::delete('/album/{id}', [Admin\AlbumController::class, 'destroy'])->middleware('permission:manage-gallery')->name('album.destroy');

    Route::get('/resources', [Admin\DashboardController::class, 'resources'])->middleware('permission:manage-vault')->name('resources');
    Route::post('/resources', [Admin\ResourceController::class, 'store'])->middleware('permission:manage-vault')->name('resources.store');
    Route::delete('/resources/{id}', [Admin\ResourceController::class, 'destroy'])->middleware('permission:manage-vault')->name('resources.destroy');

    Route::get('/staff', [Admin\DashboardController::class, 'staff'])->middleware('permission:manage-settings')->name('staff');
    Route::post('/staff', [Admin\StaffController::class, 'store'])->middleware('permission:manage-settings')->name('staff.store');
    Route::delete('/staff/{id}', [Admin\StaffController::class, 'destroy'])->middleware('permission:manage-settings')->name('staff.destroy');

    Route::get('/settings', [Admin\DashboardController::class, 'settings'])->middleware('permission:manage-settings')->name('settings');
    Route::post('/settings', [Admin\DashboardController::class, 'updateSettings'])->middleware('permission:manage-settings')->name('settings.update');

    Route::get('/notifications', [Admin\NotificationController::class, 'index'])->middleware('permission:send-notifications')->name('notifications.index');
    Route::post('/notifications/send', [Admin\NotificationController::class, 'store'])->middleware('permission:send-notifications')->name('notifications.send');
    Route::delete('/notifications/{id}', [Admin\NotificationController::class, 'destroy'])->middleware('permission:send-notifications')->name('notifications.destroy');
});




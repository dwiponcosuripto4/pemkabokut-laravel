<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\IconController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DropdownController;
use App\Http\Controllers\HeadlineController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BusinessController as AdminBusinessController;

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

// Route yang dapat diakses oleh guest atau tanpa login
Route::get('/', [PostController::class, 'index'])->name('home');
Route::resource('dropdown', DropdownController::class);
Route::get('/post/show/{id}', [PostController::class, 'show']);
Route::get('/search', [PostController::class, 'search'])->name('post.search');
Route::get('/headlines/show/{id}', [HeadlineController::class, 'show'])->name('headline.show');
Route::get('/data/show/{id}', [DataController::class, 'show'])->name('data.show');
Route::get('/document/show/{id}', [DocumentController::class, 'show'])->name('document.show');
Route::get('/file/show/{id}', [FileController::class, 'show'])->name('file.show');
Route::get('/file/download/{id}', [FileController::class, 'download'])->name('file.download');
Route::get('/file/serve/{id}', [FileController::class, 'serve'])->name('file.serve');

// Route UMKM yang dapat diakses publik (tanpa login)
Route::get('/umkm', [BusinessController::class, 'index'])->name('umkm.index');
Route::get('/umkm/create', [BusinessController::class, 'create'])->name('umkm.create');
Route::post('/umkm', [BusinessController::class, 'store'])->name('umkm.store');
Route::post('/umkm/expand-url', [BusinessController::class, 'expandUrl'])->name('umkm.expand-url');
Route::get('/umkm/{id}', [BusinessController::class, 'show'])->name('umkm.show');

// Route untuk dashboard yang hanya dapat diakses jika login dan terverifikasi
Route::get('admin/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('admin.dashboard');

// Route API untuk dashboard
Route::middleware(['auth', 'verified'])->prefix('admin/api')->group(function () {
    Route::get('/statistics', [DashboardController::class, 'getStatistics'])->name('admin.api.statistics');
    Route::get('/user-stats', [DashboardController::class, 'getUserStats'])->name('admin.api.user-stats');
    Route::get('/calendar-events', [DashboardController::class, 'getCalendarEvents'])->name('admin.api.calendar-events');
    Route::get('/pending-businesses', [AdminBusinessController::class, 'getPendingBusinesses'])->name('admin.api.pending-businesses');
});

// Admin Business Management Routes
Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('/businesses', [AdminBusinessController::class, 'index'])->name('admin.businesses.index');
    Route::get('/businesses/{business}', [AdminBusinessController::class, 'show'])->name('admin.businesses.show');
    Route::get('/businesses/{business}/edit', [AdminBusinessController::class, 'edit'])->name('admin.businesses.edit');
    Route::put('/businesses/{business}', [AdminBusinessController::class, 'update'])->name('admin.businesses.update');
    Route::post('/businesses/{business}/approve', [AdminBusinessController::class, 'approve'])->name('admin.businesses.approve');
    Route::post('/businesses/{business}/reject', [AdminBusinessController::class, 'reject'])->name('admin.businesses.reject');
    Route::delete('/businesses/{business}', [AdminBusinessController::class, 'destroy'])->name('admin.businesses.destroy');
    Route::post('/businesses/report', [AdminBusinessController::class, 'downloadBusinessReport'])->name('admin.businesses.report');
});

// Admin Profile Routes
Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('/profile', [App\Http\Controllers\Admin\AdminProfileController::class, 'show'])->name('admin.profile.show');
    Route::put('/profile', [App\Http\Controllers\Admin\AdminProfileController::class, 'update'])->name('admin.profile.update');
    Route::put('/profile/password', [App\Http\Controllers\Admin\AdminProfileController::class, 'updatePassword'])->name('admin.profile.update-password');
    Route::get('/profile/delete-photo', [App\Http\Controllers\Admin\AdminProfileController::class, 'deletePhoto'])->name('admin.profile.delete-photo');
});

// Admin Settings Routes
Route::middleware(['auth', 'verified'])->prefix('admin/settings')->group(function () {
    Route::post('/toggle-umkm-registration', [App\Http\Controllers\Admin\SettingController::class, 'toggleUmkmRegistration']);
    Route::post('/toggle-umkm-menu', [App\Http\Controllers\Admin\SettingController::class, 'toggleUmkmMenu']);
    Route::get('/get-umkm-settings', [App\Http\Controllers\Admin\SettingController::class, 'getUmkmSettings']);
});

// Admin User Management Routes
Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('admin.users.show');
    Route::post('/users/{user}/deactivate', [App\Http\Controllers\Admin\UserController::class, 'deactivate'])->name('admin.users.deactivate');
    Route::post('/users/{user}/activate', [App\Http\Controllers\Admin\UserController::class, 'activate'])->name('admin.users.activate');
    Route::post('/users/{user}/verify', [App\Http\Controllers\Admin\UserController::class, 'verify'])->name('admin.users.verify');
        Route::delete('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.user.destroy');
    Route::post('/users/{user}/reset-password', [App\Http\Controllers\Admin\UserController::class, 'resetPassword'])->name('admin.user.reset-password');
    Route::post('/users/report', [App\Http\Controllers\Admin\UserController::class, 'downloadReport'])->name('admin.users.report');
});

// Route untuk profile yang hanya dapat diakses oleh user setelah login
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route CRUD yang hanya dapat diakses setelah login
Route::middleware('auth')->group(function () {

    // Icon CRUD
    Route::resource('icon', IconController::class);
    Route::get('admin/icon/create', [IconController::class, 'create'])->name('icon.create');
    Route::post('admin/icon/store', [IconController::class, 'store'])->name('icon.store');
    Route::get('admin/icon/data', [IconController::class, 'data'])->name('icon.data');
    Route::get('admin/icon/edit/{id}', [IconController::class, 'edit'])->name('icon.edit');
    Route::put('admin/icon/update/{id}', [IconController::class, 'update'])->name('icon.update');
    Route::delete('admin/icon/delete/{id}', [IconController::class, 'destroy'])->name('icon.destroy');

    // Post CRUD
    Route::get('admin/post/data', [PostController::class, 'data'])->name('post.data');
    Route::get('admin/post/create', [PostController::class, 'create'])->name('post.create');
    Route::post('admin/post/store', [PostController::class, 'store'])->name('post.store');
    Route::get('admin/post/edit/{id}', [PostController::class, 'edit'])->name('post.edit');
    Route::put('admin/post/update/{id}', [PostController::class, 'update'])->name('post.update');
    Route::delete('admin/post/delete/{id}', [PostController::class, 'destroy'])->name('post.destroy');
    Route::post('admin/post/delete-image', [PostController::class, 'deleteImage']);
    Route::patch('admin/post/toggle-draft/{id}', [PostController::class, 'toggleDraft'])->name('admin.post.toggleDraft');
    Route::post('/admin/posts/report', [PostController::class, 'downloadPostReport'])->name('admin.posts.report');
    
    // Category CRUD
    Route::get('admin/category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('admin/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('admin/category/data', [CategoryController::class, 'data'])->name('category.data');
    Route::get('admin/category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('admin/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('admin/category/delete/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');

    // Headline CRUD
    Route::get('admin/headline/create', [HeadlineController::class, 'create'])->name('headline.create');
    Route::post('admin/headlines', [HeadlineController::class, 'store'])->name('headlines.store');
    Route::get('admin/headline/data', [HeadlineController::class, 'data'])->name('headline.data');
    Route::get('admin/headline/edit/{id}', [HeadlineController::class, 'edit'])->name('headline.edit');
    Route::post('admin/headline/update/{id}', [HeadlineController::class, 'update'])->name('headline.update');
    Route::delete('admin/headline/delete/{id}', [HeadlineController::class, 'destroy'])->name('headline.destroy');
    Route::get('/headlines/show/{id}', [HeadlineController::class, 'show'])->name('headline.show');
    
    // Data CRUD
    Route::get('admin/data/index', [DataController::class, 'index'])->name('data.index');
    Route::get('admin/data/create', [DataController::class, 'create'])->name('data.create');
    Route::post('admin/data', [DataController::class, 'store'])->name('data.store');
    Route::delete('admin/data/delete/{id}', [DataController::class, 'destroy'])->name('data.destroy');

        Route::get('admin/data/edit/{id}', [DataController::class, 'edit'])->name('data.edit');
        Route::put('admin/data/update/{id}', [DataController::class, 'update'])->name('data.update');

    // Document CRUD
    Route::get('admin/document/data', [DocumentController::class, 'data'])->name('document.data');
    Route::get('admin/document/create', [DocumentController::class, 'create'])->name('document.create');
    Route::post('admin/document', [DocumentController::class, 'store'])->name('document.store');
    Route::get('admin/document/show/{id}', [DocumentController::class, 'adminShow'])->name('document.admin.show');
    Route::get('admin/document/edit/{id}', [DocumentController::class, 'edit'])->name('document.edit');
    Route::patch('admin/document/update/{id}', [DocumentController::class, 'update'])->name('document.update');
    Route::delete('admin/document/delete/{id}', [DocumentController::class, 'destroy'])->name('document.destroy');
    Route::post('/admin/documents/report', [DocumentController::class, 'downloadDocumentReport'])->name('admin.documents.report');

    // File CRUD
    Route::get('admin/file/data', [FileController::class, 'data'])->name('file.data');
    Route::get('admin/file/edit/{id}', [FileController::class, 'edit'])->name('file.edit');
    Route::post('admin/file/update/{id}', [FileController::class, 'update'])->name('file.update');
    Route::delete('admin/file/{id}', [FileController::class, 'destroyAjax'])->name('file.destroy.ajax');
    Route::delete('admin/file/delete/{id}', [FileController::class, 'destroy'])->name('file.destroy');

});

require __DIR__.'/auth.php';
<?php

use App\Http\Controllers\ReportController;
use App\Livewire\Admin;
use App\Livewire\Dashboard;
use App\Livewire\Finance;
use App\Livewire\Landing;
use App\Livewire\Login;
use App\Livewire\News;
use App\Livewire\Profile;
use App\Livewire\Register;
use App\Livewire\Voting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Public landing page
Route::get('/', Landing::class)->name('home');

// Public news show (readable without login)
Route::get('/berita/{news}', News\Show::class)->name('news.show');

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/daftar', Register::class)->name('register');
});

// Logout
Route::post('/logout', function () {
    Auth::logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/');
})->middleware('auth')->name('logout');

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/profil', Profile::class)->name('profile');

    // Dashboard & Finance - only admin and bendahara
    Route::middleware('role:admin|bendahara')->group(function () {
        Route::get('/dashboard', Dashboard\Index::class)->name('dashboard');
        Route::get('/keuangan', Finance\Index::class)->name('finance.index');
        Route::get('/keuangan/laporan', [ReportController::class, 'finance'])->name('finance.report');
    });

    // Voting - accessible by all authenticated
    Route::get('/voting', Voting\Index::class)->name('voting.index');
    Route::get('/voting/{event}', Voting\Show::class)->name('voting.show');
    Route::get('/voting/{event}/vote', Voting\WargaShow::class)->name('voting.warga.show');

    // News management - accessible by all authenticated
    Route::get('/berita', News\Index::class)->name('news.index');

    // Admin only
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/pengguna', Admin\UserManagement::class)->name('admin.users');
        Route::get('/admin/gallery', Admin\GalleryManagement::class)->name('admin.gallery');
        Route::get('/admin/ketua', Admin\ChairmanManagement::class)->name('admin.chairman');
    });
});

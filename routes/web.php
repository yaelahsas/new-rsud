<?php

use Illuminate\Support\Facades\Route;

// Frontend Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::get('/medis', function () {
    return view('medis');
});
Route::get('/artikel', function () {
    return view('artikel');
});
Route::get('/inovasi', function () {
    return view('inovasi');
});

// Auth Routes
Route::match(['get', 'post'], '/admin', function () {
    return view('login.index');
})->name('login');

Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// Admin Routes (Protected)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard.index');
    })->name('admin.dashboard');
    
    // API Routes for Berita
    Route::get('/api/berita', [\App\Http\Controllers\API\BeritaController::class, 'index'])->name('api.berita.index');
    Route::get('/api/berita/kategoris', [\App\Http\Controllers\API\BeritaController::class, 'kategoris'])->name('api.berita.kategoris');
    Route::get('/api/berita/{id}', [\App\Http\Controllers\API\BeritaController::class, 'show'])->name('api.berita.show');
    Route::post('/api/berita', [\App\Http\Controllers\API\BeritaController::class, 'store'])->name('api.berita.store');
    Route::match(['put', 'post'], '/api/berita/{id}', [\App\Http\Controllers\API\BeritaController::class, 'update'])->name('api.berita.update');
    Route::delete('/api/berita/{id}', [\App\Http\Controllers\API\BeritaController::class, 'destroy'])->name('api.berita.destroy');
    
    // API Routes for Kategori
    Route::get('/api/kategori', [\App\Http\Controllers\API\KategoriController::class, 'index'])->name('api.kategori.index');
    Route::get('/api/kategori/{id}', [\App\Http\Controllers\API\KategoriController::class, 'show'])->name('api.kategori.show');
    Route::post('/api/kategori', [\App\Http\Controllers\API\KategoriController::class, 'store'])->name('api.kategori.store');
    Route::put('/api/kategori/{id}', [\App\Http\Controllers\API\KategoriController::class, 'update'])->name('api.kategori.update');
    Route::delete('/api/kategori/{id}', [\App\Http\Controllers\API\KategoriController::class, 'destroy'])->name('api.kategori.destroy');
    
    // API Routes for User
    Route::get('/api/user', [\App\Http\Controllers\API\UserController::class, 'index'])->name('api.user.index');
    Route::get('/api/user/{id}', [\App\Http\Controllers\API\UserController::class, 'show'])->name('api.user.show');
    Route::post('/api/user', [\App\Http\Controllers\API\UserController::class, 'store'])->name('api.user.store');
    Route::put('/api/user/{id}', [\App\Http\Controllers\API\UserController::class, 'update'])->name('api.user.update');
    Route::delete('/api/user/{id}', [\App\Http\Controllers\API\UserController::class, 'destroy'])->name('api.user.destroy');
    
    // API Routes for Poli
    Route::get('/api/poli', [\App\Http\Controllers\API\PoliController::class, 'index'])->name('api.poli.index');
    Route::get('/api/poli/{id}', [\App\Http\Controllers\API\PoliController::class, 'show'])->name('api.poli.show');
    Route::post('/api/poli', [\App\Http\Controllers\API\PoliController::class, 'store'])->name('api.poli.store');
    Route::put('/api/poli/{id}', [\App\Http\Controllers\API\PoliController::class, 'update'])->name('api.poli.update');
    Route::delete('/api/poli/{id}', [\App\Http\Controllers\API\PoliController::class, 'destroy'])->name('api.poli.destroy');
    
    // API Routes for Dokter
    Route::get('/api/dokter', [\App\Http\Controllers\API\DokterController::class, 'index'])->name('api.dokter.index');
    Route::get('/api/dokter/polis', [\App\Http\Controllers\API\DokterController::class, 'polis'])->name('api.dokter.polis');
    Route::get('/api/dokter/{id}', [\App\Http\Controllers\API\DokterController::class, 'show'])->name('api.dokter.show');
    Route::post('/api/dokter', [\App\Http\Controllers\API\DokterController::class, 'store'])->name('api.dokter.store');
    Route::put('/api/dokter/{id}', [\App\Http\Controllers\API\DokterController::class, 'update'])->name('api.dokter.update');
    Route::delete('/api/dokter/{id}', [\App\Http\Controllers\API\DokterController::class, 'destroy'])->name('api.dokter.destroy');
    
    // API Routes for Jadwal Poli
    Route::get('/api/jadwal-poli', [\App\Http\Controllers\API\JadwalPoliController::class, 'index'])->name('api.jadwal-poli.index');
    Route::get('/api/jadwal-poli/dokters', [\App\Http\Controllers\API\JadwalPoliController::class, 'dokters'])->name('api.jadwal-poli.dokters');
    Route::get('/api/jadwal-poli/polis', [\App\Http\Controllers\API\JadwalPoliController::class, 'polis'])->name('api.jadwal-poli.polis');
    Route::get('/api/jadwal-poli/{id}', [\App\Http\Controllers\API\JadwalPoliController::class, 'show'])->name('api.jadwal-poli.show');
    Route::post('/api/jadwal-poli', [\App\Http\Controllers\API\JadwalPoliController::class, 'store'])->name('api.jadwal-poli.store');
    Route::put('/api/jadwal-poli/{id}', [\App\Http\Controllers\API\JadwalPoliController::class, 'update'])->name('api.jadwal-poli.update');
    Route::delete('/api/jadwal-poli/{id}', [\App\Http\Controllers\API\JadwalPoliController::class, 'destroy'])->name('api.jadwal-poli.destroy');
    
    // API Routes for Carousel
    Route::get('/api/carousel', [\App\Http\Controllers\API\CarouselController::class, 'index'])->name('api.carousel.index');
    Route::get('/api/carousel/{id}', [\App\Http\Controllers\API\CarouselController::class, 'show'])->name('api.carousel.show');
    Route::post('/api/carousel', [\App\Http\Controllers\API\CarouselController::class, 'store'])->name('api.carousel.store');
    Route::put('/api/carousel/{id}', [\App\Http\Controllers\API\CarouselController::class, 'update'])->name('api.carousel.update');
    Route::delete('/api/carousel/{id}', [\App\Http\Controllers\API\CarouselController::class, 'destroy'])->name('api.carousel.destroy');
    Route::put('/api/carousel/{id}/toggle', [\App\Http\Controllers\API\CarouselController::class, 'toggleStatus'])->name('api.carousel.toggle');
    
    // Dashboard API Routes
    Route::get('/api/dashboard/stats', [\App\Http\Controllers\API\DashboardController::class, 'stats'])->name('api.dashboard.stats');
    Route::get('/api/dashboard/recent-berita', [\App\Http\Controllers\API\DashboardController::class, 'recentBerita'])->name('api.dashboard.recent-berita');
    Route::get('/api/dashboard/recent-users', [\App\Http\Controllers\API\DashboardController::class, 'recentUsers'])->name('api.dashboard.recent-users');
    Route::get('/api/dashboard/monthly-data', [\App\Http\Controllers\API\DashboardController::class, 'monthlyData'])->name('api.dashboard.monthly-data');
    
    // Alpine.js Routes
    Route::get('/dashboard', function () {
        return view('admin.dashboard.alpine-index');
    })->name('admin.dashboard');
    Route::get('/kategori', function () {
        return view('admin.kategori.alpine-index');
    })->name('admin.kategori');
    Route::get('/users', function () {
        return view('admin.user.alpine-index');
    })->name('admin.users');
    Route::get('/poli', function () {
        return view('admin.poli.alpine-index');
    })->name('admin.poli');
    Route::get('/dokter', function () {
        return view('admin.dokter.alpine-index');
    })->name('admin.dokter');
    Route::get('/berita', function () {
        return view('admin.berita.alpine-index');
    })->name('admin.berita');
    Route::get('/jadwal-poli', function () {
        return view('admin.jadwal-poli.alpine-index');
    })->name('admin.jadwal-poli');
    Route::get('/carousel', function () {
        return view('admin.carousel.alpine-index');
    })->name('admin.carousel');
});
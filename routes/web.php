<?php

use Illuminate\Support\Facades\Route;

// Frontend Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::get('/medis', function () {
    return view('medis');
});
Route::get('/layanan', function () {
    return view('layanan');
});
Route::get('/artikel', function () {
    return view('artikel');
});
Route::get('/artikel/{slug}', function ($slug) {
    return view('DetailArtikel', ['slug' => $slug]);
})->name('artikel.detail');
Route::get('/inovasi', function () {
    return view('inovasi');
});

// API Routes for Frontend Search
Route::get('/api/search', function (Illuminate\Http\Request $request) {
    $query = $request->get('q', '');
    $results = [];
    
    if (strlen($query) >= 2) {
        // Search doctors
        $doctors = App\Models\Dokter::where('nama', 'like', '%' . $query . '%')
            ->orWhere('spesialis', 'like', '%' . $query . '%')
            ->where('status', 'aktif')
            ->limit(5)
            ->get(['id', 'nama', 'spesialis', 'foto']);
            
        foreach ($doctors as $doctor) {
            $results[] = [
                'id' => $doctor->id,
                'title' => $doctor->nama,
                'description' => $doctor->spesialis,
                'category' => 'doctors',
                'url' => '/medis?search=' . urlencode($doctor->nama),
                'image' => $doctor->foto ? '/storage/' . $doctor->foto : null
            ];
        }
        
        // Search poliklinik
        $polis = App\Models\Poli::where('nama_poli', 'like', '%' . $query . '%')
            ->where('status', 'aktif')
            ->limit(3)
            ->get(['id', 'nama_poli']);
            
        foreach ($polis as $poli) {
            $results[] = [
                'id' => 'poli-' . $poli->id,
                'title' => $poli->nama_poli,
                'description' => 'Poliklinik',
                'category' => 'services',
                'url' => '/medis?search=' . urlencode($poli->nama_poli),
                'image' => null
            ];
        }
        
        // Search articles/berita
        $articles = App\Models\Berita::where('judul', 'like', '%' . $query . '%')
            ->orWhere('konten', 'like', '%' . $query . '%')
            ->where('status', 'publish')
            ->limit(3)
            ->get(['id', 'judul', 'konten', 'gambar']);
            
        foreach ($articles as $article) {
            $results[] = [
                'id' => 'article-' . $article->id,
                'title' => $article->judul,
                'description' => substr(strip_tags($article->konten), 0, 100) . '...',
                'category' => 'articles',
                'url' => '/artikel#' . $article->id,
                'image' => $article->gambar ? '/storage/' . $article->gambar : null
            ];
        }
    }
    
    return response()->json([
        'success' => true,
        'results' => $results
    ]);
});

// Public API Routes for Frontend
Route::get('/api/articles', [\App\Http\Controllers\API\FrontendController::class, 'articles'])->name('api.articles');
Route::get('/api/article-categories', [\App\Http\Controllers\API\FrontendController::class, 'articleCategories'])->name('api.article-categories');
Route::get('/api/article-tags', [\App\Http\Controllers\API\FrontendController::class, 'articleTags'])->name('api.article-tags');
Route::get('/api/article/{slug}', [\App\Http\Controllers\API\FrontendController::class, 'article'])->name('api.article');
Route::get('/api/article/{id}/comments', [\App\Http\Controllers\API\FrontendController::class, 'articleComments'])->name('api.article.comments');
Route::post('/api/article/{id}/comment', [\App\Http\Controllers\API\FrontendController::class, 'submitArticleComment'])->name('api.article.comment.submit');

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
    
    // API Routes for Galeri
    Route::get('/api/galeri', [\App\Http\Controllers\API\GaleriController::class, 'index'])->name('api.galeri.index');
    Route::get('/api/galeri/kategoris', [\App\Http\Controllers\API\GaleriController::class, 'kategoris'])->name('api.galeri.kategoris');
    Route::post('/api/galeri', [\App\Http\Controllers\API\GaleriController::class, 'store'])->name('api.galeri.store');
    Route::get('/api/galeri/{id}', [\App\Http\Controllers\API\GaleriController::class, 'show'])->name('api.galeri.show');
    Route::put('/api/galeri/{id}', [\App\Http\Controllers\API\GaleriController::class, 'update'])->name('api.galeri.update');
    Route::delete('/api/galeri/{id}', [\App\Http\Controllers\API\GaleriController::class, 'destroy'])->name('api.galeri.destroy');
    
    // API Routes for Inovasi
    Route::get('/api/inovasi', [\App\Http\Controllers\API\InovasiController::class, 'index'])->name('api.inovasi.index');
    Route::post('/api/inovasi', [\App\Http\Controllers\API\InovasiController::class, 'store'])->name('api.inovasi.store');
    Route::get('/api/inovasi/{id}', [\App\Http\Controllers\API\InovasiController::class, 'show'])->name('api.inovasi.show');
    Route::put('/api/inovasi/{id}', [\App\Http\Controllers\API\InovasiController::class, 'update'])->name('api.inovasi.update');
    Route::delete('/api/inovasi/{id}', [\App\Http\Controllers\API\InovasiController::class, 'destroy'])->name('api.inovasi.destroy');
    
    // API Routes for Pengumuman
    Route::get('/api/pengumuman', [\App\Http\Controllers\API\PengumumanController::class, 'index'])->name('api.pengumuman.index');
    Route::post('/api/pengumuman', [\App\Http\Controllers\API\PengumumanController::class, 'store'])->name('api.pengumuman.store');
    Route::get('/api/pengumuman/{id}', [\App\Http\Controllers\API\PengumumanController::class, 'show'])->name('api.pengumuman.show');
    Route::put('/api/pengumuman/{id}', [\App\Http\Controllers\API\PengumumanController::class, 'update'])->name('api.pengumuman.update');
    Route::delete('/api/pengumuman/{id}', [\App\Http\Controllers\API\PengumumanController::class, 'destroy'])->name('api.pengumuman.destroy');
    
    // API Routes for Kontak
    Route::get('/api/kontak', [\App\Http\Controllers\API\KontakController::class, 'index'])->name('api.kontak.index');
    Route::post('/api/kontak', [\App\Http\Controllers\API\KontakController::class, 'store'])->name('api.kontak.store');
    Route::get('/api/kontak/{id}', [\App\Http\Controllers\API\KontakController::class, 'show'])->name('api.kontak.show');
    Route::put('/api/kontak/{id}', [\App\Http\Controllers\API\KontakController::class, 'update'])->name('api.kontak.update');
    Route::delete('/api/kontak/{id}', [\App\Http\Controllers\API\KontakController::class, 'destroy'])->name('api.kontak.destroy');
    
    // API Routes for Log Aktivitas
    Route::get('/api/log-aktivitas', [\App\Http\Controllers\API\LogAktivitasController::class, 'index'])->name('api.log-aktivitas.index');
    Route::get('/api/log-aktivitas/modules', [\App\Http\Controllers\API\LogAktivitasController::class, 'modules'])->name('api.log-aktivitas.modules');
    Route::get('/api/log-aktivitas/users', [\App\Http\Controllers\API\LogAktivitasController::class, 'users'])->name('api.log-aktivitas.users');
    Route::get('/api/log-aktivitas/{id}', [\App\Http\Controllers\API\LogAktivitasController::class, 'show'])->name('api.log-aktivitas.show');
    Route::delete('/api/log-aktivitas/{id}', [\App\Http\Controllers\API\LogAktivitasController::class, 'destroy'])->name('api.log-aktivitas.destroy');
    Route::post('/api/log-aktivitas/clear', [\App\Http\Controllers\API\LogAktivitasController::class, 'clearOldLogs'])->name('api.log-aktivitas.clear');
    
    // API Routes for Settings
    Route::get('/api/setting', [\App\Http\Controllers\API\SettingController::class, 'index'])->name('api.setting.index');
    Route::get('/api/setting/categories', [\App\Http\Controllers\API\SettingController::class, 'categories'])->name('api.setting.categories');
    Route::post('/api/setting', [\App\Http\Controllers\API\SettingController::class, 'store'])->name('api.setting.store');
    Route::get('/api/setting/{id}', [\App\Http\Controllers\API\SettingController::class, 'show'])->name('api.setting.show');
    Route::put('/api/setting/{id}', [\App\Http\Controllers\API\SettingController::class, 'update'])->name('api.setting.update');
    Route::delete('/api/setting/{id}', [\App\Http\Controllers\API\SettingController::class, 'destroy'])->name('api.setting.destroy');
    Route::post('/api/setting/bulk', [\App\Http\Controllers\API\SettingController::class, 'bulkUpdate'])->name('api.setting.bulk');
    
    // API Routes for Review
    Route::get('/api/review', [\App\Http\Controllers\API\ReviewController::class, 'index'])->name('api.review.index');
    Route::get('/api/review/inovasis', [\App\Http\Controllers\API\ReviewController::class, 'inovasis'])->name('api.review.inovasis');
    Route::post('/api/review', [\App\Http\Controllers\API\ReviewController::class, 'store'])->name('api.review.store');
    Route::get('/api/review/{id}', [\App\Http\Controllers\API\ReviewController::class, 'show'])->name('api.review.show');
    Route::put('/api/review/{id}', [\App\Http\Controllers\API\ReviewController::class, 'update'])->name('api.review.update');
    Route::delete('/api/review/{id}', [\App\Http\Controllers\API\ReviewController::class, 'destroy'])->name('api.review.destroy');
    
    // Alpine.js Routes
    Route::get('/dashboard', function () {
        return view('admin.dashboard.alpine-index');
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
    
    // API Routes for Carousel
    Route::get('/api/carousel', [\App\Http\Controllers\API\CarouselController::class, 'index'])->name('api.carousel.index');
    Route::get('/api/carousel/{id}', [\App\Http\Controllers\API\CarouselController::class, 'show'])->name('api.carousel.show');
    Route::post('/api/carousel', [\App\Http\Controllers\API\CarouselController::class, 'store'])->name('api.carousel.store');
    Route::match(['put', 'post'], '/api/carousel/{id}', [\App\Http\Controllers\API\CarouselController::class, 'update'])->name('api.carousel.update');
    Route::delete('/api/carousel/{id}', [\App\Http\Controllers\API\CarouselController::class, 'destroy'])->name('api.carousel.destroy');
    Route::put('/api/carousel/{id}/toggle', [\App\Http\Controllers\API\CarouselController::class, 'toggleStatus'])->name('api.carousel.toggle');
    
    // API Routes for Dokter
    Route::get('/api/dokter', [\App\Http\Controllers\API\DokterController::class, 'index'])->name('api.dokter.index');
    Route::get('/api/dokter/{id}', [\App\Http\Controllers\API\DokterController::class, 'show'])->name('api.dokter.show');
    Route::post('/api/dokter', [\App\Http\Controllers\API\DokterController::class, 'store'])->name('api.dokter.store');
    Route::put('/api/dokter/{id}', [\App\Http\Controllers\API\DokterController::class, 'update'])->name('api.dokter.update');
    Route::delete('/api/dokter/{id}', [\App\Http\Controllers\API\DokterController::class, 'destroy'])->name('api.dokter.destroy');
    
    // API Routes for Poli
    Route::get('/api/poli', [\App\Http\Controllers\API\PoliController::class, 'index'])->name('api.poli.index');
    Route::get('/api/poli/{id}', [\App\Http\Controllers\API\PoliController::class, 'show'])->name('api.poli.show');
    Route::post('/api/poli', [\App\Http\Controllers\API\PoliController::class, 'store'])->name('api.poli.store');
    Route::put('/api/poli/{id}', [\App\Http\Controllers\API\PoliController::class, 'update'])->name('api.poli.update');
    Route::delete('/api/poli/{id}', [\App\Http\Controllers\API\PoliController::class, 'destroy'])->name('api.poli.destroy');
    
    // API Routes for Jadwal Poli
    Route::get('/api/jadwal-poli', [\App\Http\Controllers\API\JadwalPoliController::class, 'index'])->name('api.jadwal-poli.index');
    Route::get('/api/jadwal-poli/{id}', [\App\Http\Controllers\API\JadwalPoliController::class, 'show'])->name('api.jadwal-poli.show');
    Route::post('/api/jadwal-poli', [\App\Http\Controllers\API\JadwalPoliController::class, 'store'])->name('api.jadwal-poli.store');
    Route::put('/api/jadwal-poli/{id}', [\App\Http\Controllers\API\JadwalPoliController::class, 'update'])->name('api.jadwal-poli.update');
    Route::delete('/api/jadwal-poli/{id}', [\App\Http\Controllers\API\JadwalPoliController::class, 'destroy'])->name('api.jadwal-poli.destroy');
    
    // API Routes for Dashboard
    Route::get('/api/dashboard/stats', [\App\Http\Controllers\API\DashboardController::class, 'stats'])->name('api.dashboard.stats');
    Route::get('/api/dashboard/recent-berita', [\App\Http\Controllers\API\DashboardController::class, 'recentBerita'])->name('api.dashboard.recent-berita');
    Route::get('/api/dashboard/recent-users', [\App\Http\Controllers\API\DashboardController::class, 'recentUsers'])->name('api.dashboard.recent-users');
    Route::get('/api/dashboard/monthly-data', [\App\Http\Controllers\API\DashboardController::class, 'monthlyData'])->name('api.dashboard.monthly-data');
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
    
    // Alpine.js Routes for new features
    Route::get('/galeri', function () {
        return view('admin.galeri.alpine-index');
    })->name('admin.galeri');
    Route::get('/inovasi', function () {
        return view('admin.inovasi.alpine-index');
    })->name('admin.inovasi');
    Route::get('/pengumuman', function () {
        return view('admin.pengumuman.alpine-index');
    })->name('admin.pengumuman');
    Route::get('/kontak', function () {
        return view('admin.kontak.alpine-index');
    })->name('admin.kontak');
    Route::get('/log-aktivitas', function () {
        return view('admin.log-aktivitas.alpine-index');
    })->name('admin.log-aktivitas');
    Route::get('/setting', function () {
        return view('admin.setting.alpine-index');
    })->name('admin.setting');
    Route::get('/review', function () {
        return view('admin.review.alpine-index');
    })->name('admin.review');
});
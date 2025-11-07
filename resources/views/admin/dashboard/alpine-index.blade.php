<x-admin.index>
<x-slot:title>Dashboard</x-slot:title>
<x-slot:judul>Dashboard Overview</x-slot:judul>

<style>
/* ===== GLOBAL ===== */
body {
  background: #f4f6fa;
  font-family: 'Inter', 'Poppins', sans-serif;
  color: #1e293b;
}

/* Smooth animation */
.fade-in-up {
  animation: fadeInUp 0.8s ease-in-out;
}
@keyframes fadeInUp {
  from {opacity: 0; transform: translateY(20px);}
  to {opacity: 1; transform: translateY(0);}
}

/* ===== HEADER ===== */
.dashboard-header {
  background: linear-gradient(135deg, #6366f1, #3b82f6);
  border-radius: 16px;
  padding: 24px 30px;
  box-shadow: 0 4px 16px rgba(99, 102, 241, 0.2);
  color: white;
}
.dashboard-title i {
  color: #fff !important;
}
.dashboard-subtitle {
  color: rgba(255,255,255,0.85) !important;
}
.btn-modern {
  border-radius: 12px;
  padding: 8px 16px;
  transition: all 0.25s ease;
}
.btn-primary-modern {
  background: linear-gradient(135deg, #6366f1, #3b82f6);
  color: #fff;
  border: none;
}
.btn-primary-modern:hover {
  background: linear-gradient(135deg, #4f46e5, #2563eb);
}
.btn-info-modern {
  background: linear-gradient(135deg, #06b6d4, #3b82f6);
  color: #fff;
  border: none;
}
.btn-info-modern:hover {
  background: linear-gradient(135deg, #0ea5e9, #2563eb);
}

/* ===== STAT CARDS ===== */
.modern-stat-card {
  border: none;
  border-radius: 20px;
  background: #fff;
  box-shadow: 0 4px 20px rgba(0,0,0,0.05);
  padding: 24px;
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
}
.modern-stat-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}
.stat-icon {
  font-size: 36px;
  margin-bottom: 12px;
}
.stat-value {
  font-size: 2rem;
  font-weight: 700;
  color: #1e293b;
}
.stat-label {
  font-size: 0.9rem;
  color: #64748b;
}

/* ===== COLOR VARIANTS ===== */
.modern-stat-card.primary { border-top: 4px solid #6366f1; }
.modern-stat-card.success { border-top: 4px solid #10b981; }
.modern-stat-card.warning { border-top: 4px solid #f59e0b; }
.modern-stat-card.info    { border-top: 4px solid #06b6d4; }

/* ===== CARDS ===== */
.modern-card {
  border: none;
  border-radius: 20px;
  background: #fff;
  box-shadow: 0 6px 24px rgba(0,0,0,0.05);
  transition: all 0.3s ease;
}
.modern-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 24px rgba(0,0,0,0.1);
}
.card-header {
  border-bottom: none;
  background: transparent;
  padding: 1rem 1.25rem;
}
.card-title {
  font-weight: 600;
  color: #1e293b;
}
.card-body {
  padding: 1.25rem 1.5rem;
}

/* ===== TABLE ===== */
.table-modern {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
}
.table-modern thead th {
  background: #f8fafc;
  border-bottom: 2px solid #e2e8f0;
  color: #334155;
  font-weight: 600;
}
.table-modern tbody tr:hover {
  background: #f1f5f9;
  transition: 0.2s;
}
.user-avatar {
  position: relative;
}
.user-status {
  position: absolute;
  bottom: 2px;
  right: 2px;
  width: 10px;
  height: 10px;
  border-radius: 50%;
  border: 2px solid #fff;
}
.status-success { background: #10b981; }
.status-danger { background: #ef4444; }

/* ===== PROGRESS BAR ===== */
.progress-bar {
  border-radius: 6px;
}

/* ===== ACTIVITY FEED ===== */
.activity-feed {
  border-left: 2px solid #e2e8f0;
  margin-left: 10px;
  padding-left: 20px;
}
.activity-item {
  margin-bottom: 12px;
  position: relative;
}
.activity-dot {
  width: 12px;
  height: 12px;
  border-radius: 50%;
  position: absolute;
  left: -7px;
  top: 4px;
}

/* ===== PAGINATION ===== */
.pagination .page-item.active .page-link {
  background-color: #6366f1;
  border-color: #6366f1;
  color: #fff;
}
.pagination .page-link {
  border-radius: 8px;
}

/* ===== SMALL DETAILS ===== */
.empty-state i {
  opacity: 0.5;
}
.badge-modern {
  padding: 6px 10px;
  border-radius: 8px;
  font-weight: 600;
}
.badge-info-modern {
  background: rgba(99,102,241,0.15);
  color: #3b82f6;
}
.badge-danger-modern {
  background: rgba(239,68,68,0.15);
  color: #ef4444;
}

[x-cloak] {
    display: none !important;
}
</style>

<div x-data="dashboardManager" x-init="init()" x-cloak class="dashboard-container fade-in-up">
<!-- Page Header -->
<div class="dashboard-header mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="dashboard-title">
                <i class="fas fa-tachometer-alt text-primary mr-2"></i>
                Dashboard Overview
            </h1>
            <p class="dashboard-subtitle text-muted mb-0">
                Selamat datang kembali! Berikut ringkasan aktivitas sistem RSUD hari ini.
            </p>
        </div>
        <div class="col-md-6 text-md-right mt-3 mt-md-0">
            <div class="dashboard-actions">
                <button type="button" class="btn btn-primary-modern btn-modern mr-2" @click="exportData()">
                    <i class="fas fa-download mr-2"></i>Export Report
                </button>
                <button type="button" class="btn btn-info-modern btn-modern" @click="refreshAll()">
                    <i class="fas fa-sync-alt mr-2"></i>Refresh
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modern Statistics Cards -->
<div class="row">
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="modern-stat-card primary bounce-in" style="animation-delay: 0.1s;">
            <div class="stat-icon primary">
                <i class="fas fa-newspaper"></i>
            </div>
            <div class="stat-value" x-text="stats.total_berita || 0"></div>
            <div class="stat-label">Total Berita</div>
            <div class="stat-progress mt-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <small class="text-muted">Publikasi</small>
                    <small class="text-success font-weight-600" x-text="stats.berita_publish || 0"></small>
                </div>
                <div class="progress" style="height: 4px;">
                    <div class="progress-bar bg-success" role="progressbar"
                         :style="`width: ${stats.total_berita > 0 ? (stats.berita_publish / stats.total_berita) * 100 : 0}%`"
                         :aria-valuenow="stats.berita_publish || 0"
                         aria-valuemin="0"
                         :aria-valuemax="stats.total_berita || 0">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="modern-stat-card success bounce-in" style="animation-delay: 0.2s;">
            <div class="stat-icon success">
                <i class="fas fa-user-md"></i>
            </div>
            <div class="stat-value" x-text="stats.total_dokter || 0"></div>
            <div class="stat-label">Total Dokter</div>
            <div class="stat-progress mt-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <small class="text-muted">Aktif</small>
                    <small class="text-success font-weight-600" x-text="stats.dokter_aktif || 0"></small>
                </div>
                <div class="progress" style="height: 4px;">
                    <div class="progress-bar bg-success" role="progressbar"
                         :style="`width: ${stats.total_dokter > 0 ? (stats.dokter_aktif / stats.total_dokter) * 100 : 0}%`"
                         :aria-valuenow="stats.dokter_aktif || 0"
                         aria-valuemin="0"
                         :aria-valuemax="stats.total_dokter || 0">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="modern-stat-card warning bounce-in" style="animation-delay: 0.3s;">
            <div class="stat-icon warning">
                <i class="fas fa-hospital"></i>
            </div>
            <div class="stat-value" x-text="stats.total_poli || 0"></div>
            <div class="stat-label">Total Poli</div>
            <div class="stat-progress mt-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <small class="text-muted">Operasional</small>
                    <small class="text-success font-weight-600" x-text="stats.poli_aktif || 0"></small>
                </div>
                <div class="progress" style="height: 4px;">
                    <div class="progress-bar bg-warning" role="progressbar"
                         :style="`width: ${stats.total_poli > 0 ? (stats.poli_aktif / stats.total_poli) * 100 : 0}%`"
                         :aria-valuenow="stats.poli_aktif || 0"
                         aria-valuemin="0"
                         :aria-valuemax="stats.total_poli || 0">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="modern-stat-card info bounce-in" style="animation-delay: 0.4s;">
            <div class="stat-icon info">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-value" x-text="stats.total_user || 0"></div>
            <div class="stat-label">Total User</div>
            <div class="stat-progress mt-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <small class="text-muted">Admin</small>
                    <small class="text-danger font-weight-600" x-text="stats.admin_users || 0"></small>
                </div>
                <div class="progress" style="height: 4px;">
                    <div class="progress-bar bg-info" role="progressbar"
                         :style="`width: ${stats.total_user > 0 ? (stats.admin_users / stats.total_user) * 100 : 0}%`"
                         :aria-valuenow="stats.admin_users || 0"
                         aria-valuemin="0"
                         :aria-valuemax="stats.total_user || 0">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats Overview -->
<div class="row mb-4">
    <div class="col-md-6 mb-4">
        <div class="card modern-card slide-in-left">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-line text-primary mr-2"></i>
                    Statistik Berita
                </h5>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6 mb-3">
                        <div class="stat-item">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon success mini-stat-icon">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="ml-3">
                                    <div class="stat-value" x-text="stats.berita_publish || 0"></div>
                                    <div class="stat-label">Diterbitkan</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="stat-item">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon warning mini-stat-icon">
                                    <i class="fas fa-edit"></i>
                                </div>
                                <div class="ml-3">
                                    <div class="stat-value" x-text="stats.berita_draft || 0"></div>
                                    <div class="stat-label">Draft</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mini-chart-container">
                            <canvas id="beritaMiniChart" height="60"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card modern-card slide-in-right">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-pie text-info mr-2"></i>
                    Statistik Lainnya
                </h5>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6 mb-3">
                        <div class="stat-item">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon info mini-stat-icon">
                                    <i class="fas fa-images"></i>
                                </div>
                                <div class="ml-3">
                                    <div class="stat-value" x-text="stats.carousel_aktif || 0"></div>
                                    <div class="stat-label">Carousel Aktif</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="stat-item">
                            <div class="d-flex align-items-center">
                                <div class="stat-icon primary mini-stat-icon">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <div class="ml-3">
                                    <div class="stat-value" x-text="stats.jadwal_hari_ini || 0"></div>
                                    <div class="stat-label">Jadwal Hari Ini</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="activity-feed">
                            <div class="activity-item">
                                <div class="activity-dot bg-success"></div>
                                <div class="activity-content">
                                    <small class="text-muted">2 menit lalu</small>
                                    <p class="mb-0">Berita baru diterbitkan</p>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-dot bg-info"></div>
                                <div class="activity-content">
                                    <small class="text-muted">15 menit lalu</small>
                                    <p class="mb-0">Carousel diperbarui</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Analytics Dashboard -->
<div class="row mb-4">
    <div class="col-lg-8 mb-4">
        <div class="card modern-card slide-in-up">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-area text-primary mr-2"></i>
                        Analytics Overview
                    </h5>
                    <p class="card-subtitle text-muted mb-0">Grafik Berita Per Bulan</p>
                </div>
                <div class="card-tools">
                    <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-outline-secondary active" data-period="month">Bulan</button>
                        <button type="button" class="btn btn-outline-secondary" data-period="week">Minggu</button>
                        <button type="button" class="btn btn-outline-secondary" data-period="day">Hari</button>
                    </div>
                    <button type="button" class="btn btn-tool btn-sm ml-2" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool btn-sm" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="beritaChart" height="120"></canvas>
                </div>
                <div class="row mt-4">
                    <div class="col-md-3 col-6 text-center">
                        <div class="chart-summary">
                            <h6 class="text-muted mb-1">Total</h6>
                            <h4 class="mb-0 text-primary" x-text="monthlyData.reduce((a, b) => a + b, 0)"></h4>
                            <small class="text-success"><i class="fas fa-arrow-up"></i> 12%</small>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 text-center">
                        <div class="chart-summary">
                            <h6 class="text-muted mb-1">Rata-rata</h6>
                            <h4 class="mb-0 text-info" x-text="monthlyData.length > 0 ? Math.round(monthlyData.reduce((a, b) => a + b, 0) / monthlyData.length) : 0"></h4>
                            <small class="text-success"><i class="fas fa-arrow-up"></i> 8%</small>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 text-center">
                        <div class="chart-summary">
                            <h6 class="text-muted mb-1">Tertinggi</h6>
                            <h4 class="mb-0 text-success" x-text="monthlyData.length > 0 ? Math.max(...monthlyData) : 0"></h4>
                            <small class="text-muted">Mei</small>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 text-center">
                        <div class="chart-summary">
                            <h6 class="text-muted mb-1">Terendah</h6>
                            <h4 class="mb-0 text-warning" x-text="monthlyData.length > 0 ? Math.min(...monthlyData) : 0"></h4>
                            <small class="text-muted">Feb</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 mb-4">
        <div class="card modern-card slide-in-up" style="animation-delay: 0.1s;">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-newspaper text-info mr-2"></i>
                    Berita Terbaru
                </h5>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="recent-news-list">
                    <template x-for="berita in recentBerita" :key="berita.id">
                        <div class="news-item">
                            <div class="news-content">
                                <h6 class="news-title" x-text="berita.judul ? berita.judul.substring(0, 40) + (berita.judul.length > 40 ? '...' : '') : ''"></h6>
                                <div class="news-meta">
                                    <span class="text-muted">
                                        <i class="fas fa-user-circle"></i> <span x-text="berita.author ? berita.author.nama : 'Admin'"></span>
                                    </span>
                                    <span class="news-time badge badge-info-modern" x-text="berita.created_at ? new Date(berita.created_at).toLocaleDateString('id-ID') : ''"></span>
                                </div>
                            </div>
                            <div class="news-actions">
                                <button class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </div>
                    </template>
                    <div x-show="!loading && recentBerita.length === 0" class="empty-state text-center p-4">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada berita</p>
                        <button class="btn btn-primary-modern btn-sm">
                            <i class="fas fa-plus mr-1"></i> Buat Berita
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Users Table -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card modern-card slide-in-up" style="animation-delay: 0.2s;">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-0">
                        <i class="fas fa-users text-success mr-2"></i>
                        User Terbaru
                    </h5>
                    <p class="card-subtitle text-muted mb-0">Daftar pengguna yang baru bergabung</p>
                </div>
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 200px;">
                        <input type="text" class="form-control form-control-modern" placeholder="Cari user...">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-tool btn-sm ml-2" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool btn-sm" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-modern table-hover">
                        <thead>
                            <tr>
                                <th><i class="fas fa-user mr-1"></i> Nama</th>
                                <th><i class="fas fa-envelope mr-1"></i> Email</th>
                                <th><i class="fas fa-user-tag mr-1"></i> Role</th>
                                <th><i class="fas fa-calendar mr-1"></i> Tanggal Daftar</th>
                                <th class="text-center"><i class="fas fa-cog mr-1"></i> Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="user in recentUsers" :key="user.id">
                                <tr class="table-row-hover">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar">
                                                <img :src="`https://ui-avatars.com/api/?name=${user.nama}&background=6366f1&color=fff&size=40`"
                                                     class="rounded-circle" width="40" height="40" :alt="user.nama">
                                                <div class="user-status" :class="user.role == 'admin' ? 'status-danger' : 'status-success'"></div>
                                            </div>
                                            <div class="ml-3">
                                                <div class="user-name" x-text="user.nama"></div>
                                                <small class="text-muted">ID: #<span x-text="user.id"></span></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="user-email">
                                            <i class="fas fa-envelope text-muted mr-1"></i>
                                            <span x-text="user.email"></span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-modern" :class="user.role == 'admin' ? 'badge-danger-modern' : 'badge-info-modern'" class="badge-pill">
                                            <i class="fas" :class="user.role == 'admin' ? 'fa-user-shield' : 'fa-user'" mr-1"></i>
                                            <span x-text="user.role ? user.role.charAt(0).toUpperCase() + user.role.slice(1) : ''"></span>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="user-date">
                                            <i class="fas fa-calendar-alt text-muted mr-1"></i>
                                            <span x-text="user.created_at ? new Date(user.created_at).toLocaleDateString('id-ID') : ''"></span>
                                            <br>
                                            <small class="text-muted" x-text="user.created_at ? new Date(user.created_at).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) : ''"></small>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary btn-sm" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-outline-info btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-danger btn-sm" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                            <tr x-show="!loading && recentUsers.length === 0">
                                <td colspan="5" class="text-center text-muted py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-users-slash fa-3x mb-3"></i>
                                        <h6>Belum ada user baru</h6>
                                        <p class="text-muted">User baru akan muncul di sini setelah mendaftar</p>
                                        <button class="btn btn-primary-modern btn-sm mt-2">
                                            <i class="fas fa-user-plus mr-1"></i> Undang User
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div x-show="recentUsers.length > 0" class="card-footer">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <p class="mb-0 text-muted">
                                Menampilkan <span x-text="recentUsers.length"></span> user terbaru
                            </p>
                        </div>
                        <div class="col-md-6 text-md-right">
                            <nav>
                                <ul class="pagination pagination-sm mb-0">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1">
                                            <i class="fas fa-chevron-left"></i>
                                        </a>
                                    </li>
                                    <li class="page-item active">
                                        <a class="page-link" href="#">1</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">2</a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading indicator -->
<div x-show="loading" class="text-center mb-3">
    <div class="spinner-border text-primary" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
</div>
</x-admin.index>
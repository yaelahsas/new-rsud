<x-admin.index>
<x-slot:title>Jadwal Poli</x-slot:title>
<x-slot:judul>Manajemen Jadwal Poli</x-slot:judul>

<div x-data="jadwalPoliManager" x-init="$watch('search', () => handleSearch())" x-cloak class="fade-in-up">
    <!-- Header dengan tombol tambah dan search -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">
                <i class="fas fa-calendar-check text-primary mr-2"></i>
                Manajemen Jadwal Poli
            </h4>
            <small class="text-muted">Kelola jadwal praktik dokter dan poliklinik</small>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary-modern btn-modern" @click="showModal = true; resetForm()">
                <i class="fas fa-plus"></i> Tambah Jadwal
            </button>
        </div>
    </div>

    <!-- Search dan Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label-modern">
                            <i class="fas fa-search mr-1"></i> Cari Jadwal
                        </label>
                        <input type="text" class="form-control form-control-modern" x-model="search"
                               @keyup.debounce.300ms="handleSearch()"
                               placeholder="Cari berdasarkan dokter, poli, atau hari...">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label-modern">
                            <i class="fas fa-list mr-1"></i> Tampilkan
                        </label>
                        <select class="form-control form-control-modern" x-model="perPage" @change="handlePerPageChange()">
                            <option value="10">10 data</option>
                            <option value="25">25 data</option>
                            <option value="50">50 data</option>
                            <option value="100">100 data</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label-modern">
                            <i class="fas fa-filter mr-1"></i> Filter Status
                        </label>
                        <select class="form-control form-control-modern" x-model="statusFilter" @change="handleSearch()">
                            <option value="">Semua Status</option>
                            <option value="aktif">Aktif</option>
                            <option value="cuti">Cuti</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading indicator -->
    <div x-show="loading" class="text-center mb-4">
        <div class="loading-spinner"></div>
        <p class="text-muted mt-2">Memuat data...</p>
    </div>

    <!-- Tabel Data -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-table mr-2"></i>
                Data Jadwal Poli
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th><i class="fas fa-user-md mr-1"></i> Dokter</th>
                            <th><i class="fas fa-hospital mr-1"></i> Poli</th>
                            <th><i class="fas fa-calendar-day mr-1"></i> Hari</th>
                            <th><i class="fas fa-clock mr-1"></i> Jam Praktik</th>
                            <th><i class="fas fa-info-circle mr-1"></i> Status</th>
                            <th><i class="fas fa-comment mr-1"></i> Keterangan</th>
                            <th width="120"><i class="fas fa-cogs mr-1"></i> Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(jadwal, index) in jadwals" :key="jadwal.id">
                            <tr>
                                <td x-text="pagination.from + index"></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img :src="`https://ui-avatars.com/api/?name=${jadwal.dokter?.nama || 'Unknown'}&background=6366f1&color=fff&size=30`"
                                             class="rounded-circle mr-2" width="30" height="30" alt="Dokter">
                                        <div>
                                            <strong x-text="jadwal.dokter?.nama || '-'"></strong>
                                            <br>
                                            <small class="text-muted" x-text="jadwal.dokter?.spesialis || '-'"></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-info-modern" x-text="jadwal.poli?.nama_poli || '-'"></span>
                                </td>
                                <td>
                                    <span class="badge badge-primary-modern" x-text="jadwal.hari"></span>
                                </td>
                                <td>
                                    <div>
                                        <strong x-text="formatTimeDisplay(jadwal.jam_mulai)"></strong> -
                                        <strong x-text="formatTimeDisplay(jadwal.jam_selesai)"></strong>
                                        <br>
                                        <small class="text-muted" x-text="`${jadwal.jam_mulai} - ${jadwal.jam_selesai}`"></small>
                                    </div>
                                </td>
                                <td>
                                    <template x-if="jadwal.is_cuti">
                                        <span class="badge badge-warning-modern">
                                            <i class="fas fa-exclamation-triangle mr-1"></i> Cuti
                                        </span>
                                    </template>
                                    <template x-if="!jadwal.is_cuti">
                                        <span class="badge badge-success-modern">
                                            <i class="fas fa-check-circle mr-1"></i> Aktif
                                        </span>
                                    </template>
                                </td>
                                <td>
                                    <small x-text="jadwal.keterangan || '-'"></small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-info-modern" @click="editJadwal(jadwal.id)"
                                                title="Edit Jadwal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger-modern" @click="deleteJadwal(jadwal.id)"
                                                title="Hapus Jadwal">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                        <tr x-show="!loading && jadwals.length === 0">
                            <td colspan="8" class="text-center py-4">
                                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Tidak ada data jadwal</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-between align-items-center mt-4">
        <div x-show="jadwals.length > 0" class="text-muted">
            <i class="fas fa-info-circle mr-1"></i>
            Menampilkan <span x-text="pagination.from" class="font-weight-bold"></span> -
            <span x-text="pagination.to" class="font-weight-bold"></span> dari
            <span x-text="pagination.total" class="font-weight-bold"></span> data
        </div>
        <nav x-show="pagination.last_page > 1">
            <ul class="pagination mb-0">
                <li class="page-item" :class="pagination.current_page === 1 ? 'disabled' : ''">
                    <a class="page-link" href="#" @click.prevent="goToPage(pagination.current_page - 1)">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </li>
                
                <template x-for="page in Math.min(5, pagination.last_page)" :key="page">
                    <li class="page-item" :class="pagination.current_page === page ? 'active' : ''">
                        <a class="page-link" href="#" @click.prevent="goToPage(page)" x-text="page"></a>
                    </li>
                </template>
                
                <template x-if="pagination.last_page > 5">
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                </template>
                
                <li class="page-item" :class="pagination.current_page === pagination.last_page ? 'disabled' : ''">
                    <a class="page-link" href="#" @click.prevent="goToPage(pagination.current_page + 1)">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Modal Form -->
    <div class="modal fade" :class="showModal ? 'show' : ''" :style="showModal ? 'display: block; background-color: rgba(0,0,0,0.5);' : 'display: none;'" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-calendar-plus mr-2"></i>
                        <span x-text="form.id ? 'Edit Jadwal' : 'Tambah Jadwal'"></span>
                    </h5>
                    <button type="button" class="close" @click="showModal = false" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="saveJadwal()">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label-modern">
                                        <i class="fas fa-user-md mr-1"></i> Dokter
                                    </label>
                                    <select class="form-control form-control-modern" x-model="form.dokter_id">
                                        <option value="">-- Pilih Dokter --</option>
                                        <template x-for="dokter in dokters" :key="dokter.id">
                                            <option :value="dokter.id" x-text="`${dokter.nama} - ${dokter.spesialis}`"></option>
                                        </template>
                                    </select>
                                    <template x-if="errors.dokter_id">
                                        <small class="text-danger" x-text="errors.dokter_id[0]"></small>
                                    </template>
                                </div>

                                <div class="form-group">
                                    <label class="form-label-modern">
                                        <i class="fas fa-hospital mr-1"></i> Poli
                                    </label>
                                    <select class="form-control form-control-modern" x-model="form.poli_id">
                                        <option value="">-- Pilih Poli --</option>
                                        <template x-for="poli in polis" :key="poli.id">
                                            <option :value="poli.id" x-text="poli.nama_poli"></option>
                                        </template>
                                    </select>
                                    <template x-if="errors.poli_id">
                                        <small class="text-danger" x-text="errors.poli_id[0]"></small>
                                    </template>
                                </div>

                                <div class="form-group">
                                    <label class="form-label-modern">
                                        <i class="fas fa-calendar-week mr-1"></i> Hari Praktik
                                    </label>
                                    
                                    <!-- Quick selection buttons -->
                                    <div class="mb-3">
                                        <button type="button" class="btn btn-sm btn-primary-modern mr-2" @click="selectDaysPattern('senin-kamis')">
                                            <i class="fas fa-calendar-week"></i> Senin - Kamis
                                        </button>
                                        <button type="button" class="btn btn-sm btn-info-modern mr-2" @click="selectDaysPattern('jumat')">
                                            <i class="fas fa-calendar-day"></i> Jumat
                                        </button>
                                        <button type="button" class="btn btn-sm btn-success-modern mr-2" @click="selectDaysPattern('sabtu')">
                                            <i class="fas fa-calendar-day"></i> Sabtu
                                        </button>
                                        <button type="button" class="btn btn-sm btn-secondary" @click="selectedDays = []">
                                            <i class="fas fa-times"></i> Reset
                                        </button>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="Senin" x-model="selectedDays" id="hari-senin">
                                                <label class="form-check-label" for="hari-senin">Senin</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="Selasa" x-model="selectedDays" id="hari-selasa">
                                                <label class="form-check-label" for="hari-selasa">Selasa</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="Rabu" x-model="selectedDays" id="hari-rabu">
                                                <label class="form-check-label" for="hari-rabu">Rabu</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="Kamis" x-model="selectedDays" id="hari-kamis">
                                                <label class="form-check-label" for="hari-kamis">Kamis</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="Jumat" x-model="selectedDays" id="hari-jumat">
                                                <label class="form-check-label" for="hari-jumat">Jumat</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="Sabtu" x-model="selectedDays" id="hari-sabtu">
                                                <label class="form-check-label" for="hari-sabtu">Sabtu</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="Minggu" x-model="selectedDays" id="hari-minggu">
                                                <label class="form-check-label" for="hari-minggu">Minggu</label>
                                            </div>
                                        </div>
                                    </div>
                                    <template x-if="errors.hari">
                                        <small class="text-danger" x-text="errors.hari[0]"></small>
                                    </template>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label-modern">
                                                <i class="fas fa-clock mr-1"></i> Jam Mulai
                                            </label>
                                            <input type="time" class="form-control form-control-modern" x-model="form.jam_mulai" @change="formatTimeIndonesia('jam_mulai')">
                                            <small class="text-muted">Format: 24 jam (contoh: 08:00, 13:30)</small>
                                            <template x-if="errors.jam_mulai">
                                                <small class="text-danger" x-text="errors.jam_mulai[0]"></small>
                                            </template>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label-modern">
                                                <i class="fas fa-clock mr-1"></i> Jam Selesai
                                            </label>
                                            <input type="time" class="form-control form-control-modern" x-model="form.jam_selesai" @change="formatTimeIndonesia('jam_selesai')">
                                            <small class="text-muted">Format: 24 jam (contoh: 12:00, 16:30)</small>
                                            <template x-if="errors.jam_selesai">
                                                <small class="text-danger" x-text="errors.jam_selesai[0]"></small>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Display formatted time in Indonesian format -->
                                <div class="row" x-show="form.jam_mulai || form.jam_selesai">
                                    <div class="col-md-12">
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle mr-2"></i>
                                            <strong>Jadwal Praktik:</strong>
                                            <span x-text="formatTimeDisplay(form.jam_mulai)"></span> -
                                            <span x-text="formatTimeDisplay(form.jam_selesai)"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" x-model="form.is_cuti" id="is_cuti">
                                        <label class="form-check-label" for="is_cuti">
                                            <i class="fas fa-calendar-times mr-1"></i> Status Cuti
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label-modern">
                                        <i class="fas fa-calendar-alt mr-1"></i> Tanggal Cuti
                                    </label>
                                    <input type="date" class="form-control form-control-modern" x-model="form.tanggal_cuti" :disabled="!form.is_cuti">
                                    <template x-if="errors.tanggal_cuti">
                                        <small class="text-danger" x-text="errors.tanggal_cuti[0]"></small>
                                    </template>
                                </div>

                                <div class="form-group">
                                    <label class="form-label-modern">
                                        <i class="fas fa-comment mr-1"></i> Keterangan
                                    </label>
                                    <textarea class="form-control form-control-modern" x-model="form.keterangan" rows="2" placeholder="Keterangan (jika cuti)"></textarea>
                                    <template x-if="errors.keterangan">
                                        <small class="text-danger" x-text="errors.keterangan[0]"></small>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="showModal = false">
                            <i class="fas fa-times mr-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary-modern" :disabled="loading">
                            <i class="fas fa-save mr-1"></i>
                            <span x-text="form.id ? 'Update' : 'Simpan'"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
[x-cloak] {
    display: none !important;
}
</style>
</x-admin.index>
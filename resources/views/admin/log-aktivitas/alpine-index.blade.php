<x-admin.index>
<x-slot:title>Log Aktivitas</x-slot:title>
<x-slot:judul>Log Aktivitas Pengguna</x-slot:judul>

<div x-data="logAktivitasManager" x-init="init(); $watch('search', () => handleSearch())" x-cloak>
    <!-- Header dengan tombol clear dan search -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5>Manajemen Log Aktivitas</h5>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-warning" @click="showClearModal = true">
                <i class="fas fa-trash"></i> Hapus Log Lama
            </button>
        </div>
    </div>

    <!-- Search dan Filter -->
    <div class="row mb-3">
        <div class="col-md-3">
            <input type="text" class="form-control" x-model="search" @keyup.debounce.300ms="handleSearch()" placeholder="Cari log...">
        </div>
        <div class="col-md-2">
            <select class="form-control" x-model="selectedModul" @change="handleModulFilter()">
                <option value="">Semua Modul</option>
                <template x-for="modul in modules" :key="modul">
                    <option :value="modul" x-text="modul"></option>
                </template>
            </select>
        </div>
        <div class="col-md-2">
            <select class="form-control" x-model="selectedUser" @change="handleUserFilter()">
                <option value="">Semua User</option>
                <template x-for="user in users" :key="user.id">
                    <option :value="user.id" x-text="`${user.nama} (${user.email})`"></option>
                </template>
            </select>
        </div>
        <div class="col-md-2">
            <input type="date" class="form-control" x-model="tanggalMulai" @change="handleDateFilter()" placeholder="Tanggal Mulai">
        </div>
        <div class="col-md-2">
            <input type="date" class="form-control" x-model="tanggalSelesai" @change="handleDateFilter()" placeholder="Tanggal Selesai">
        </div>
    </div>

    <!-- Loading indicator -->
    <div x-show="loading" class="text-center mb-3">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <!-- Tabel Data -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>User</th>
                    <th>Modul</th>
                    <th>Aksi</th>
                    <th>IP Address</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="(log, index) in logs" :key="log.id">
                    <tr>
                        <td x-text="pagination.from + index"></td>
                        <td>
                            <div x-text="log.user ? log.user.nama : '-'"></div>
                            <small class="text-muted" x-text="log.user ? log.user.email : ''"></small>
                        </td>
                        <td>
                            <span class="badge badge-info" x-text="log.modul"></span>
                        </td>
                        <td x-text="log.aksi"></td>
                        <td x-text="log.ip"></td>
                        <td x-text="formatDateTime(log.created_at)"></td>
                        <td>
                            <button class="btn btn-sm btn-info" @click="showLog(log.id)">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" @click="deleteLog(log.id)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </template>
                <tr x-show="!loading && logs.length === 0">
                    <td colspan="7" class="text-center">Tidak ada data</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-between">
        <div x-show="logs.length > 0">
            Menampilkan <span x-text="pagination.from"></span> - <span x-text="pagination.to"></span> dari <span x-text="pagination.total"></span> data
        </div>
        <nav x-show="pagination.last_page > 1">
            <ul class="pagination">
                <li class="page-item" :class="pagination.current_page === 1 ? 'disabled' : ''">
                    <a class="page-link" href="#" @click.prevent="goToPage(pagination.current_page - 1)">Previous</a>
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
                    <a class="page-link" href="#" @click.prevent="goToPage(pagination.current_page + 1)">Next</a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Modal Detail Log -->
    <div class="modal fade" id="detailLogModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Log Aktivitas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Content will be populated by JavaScript -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Clear Log -->
    <div class="modal fade" :class="showClearModal ? 'show' : ''" :style="showClearModal ? 'display: block; background-color: rgba(0,0,0,0.5);' : 'display: none;'" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Log Lama</h5>
                    <button type="button" class="close" @click="showClearModal = false" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="clearOldLogs()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Hapus log aktivitas yang lebih lama dari (hari)</label>
                            <input type="number" class="form-control" x-model="clearForm.days" min="1" max="365" required>
                            <small class="form-text text-muted">Log yang lebih lama dari jumlah hari yang ditentukan akan dihapus permanen</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="showClearModal = false">Batal</button>
                        <button type="submit" class="btn btn-warning" :disabled="loading">
                            <i class="fas fa-trash"></i> Hapus Log
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

/* Custom styles for modal */
.modal.show {
    display: block !important;
}
</style>
</x-admin.index>
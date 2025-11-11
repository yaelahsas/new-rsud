<x-admin.index>
<x-slot:title>Pengumuman</x-slot:title>
<x-slot:judul>Semua Pengumuman</x-slot:judul>

<div x-data="pengumumanManager" x-init="init(); $watch('search', () => handleSearch())" x-cloak>
    <!-- Header dengan tombol tambah dan search -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5>Manajemen Pengumuman</h5>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary" @click="showModal = true; resetForm()">
                <i class="fas fa-plus"></i> Tambah Pengumuman
            </button>
        </div>
    </div>

    <!-- Search dan Filter -->
    <div class="row mb-3">
        <div class="col-md-4">
            <input type="text" class="form-control" x-model="search" @keyup.debounce.300ms="handleSearch()" placeholder="Cari pengumuman...">
        </div>
        <div class="col-md-3">
            <select class="form-control" x-model="selectedStatus" @change="handleStatusFilter()">
                <option value="">Semua Status</option>
                <option value="1">Aktif</option>
                <option value="0">Nonaktif</option>
            </select>
        </div>
        <div class="col-md-2">
            <select class="form-control" x-model="perPage" @change="handlePerPageChange()">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
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
                    <th>Gambar</th>
                    <th>Judul</th>
                    <th>Periode</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="(pengumuman, index) in pengumumen" :key="pengumuman.id">
                    <tr>
                        <td x-text="pagination.from + index"></td>
                        <td>
                            <template x-if="pengumuman.gambar">
                                <img :src="`/storage/${pengumuman.gambar}`" 
                                     class="img-thumbnail" width="80" height="60"
                                     onerror="this.src='/img/no-image.png'; this.onerror=null;">
                            </template>
                            <template x-if="!pengumuman.gambar">
                                <img src="/img/no-image.png" 
                                     class="img-thumbnail" width="80" height="60">
                            </template>
                        </td>
                        <td>
                            <div x-text="pengumuman.judul"></div>
                            <small class="text-muted" x-text="pengumuman.isi ? (pengumuman.isi.length > 50 ? pengumuman.isi.substring(0, 50) + '...' : pengumuman.isi) : ''"></small>
                        </td>
                        <td>
                            <template x-if="pengumuman.tanggal_mulai && pengumuman.tanggal_selesai">
                                <span x-text="formatDate(pengumuman.tanggal_mulai)"></span> - <span x-text="formatDate(pengumuman.tanggal_selesai)"></span>
                            </template>
                            <template x-if="pengumuman.tanggal_mulai && !pengumuman.tanggal_selesai">
                                <span x-text="formatDate(pengumuman.tanggal_mulai)"></span> - Selesai
                            </template>
                            <template x-if="!pengumuman.tanggal_mulai">
                                -
                            </template>
                        </td>
                        <td>
                            <template x-if="pengumuman.aktif">
                                <span class="badge badge-success">Aktif</span>
                            </template>
                            <template x-if="!pengumuman.aktif">
                                <span class="badge badge-secondary">Nonaktif</span>
                            </template>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-info" @click="editPengumuman(pengumuman.id)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-warning" @click="toggleStatus(pengumuman.id)">
                                <i class="fas fa-power-off"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" @click="deletePengumuman(pengumuman.id)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </template>
                <tr x-show="!loading && pengumumen.length === 0">
                    <td colspan="6" class="text-center">Tidak ada data</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-between">
        <div x-show="pengumumen.length > 0">
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

    <!-- Modal Form -->
    <div class="modal fade" :class="showModal ? 'show' : ''" :style="showModal ? 'display: block; background-color: rgba(0,0,0,0.5);' : 'display: none;'" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" x-text="form.id ? 'Edit Pengumuman' : 'Tambah Pengumuman'"></h5>
                    <button type="button" class="close" @click="showModal = false" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="savePengumuman()" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Judul</label>
                            <input type="text" class="form-control" x-model="form.judul" placeholder="Judul pengumuman">
                            <template x-if="errors.judul">
                                <small class="text-danger" x-text="errors.judul[0]"></small>
                            </template>
                        </div>

                        <div class="form-group">
                            <label>Isi Pengumuman</label>
                            <textarea class="form-control" x-model="form.isi" rows="5" placeholder="Isi pengumuman"></textarea>
                            <template x-if="errors.isi">
                                <small class="text-danger" x-text="errors.isi[0]"></small>
                            </template>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Mulai</label>
                                    <input type="date" class="form-control" x-model="form.tanggal_mulai">
                                    <template x-if="errors.tanggal_mulai">
                                        <small class="text-danger" x-text="errors.tanggal_mulai[0]"></small>
                                    </template>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Selesai</label>
                                    <input type="date" class="form-control" x-model="form.tanggal_selesai">
                                    <small class="form-text text-muted">Kosongkan jika tidak ada tanggal selesai</small>
                                    <template x-if="errors.tanggal_selesai">
                                        <small class="text-danger" x-text="errors.tanggal_selesai[0]"></small>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Gambar</label>
                            <input type="file" class="form-control" @change="form.gambar = $event.target.files[0]" accept="image/*">
                            
                            <!-- Display existing image when editing -->
                            <template x-if="form.existing_gambar && !form.gambar">
                                <div class="mt-2">
                                    <p class="text-muted small">Gambar saat ini:</p>
                                    <img :src="`/storage/${form.existing_gambar}`" class="rounded shadow-sm" width="200"
                                         onerror="this.src='/img/no-image.png'; this.onerror=null;">
                                    <p class="text-muted small mt-1">Upload gambar baru untuk mengganti</p>
                                </div>
                            </template>
                            
                            <!-- Display new image preview -->
                            <template x-if="form.gambar && form.gambar.type.startsWith('image/')">
                                <div class="mt-2">
                                    <p class="text-muted small">Gambar baru:</p>
                                    <img :src="URL.createObjectURL(form.gambar)" class="rounded shadow-sm" width="200">
                                </div>
                            </template>
                            
                            <template x-if="errors.gambar">
                                <small class="text-danger" x-text="errors.gambar[0]"></small>
                            </template>
                        </div>

                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" x-model="form.aktif" id="aktif">
                            <label for="aktif" class="form-check-label">Tandai sebagai Aktif</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="showModal = false">Batal</button>
                        <button type="submit" class="btn btn-primary" :disabled="loading">
                            <i class="fas fa-save"></i> <span x-text="form.id ? 'Update' : 'Simpan'"></span>
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

.modal-dialog-scrollable {
    max-height: calc(100% - 1rem);
}

.modal-dialog-scrollable .modal-content {
    max-height: calc(100vh - 1rem);
    overflow: hidden;
}

.modal-dialog-scrollable .modal-body {
    max-height: calc(100vh - 200px);
    overflow-y: auto;
}

/* Image thumbnail styles */
.img-thumbnail {
    object-fit: cover;
    border-radius: 4px;
}
</style>
</x-admin.index>
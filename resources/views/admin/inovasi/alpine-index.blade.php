<x-admin.index>
<x-slot:title>Inovasi</x-slot:title>
<x-slot:judul>Semua Inovasi</x-slot:judul>

<div x-data="inovasiManager" x-init="init(); $watch('search', () => handleSearch())" x-cloak>
    <!-- Header dengan tombol tambah dan search -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5>Manajemen Inovasi</h5>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary" @click="showModal = true; resetForm()">
                <i class="fas fa-plus"></i> Tambah Inovasi
            </button>
        </div>
    </div>

    <!-- Search -->
    <div class="row mb-3">
        <div class="col-md-6">
            <input type="text" class="form-control" x-model="search" @keyup.debounce.300ms="handleSearch()" placeholder="Cari inovasi...">
        </div>
        <div class="col-md-3">
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
                    <th>Nama Inovasi</th>
                    <th>Status</th>
                    <th>Reviews</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="(inovasi, index) in inovasis" :key="inovasi.id">
                    <tr>
                        <td x-text="pagination.from + index"></td>
                        <td>
                            <img :src="inovasi.gambar ? `/storage/${inovasi.gambar}` : '/img/no-image.png'" 
                                 class="img-thumbnail" width="80" height="60"
                                 onerror="this.src='/img/no-image.png'; this.onerror=null;">
                        </td>
                        <td>
                            <div x-text="inovasi.nama_inovasi"></div>
                            <small class="text-muted" x-text="inovasi.slug"></small>
                        </td>
                        <td>
                            <template x-if="inovasi.status === 'aktif'">
                                <span class="badge badge-success">Aktif</span>
                            </template>
                            <template x-if="inovasi.status === 'nonaktif'">
                                <span class="badge badge-secondary">Nonaktif</span>
                            </template>
                        </td>
                        <td>
                            <span class="badge badge-info" x-text="inovasi.reviews_count || 0"></span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-info" @click="editInovasi(inovasi.id)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-warning" @click="toggleStatus(inovasi.id)">
                                <i class="fas fa-power-off"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" @click="deleteInovasi(inovasi.id)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </template>
                <tr x-show="!loading && inovasis.length === 0">
                    <td colspan="6" class="text-center">Tidak ada data</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-between">
        <div x-show="inovasis.length > 0">
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
                    <h5 class="modal-title" x-text="form.id ? 'Edit Inovasi' : 'Tambah Inovasi'"></h5>
                    <button type="button" class="close" @click="showModal = false" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="saveInovasi()" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Inovasi</label>
                            <input type="text" class="form-control" x-model="form.nama_inovasi" placeholder="Nama inovasi">
                            <template x-if="errors.nama_inovasi">
                                <small class="text-danger" x-text="errors.nama_inovasi[0]"></small>
                            </template>
                        </div>

                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" class="form-control" x-model="form.slug" readonly>
                        </div>

                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea class="form-control" x-model="form.deskripsi" rows="5" placeholder="Deskripsi inovasi"></textarea>
                            <template x-if="errors.deskripsi">
                                <small class="text-danger" x-text="errors.deskripsi[0]"></small>
                            </template>
                        </div>

                        <div class="form-group">
                            <label>Link</label>
                            <input type="url" class="form-control" x-model="form.link" placeholder="Link terkait (opsional)">
                            <template x-if="errors.link">
                                <small class="text-danger" x-text="errors.link[0]"></small>
                            </template>
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" x-model="form.status">
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                            <template x-if="errors.status">
                                <small class="text-danger" x-text="errors.status[0]"></small>
                            </template>
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
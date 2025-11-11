<x-admin.index>
<x-slot:title>Galeri</x-slot:title>
<x-slot:judul>Semua Galeri</x-slot:judul>

<div x-data="galeriManager" x-init="init(); $watch('search', () => handleSearch())" x-cloak>
    <!-- Header dengan tombol tambah dan search -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5>Manajemen Galeri</h5>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary" @click="showModal = true; resetForm()">
                <i class="fas fa-plus"></i> Tambah Galeri
            </button>
        </div>
    </div>

    <!-- Search dan Filter -->
    <div class="row mb-3">
        <div class="col-md-4">
            <input type="text" class="form-control" x-model="search" @keyup.debounce.300ms="handleSearch()" placeholder="Cari galeri...">
        </div>
        <div class="col-md-3">
            <select class="form-control" x-model="selectedKategori" @change="handleKategoriFilter()">
                <option value="">Semua Kategori</option>
                <template x-for="kategori in kategoris" :key="kategori">
                    <option :value="kategori" x-text="kategori"></option>
                </template>
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
                    <th>Kategori</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="(galeri, index) in galeris" :key="galeri.id">
                    <tr>
                        <td x-text="pagination.from + index"></td>
                        <td>
                            <img :src="galeri.gambar ? `/storage/${galeri.gambar}` : '/img/no-image.png'" 
                                 class="img-thumbnail" width="80" height="60"
                                 onerror="this.src='/img/no-image.png'; this.onerror=null;">
                        </td>
                        <td x-text="galeri.judul"></td>
                        <td>
                            <span x-show="galeri.kategori" class="badge badge-info" x-text="galeri.kategori"></span>
                            <span x-show="!galeri.kategori" class="text-muted">-</span>
                        </td>
                        <td>
                            <span x-text="galeri.deskripsi ? (galeri.deskripsi.length > 50 ? galeri.deskripsi.substring(0, 50) + '...' : galeri.deskripsi) : '-'"></span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-info" @click="editGaleri(galeri.id)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" @click="deleteGaleri(galeri.id)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </template>
                <tr x-show="!loading && galeris.length === 0">
                    <td colspan="6" class="text-center">Tidak ada data</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-between">
        <div x-show="galeris.length > 0">
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
                    <h5 class="modal-title" x-text="form.id ? 'Edit Galeri' : 'Tambah Galeri'"></h5>
                    <button type="button" class="close" @click="showModal = false" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="saveGaleri()" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Judul</label>
                            <input type="text" class="form-control" x-model="form.judul" placeholder="Judul galeri">
                            <template x-if="errors.judul">
                                <small class="text-danger" x-text="errors.judul[0]"></small>
                            </template>
                        </div>

                        <div class="form-group">
                            <label>Kategori</label>
                            <input type="text" class="form-control" x-model="form.kategori" placeholder="Kategori (opsional)">
                            <template x-if="errors.kategori">
                                <small class="text-danger" x-text="errors.kategori[0]"></small>
                            </template>
                        </div>

                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea class="form-control" x-model="form.deskripsi" rows="3" placeholder="Deskripsi galeri"></textarea>
                            <template x-if="errors.deskripsi">
                                <small class="text-danger" x-text="errors.deskripsi[0]"></small>
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
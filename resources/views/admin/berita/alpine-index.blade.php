<x-admin.index>
<x-slot:title>Berita</x-slot:title>
<x-slot:judul>Semua Berita</x-slot:judul>

<div x-data="beritaManager" x-init="init(); $watch('search', () => handleSearch())" x-cloak>
    <!-- Header dengan tombol tambah dan search -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5>Manajemen Berita</h5>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary" @click="showModal = true; resetForm()">
                <i class="fas fa-plus"></i> Tambah Berita
            </button>
        </div>
    </div>

    <!-- Search -->
    <div class="row mb-3">
        <div class="col-md-6">
            <input type="text" class="form-control" x-model="search" @keyup.debounce.300ms="handleSearch()" placeholder="Cari berita...">
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
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th>Tanggal Publish</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="(berita, index) in beritas" :key="berita.id">
                    <tr>
                        <td x-text="pagination.from + index"></td>
                        <td x-text="berita.judul"></td>
                        <td x-text="berita.kategori ? berita.kategori.nama_kategori : '-'"></td>
                        <td x-text="berita.author ? berita.author.nama : '-'"></td>
                        <td>
                            <template x-if="berita.publish">
                                <span class="badge badge-success">Publish</span>
                            </template>
                            <template x-if="!berita.publish">
                                <span class="badge badge-secondary">Draft</span>
                            </template>
                        </td>
                        <td x-text="berita.tanggal_publish ? new Date(berita.tanggal_publish).toLocaleDateString('id-ID') : new Date(berita.created_at).toLocaleDateString('id-ID')"></td>
                        <td>
                            <button class="btn btn-sm btn-info" @click="editBerita(berita.id)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" @click="deleteBerita(berita.id)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </template>
                <tr x-show="!loading && beritas.length === 0">
                    <td colspan="7" class="text-center">Tidak ada data</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-between">
        <div x-show="beritas.length > 0">
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
                    <h5 class="modal-title" x-text="form.id ? 'Edit Berita' : 'Tambah Berita'"></h5>
                    <button type="button" class="close" @click="showModal = false" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="saveBerita()" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Judul Artikel</label>
                            <input type="text" class="form-control" x-model="form.judul" placeholder="Judul artikel">
                            <template x-if="errors.judul">
                                <small class="text-danger" x-text="errors.judul[0]"></small>
                            </template>
                        </div>

                        <div class="form-group">
                            <label>Slug</label>
                            <input type="text" class="form-control" x-model="form.slug" readonly>
                        </div>

                        <div class="form-group">
                            <label>Kategori</label>
                            <select class="form-control" x-model="form.kategori_id">
                                <option value="">-- Pilih Kategori --</option>
                                <template x-if="kategoris.length > 0">
                                    <template x-for="kategori in kategoris" :key="kategori.id">
                                        <option :value="kategori.id" x-text="kategori.nama_kategori || kategori.nama"></option>
                                    </template>
                                </template>
                                <template x-if="kategoris.length === 0">
                                    <option value="" disabled>Tidak ada kategori tersedia</option>
                                </template>
                            </select>
                            <template x-if="errors.kategori_id">
                                <small class="text-danger" x-text="errors.kategori_id[0]"></small>
                            </template>
                        </div>

                        <div class="form-group">
                            <label>Isi Artikel</label>
                            <textarea id="summernote" class="form-control" x-model="form.isi"></textarea>
                            <template x-if="errors.isi">
                                <small class="text-danger" x-text="errors.isi[0]"></small>
                            </template>
                        </div>

                        <div class="form-group">
                            <label>Thumbnail</label>
                            <input type="file" class="form-control" @change="form.thumbnail = $event.target.files[0]" accept="image/*">
                            
                            <!-- Display existing thumbnail when editing -->
                            <template x-if="form.existing_thumbnail && !form.thumbnail">
                                <div class="mt-2">
                                    <p class="text-muted small">Thumbnail saat ini:</p>
                                    <img :src="`/storage/${form.existing_thumbnail}`" class="rounded shadow-sm" width="150"
                                         onerror="this.src='/img/no-image.png'; this.onerror=null;">
                                    <p class="text-muted small mt-1">Upload gambar baru untuk mengganti thumbnail</p>
                                </div>
                            </template>
                            
                            <!-- Display new thumbnail preview -->
                            <template x-if="form.thumbnail && form.thumbnail.type.startsWith('image/')">
                                <div class="mt-2">
                                    <p class="text-muted small">Thumbnail baru:</p>
                                    <img :src="URL.createObjectURL(form.thumbnail)" class="rounded shadow-sm" width="150">
                                </div>
                            </template>
                            
                            <template x-if="errors.thumbnail">
                                <small class="text-danger" x-text="errors.thumbnail[0]"></small>
                            </template>
                        </div>

                        <div class="form-group">
                            <label>Tanggal Publish</label>
                           <input type="date" class="form-control" x-model="form.tanggal_publish">
                            <small class="form-text text-muted">Kosongkan untuk publish sekarang</small>
                        </div>

                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" x-model="form.publish" id="publish">
                            <label for="publish" class="form-check-label">Tandai sebagai Publish</label>
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

/* Ensure Summernote editor works properly in modal */
.note-editor {
    position: relative;
}

.note-editor .note-editable {
    min-height: 200px;
}
</style>
</x-admin.index>
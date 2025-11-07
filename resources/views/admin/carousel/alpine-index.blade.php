<x-admin.index>
<x-slot:title>Carousel</x-slot:title>
<x-slot:judul>Manajemen Carousel</x-slot:judul>

<div x-data="carouselManager" x-init="$watch('search', () => handleSearch())" x-cloak>
    <!-- Header dengan tombol tambah dan search -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5>Manajemen Carousel</h5>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary" @click="showModal = true; resetForm()">
                <i class="fas fa-plus"></i> Tambah Carousel
            </button>
        </div>
    </div>

    <!-- Search -->
    <div class="row mb-3">
        <div class="col-md-6">
            <input type="text" class="form-control" x-model="search" @keyup.debounce.300ms="handleSearch()" placeholder="Cari carousel...">
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
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Link</th>
                    <th>Urutan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="(carousel, index) in carousels" :key="carousel.id">
                    <tr>
                        <td x-text="pagination.from + index"></td>
                        <td>
                            <template x-if="carousel.gambar">
                                <img :src="`/storage/${carousel.gambar}`" :alt="carousel.judul" class="img-thumbnail" width="100" height="60">
                            </template>
                            <template x-if="!carousel.gambar">
                                <img src="https://via.placeholder.com/100x60" alt="No Image" class="img-thumbnail" width="100" height="60">
                            </template>
                        </td>
                        <td x-text="carousel.judul"></td>
                        <td x-text="carousel.deskripsi ? (carousel.deskripsi.length > 50 ? carousel.deskripsi.substring(0, 50) + '...' : carousel.deskripsi) : '-'"></td>
                        <td>
                            <template x-if="carousel.link">
                                <a :href="carousel.link" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            </template>
                            <template x-if="!carousel.link">
                                -
                            </template>
                        </td>
                        <td x-text="carousel.urutan"></td>
                        <td>
                            <template x-if="carousel.aktif">
                                <span class="badge badge-success">Aktif</span>
                            </template>
                            <template x-if="!carousel.aktif">
                                <span class="badge badge-secondary">Nonaktif</span>
                            </template>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-info" @click="editCarousel(carousel.id)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm" :class="carousel.aktif ? 'btn-warning' : 'btn-success'" @click="toggleStatus(carousel.id)" :title="carousel.aktif ? 'Nonaktifkan' : 'Aktifkan'">
                                <i class="fas" :class="carousel.aktif ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" @click="deleteCarousel(carousel.id)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </template>
                <tr x-show="!loading && carousels.length === 0">
                    <td colspan="8" class="text-center">Tidak ada data</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-between">
        <div x-show="carousels.length > 0">
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
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" x-text="form.id ? 'Edit Carousel' : 'Tambah Carousel'"></h5>
                    <button type="button" class="close" @click="showModal = false" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="saveCarousel()" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Judul</label>
                                    <input type="text" class="form-control" x-model="form.judul" placeholder="Judul carousel">
                                    <template x-if="errors.judul">
                                        <small class="text-danger" x-text="errors.judul[0]"></small>
                                    </template>
                                </div>

                                <div class="form-group">
                                    <label>Link</label>
                                    <input type="url" class="form-control" x-model="form.link" placeholder="https://example.com">
                                    <template x-if="errors.link">
                                        <small class="text-danger" x-text="errors.link[0]"></small>
                                    </template>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Urutan</label>
                                            <input type="number" class="form-control" x-model="form.urutan" min="0">
                                            <template x-if="errors.urutan">
                                                <small class="text-danger" x-text="errors.urutan[0]"></small>
                                            </template>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" x-model="form.aktif">
                                                <option value="true">Aktif</option>
                                                <option value="false">Nonaktif</option>
                                            </select>
                                            <template x-if="errors.aktif">
                                                <small class="text-danger" x-text="errors.aktif[0]"></small>
                                            </template>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <textarea class="form-control" x-model="form.deskripsi" rows="3" placeholder="Deskripsi carousel"></textarea>
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
                                                 onerror="this.src='https://via.placeholder.com/200x150'; this.onerror=null;">
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
</style>
</x-admin.index>
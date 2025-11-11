<x-admin.index>
<x-slot:title>Review</x-slot:title>
<x-slot:judul>Manajemen Review</x-slot:judul>

<div x-data="reviewManager" x-init="init(); $watch('search', () => handleSearch())" x-cloak>
    <!-- Header dengan tombol tambah dan search -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5>Manajemen Review</h5>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary" @click="showModal = true; resetForm()">
                <i class="fas fa-plus"></i> Tambah Review
            </button>
        </div>
    </div>

    <!-- Search dan Filter -->
    <div class="row mb-3">
        <div class="col-md-4">
            <input type="text" class="form-control" x-model="search" @keyup.debounce.300ms="handleSearch()" placeholder="Cari review...">
        </div>
        <div class="col-md-3">
            <select class="form-control" x-model="selectedInovasi" @change="handleInovasiFilter()">
                <option value="">Semua Inovasi</option>
                <template x-for="inovasi in inovasis" :key="inovasi.id">
                    <option :value="inovasi.id" x-text="inovasi.nama_inovasi"></option>
                </template>
            </select>
        </div>
        <div class="col-md-2">
            <select class="form-control" x-model="selectedRating" @change="handleRatingFilter()">
                <option value="">Semua Rating</option>
                <option value="5">5 Bintang</option>
                <option value="4">4 Bintang</option>
                <option value="3">3 Bintang</option>
                <option value="2">2 Bintang</option>
                <option value="1">1 Bintang</option>
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
                    <th>Nama</th>
                    <th>Rating</th>
                    <th>Inovasi</th>
                    <th>Pesan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="(review, index) in reviews" :key="review.id">
                    <tr>
                        <td x-text="pagination.from + index"></td>
                        <td x-text="review.nama"></td>
                        <td>
                            <div x-html="displayRating(review.rating)"></div>
                        </td>
                        <td>
                            <span x-text="review.inovasi ? review.inovasi.nama_inovasi : '-'"></span>
                        </td>
                        <td>
                            <div x-text="review.pesan ? (review.pesan.length > 50 ? review.pesan.substring(0, 50) + '...' : review.pesan) : '-'"></div>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-info" @click="editReview(review.id)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" @click="deleteReview(review.id)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </template>
                <tr x-show="!loading && reviews.length === 0">
                    <td colspan="6" class="text-center">Tidak ada data</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-between">
        <div x-show="reviews.length > 0">
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
                    <h5 class="modal-title" x-text="form.id ? 'Edit Review' : 'Tambah Review'"></h5>
                    <button type="button" class="close" @click="showModal = false" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="saveReview()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" x-model="form.nama" placeholder="Nama reviewer" required>
                            <template x-if="errors.nama">
                                <small class="text-danger" x-text="errors.nama[0]"></small>
                            </template>
                        </div>

                        <div class="form-group">
                            <label>Rating</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <select class="form-control" x-model="form.rating" required>
                                        <option value="5">5 Bintang</option>
                                        <option value="4">4 Bintang</option>
                                        <option value="3">3 Bintang</option>
                                        <option value="2">2 Bintang</option>
                                        <option value="1">1 Bintang</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="mt-2">
                                        <small class="text-muted">Preview:</small>
                                        <div x-html="displayRating(form.rating)"></div>
                                    </div>
                                </div>
                            </div>
                            <template x-if="errors.rating">
                                <small class="text-danger" x-text="errors.rating[0]"></small>
                            </template>
                        </div>

                        <div class="form-group">
                            <label>Pesan</label>
                            <textarea class="form-control" x-model="form.pesan" rows="5" placeholder="Pesan review" required></textarea>
                            <template x-if="errors.pesan">
                                <small class="text-danger" x-text="errors.pesan[0]"></small>
                            </template>
                        </div>

                        <div class="form-group">
                            <label>Inovasi</label>
                            <select class="form-control" x-model="form.inovasi_id" required>
                                <option value="">-- Pilih Inovasi --</option>
                                <template x-for="inovasi in inovasis" :key="inovasi.id">
                                    <option :value="inovasi.id" x-text="inovasi.nama_inovasi"></option>
                                </template>
                            </select>
                            <template x-if="errors.inovasi_id">
                                <small class="text-danger" x-text="errors.inovasi_id[0]"></small>
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
</style>
</x-admin.index>
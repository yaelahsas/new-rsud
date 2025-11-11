<x-admin.index>
<x-slot:title>Kontak</x-slot:title>
<x-slot:judul>Semua Kontak</x-slot:judul>

<div x-data="kontakManager" x-init="init(); $watch('search', () => handleSearch())" x-cloak>
    <!-- Header dengan tombol tambah dan search -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5>Manajemen Kontak</h5>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary" @click="showModal = true; resetForm()">
                <i class="fas fa-plus"></i> Tambah Kontak
            </button>
        </div>
    </div>

    <!-- Search dan Filter -->
    <div class="row mb-3">
        <div class="col-md-4">
            <input type="text" class="form-control" x-model="search" @keyup.debounce.300ms="handleSearch()" placeholder="Cari kontak...">
        </div>
        <div class="col-md-3">
            <select class="form-control" x-model="selectedJenis" @change="handleJenisFilter()">
                <option value="">Semua Jenis</option>
                <template x-for="jenis in jenisKontakOptions" :key="jenis">
                    <option :value="jenis" x-text="jenis"></option>
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
                    <th>Icon</th>
                    <th>Jenis Kontak</th>
                    <th>Label</th>
                    <th>Value</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="(item, index) in kontak" :key="item.id">
                    <tr>
                        <td x-text="pagination.from + index"></td>
                        <td>
                            <template x-if="item.icon">
                                <i :class="item.icon" class="text-primary"></i>
                            </template>
                            <template x-if="!item.icon">
                                <i class="fas fa-question-circle text-muted"></i>
                            </template>
                        </td>
                        <td>
                            <span class="badge badge-info" x-text="item.jenis_kontak"></span>
                        </td>
                        <td x-text="item.label"></td>
                        <td>
                            <template x-if="item.jenis_kontak === 'Email'">
                                <a :href="`mailto:${item.value}`" x-text="item.value" class="text-primary"></a>
                            </template>
                            <template x-if="item.jenis_kontak === 'Telepon'">
                                <a :href="`tel:${item.value}`" x-text="item.value" class="text-primary"></a>
                            </template>
                            <template x-if="item.jenis_kontak === 'Website'">
                                <a :href="item.value" target="_blank" x-text="item.value" class="text-primary"></a>
                            </template>
                            <template x-if="item.jenis_kontak === 'Social Media'">
                                <a :href="item.value" target="_blank" x-text="item.value" class="text-primary"></a>
                            </template>
                            <template x-if="item.jenis_kontak !== 'Email' && item.jenis_kontak !== 'Telepon' && item.jenis_kontak !== 'Website' && item.jenis_kontak !== 'Social Media'">
                                <span x-text="item.value"></span>
                            </template>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-info" @click="editKontak(item.id)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" @click="deleteKontak(item.id)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </template>
                <tr x-show="!loading && kontak.length === 0">
                    <td colspan="6" class="text-center">Tidak ada data</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-between">
        <div x-show="kontak.length > 0">
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
                    <h5 class="modal-title" x-text="form.id ? 'Edit Kontak' : 'Tambah Kontak'"></h5>
                    <button type="button" class="close" @click="showModal = false" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="saveKontak()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Jenis Kontak</label>
                            <select class="form-control" x-model="form.jenis_kontak">
                                <option value="">-- Pilih Jenis --</option>
                                <template x-for="jenis in jenisKontakOptions" :key="jenis">
                                    <option :value="jenis" x-text="jenis"></option>
                                </template>
                            </select>
                            <template x-if="errors.jenis_kontak">
                                <small class="text-danger" x-text="errors.jenis_kontak[0]"></small>
                            </template>
                        </div>

                        <div class="form-group">
                            <label>Label</label>
                            <input type="text" class="form-control" x-model="form.label" placeholder="Label kontak">
                            <template x-if="errors.label">
                                <small class="text-danger" x-text="errors.label[0]"></small>
                            </template>
                        </div>

                        <div class="form-group">
                            <label>Value</label>
                            <input type="text" class="form-control" x-model="form.value" placeholder="Value kontak">
                            <small class="form-text text-muted">
                                <template x-if="form.jenis_kontak === 'Email'">
                                    Contoh: info@rsud.com
                                </template>
                                <template x-if="form.jenis_kontak === 'Telepon'">
                                    Contoh: (021) 1234567
                                </template>
                                <template x-if="form.jenis_kontak === 'Website'">
                                    Contoh: https://www.rsud.com
                                </template>
                                <template x-if="form.jenis_kontak === 'Social Media'">
                                    Contoh: https://facebook.com/rsud
                                </template>
                            </small>
                            <template x-if="errors.value">
                                <small class="text-danger" x-text="errors.value[0]"></small>
                            </template>
                        </div>

                        <div class="form-group">
                            <label>Icon</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <select class="form-control" x-model="form.icon">
                                        <option value="">-- Pilih Icon --</option>
                                        <template x-for="icon in iconOptions" :key="icon">
                                            <option :value="icon" x-text="icon"></option>
                                        </template>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="mt-2">
                                        <small class="text-muted">Preview:</small>
                                        <template x-if="form.icon">
                                            <i :class="form.icon" class="text-primary fa-2x"></i>
                                        </template>
                                        <template x-if="!form.icon">
                                            <i class="fas fa-question-circle text-muted fa-2x"></i>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            <template x-if="errors.icon">
                                <small class="text-danger" x-text="errors.icon[0]"></small>
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

/* Icon preview styles */
.fa-2x {
    font-size: 2em;
}
</style>
</x-admin.index>
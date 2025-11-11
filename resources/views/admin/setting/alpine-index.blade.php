<x-admin.index>
<x-slot:title>Settings</x-slot:title>
<x-slot:judul>Pengaturan Sistem</x-slot:judul>

<div x-data="settingManager" x-init="init(); $watch('search', () => handleSearch())" x-cloak>
    <!-- Header dengan tombol bulk update -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5>Manajemen Settings</h5>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary" @click="showModal = true; resetForm()">
                <i class="fas fa-plus"></i> Tambah Setting
            </button>
            <button type="button" class="btn btn-info" @click="showBulkModal = true; resetBulkForm()">
                <i class="fas fa-edit"></i> Bulk Update
            </button>
        </div>
    </div>

    <!-- Search dan Filter -->
    <div class="row mb-3">
        <div class="col-md-4">
            <input type="text" class="form-control" x-model="search" @keyup.debounce.300ms="handleSearch()" placeholder="Cari setting...">
        </div>
        <div class="col-md-3">
            <select class="form-control" x-model="selectedCategory" @change="handleCategoryFilter()">
                <option value="">Semua Kategori</option>
                <template x-for="category in categories" :key="category">
                    <option :value="category" x-text="category"></option>
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
                    <th>Key</th>
                    <th>Value</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="(setting, index) in settings" :key="setting.id">
                    <tr>
                        <td x-text="pagination.from + index"></td>
                        <td x-text="setting.key"></td>
                        <td x-text="setting.value"></td>
                        <td>
                            <button class="btn btn-sm btn-info" @click="editSetting(setting.id)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" @click="deleteSetting(setting.id)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </template>
                <tr x-show="!loading && settings.length === 0">
                    <td colspan="4" class="text-center">Tidak ada data</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-between">
        <div x-show="settings.length > 0">
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
                    <h5 class="modal-title" x-text="form.id ? 'Edit Setting' : 'Tambah Setting'"></h5>
                    <button type="button" class="close" @click="showModal = false" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="saveSetting()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Key</label>
                            <input type="text" class="form-control" x-model="form.key" placeholder="Key setting" required>
                            <template x-if="errors.key">
                                <small class="text-danger" x-text="errors.key[0]"></small>
                            </template>
                        </div>

                        <div class="form-group">
                            <label>Value</label>
                            <textarea class="form-control" x-model="form.value" rows="5" placeholder="Value setting" required></textarea>
                            <template x-if="errors.value">
                                <small class="text-danger" x-text="errors.value[0]"></small>
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

    <!-- Modal Bulk Update -->
    <div class="modal fade" :class="showBulkModal ? 'show' : ''" :style="showBulkModal ? 'display: block; background-color: rgba(0,0,0,0.5);' : 'display: none;'" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bulk Update Settings</h5>
                    <button type="button" class="close" @click="showBulkModal = false" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="bulkUpdateSettings()">
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Info:</strong> Tambahkan beberapa setting sekaligus untuk diperbarui. Gunakan format Key:Value pada setiap baris.
                        </div>
                        
                        <div class="form-group">
                            <label>Settings (JSON Format)</label>
                            <textarea class="form-control" x-model="bulkSettingsText" rows="10" placeholder='[{"key": "value1"}, {"key": "value2"}]' required></textarea>
                            <small class="form-text text-muted">Format: [{"key": "value"}, {"key": "value"}]</small>
                        </div>
                        
                        <div class="table-responsive mt-3" x-show="bulkForm.settings.length > 0">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Key</th>
                                        <th>Value</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="(setting, index) in bulkForm.settings" :key="index">
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control" x-model="setting.key" placeholder="Key">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" x-model="setting.value" placeholder="Value">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-danger" @click="removeBulkSetting(index)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="form-group mt-3">
                            <button type="button" class="btn btn-sm btn-secondary" @click="addBulkSetting()">
                                <i class="fas fa-plus"></i> Tambah Setting
                            </button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="showBulkModal = false">Batal</button>
                        <button type="submit" class="btn btn-primary" :disabled="loading">
                            <i class="fas fa-save"></i> Update Settings
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
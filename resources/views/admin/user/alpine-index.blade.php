<x-admin.index>
<x-slot:title>User</x-slot:title>
<x-slot:judul>Manajemen User</x-slot:judul>

<div x-data="userManager" x-init="$watch('search', () => handleSearch())" x-cloak>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <!-- Filter jumlah data -->
                <div class="d-flex align-items-center gap-2">
                    <label for="perPage" class="mb-0">Tampilkan:</label>
                    <select id="perPage" class="form-select form-select-sm w-auto" x-model="perPage" @change="handlePerPageChange()">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>

                <!-- Search dan Tombol Tambah -->
                <div class="d-flex align-items-center gap-2">
                    <input type="text" x-model="search" @keyup.debounce.300ms="handleSearch()" class="form-control form-control-sm"
                        placeholder="Cari nama atau email...">
                    <button type="button" class="btn btn-primary btn-sm" @click="showModal = true; resetForm()">
                        <i class="fas fa-plus"></i> Tambah User
                    </button>
                </div>
            </div>

            <!-- Loading indicator -->
            <div x-show="loading" class="text-center mb-3">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>

            <div class="table-responsive-sm">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th><i class="fas fa-cog"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(user, index) in users" :key="user.id">
                            <tr>
                                <td x-text="pagination.from + index"></td>
                                <td x-text="user.nama"></td>
                                <td x-text="user.email"></td>
                                <td>
                                    <template x-if="user.role === 'admin'">
                                        <span class="badge bg-success" x-text="user.role"></span>
                                    </template>
                                    <template x-if="user.role === 'editor'">
                                        <span class="badge bg-info text-dark" x-text="user.role"></span>
                                    </template>
                                    <template x-if="user.role !== 'admin' && user.role !== 'editor'">
                                        <span class="badge bg-secondary" x-text="user.role"></span>
                                    </template>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning" @click="editUser(user.id)">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" @click="deleteUser(user.id)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </template>
                        <tr x-show="!loading && users.length === 0">
                            <td colspan="5" class="text-center text-muted">Tidak ada data ditemukan.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3 d-flex justify-content-between">
                <div x-show="users.length > 0">
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
        </div>
    </div>

    <!-- Modal Form -->
    <div class="modal fade" :class="showModal ? 'show' : ''" :style="showModal ? 'display: block; background-color: rgba(0,0,0,0.5);' : 'display: none;'" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" x-text="form.id ? 'Edit User' : 'Tambah User'"></h5>
                    <button type="button" class="close" @click="showModal = false" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="saveUser()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" x-model="form.nama" placeholder="Nama user">
                            <template x-if="errors.nama">
                                <small class="text-danger" x-text="errors.nama[0]"></small>
                            </template>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" x-model="form.email" placeholder="Email user">
                            <template x-if="errors.email">
                                <small class="text-danger" x-text="errors.email[0]"></small>
                            </template>
                        </div>

                        <div class="form-group">
                            <label>Role</label>
                            <select class="form-control" x-model="form.role">
                                <option value="">-- Pilih Role --</option>
                                <option value="admin">Admin</option>
                                <option value="editor">Editor</option>
                                <option value="user">User</option>
                            </select>
                            <template x-if="errors.role">
                                <small class="text-danger" x-text="errors.role[0]"></small>
                            </template>
                        </div>

                        <div class="form-group">
                            <label>Password <span x-show="!form.id" class="text-danger">*</span></label>
                            <input type="password" class="form-control" x-model="form.password" :placeholder="form.id ? 'Kosongkan jika tidak ingin mengubah' : 'Password minimal 8 karakter'">
                            <template x-if="errors.password">
                                <small class="text-danger" x-text="errors.password[0]"></small>
                            </template>
                        </div>

                        <div class="form-group" x-show="form.password">
                            <label>Konfirmasi Password</label>
                            <input type="password" class="form-control" x-model="form.password_confirmation" placeholder="Konfirmasi password">
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
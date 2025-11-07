<x-admin.index>
<x-slot:title>Dokter</x-slot:title>
<x-slot:judul>Manajemen Dokter</x-slot:judul>

<div x-data="dokterManager" x-init="$watch('search', () => handleSearch())" x-cloak>
    <!-- Header dengan tombol tambah dan search -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5>Manajemen Dokter</h5>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary" @click="showModal = true; resetForm()">
                <i class="fas fa-plus"></i> Tambah Dokter
            </button>
        </div>
    </div>

    <!-- Search -->
    <div class="row mb-3">
        <div class="col-md-6">
            <input type="text" class="form-control" x-model="search" @keyup.debounce.300ms="handleSearch()" placeholder="Cari dokter...">
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
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Spesialis</th>
                    <th>Poli</th>
                    <th>Kontak</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="(dokter, index) in dokters" :key="dokter.id">
                    <tr>
                        <td x-text="pagination.from + index"></td>
                        <td>
                            <template x-if="dokter.foto">
                                <img :src="`/storage/${dokter.foto}`" :alt="dokter.nama" class="rounded-circle" width="50" height="50">
                            </template>
                            <template x-if="!dokter.foto">
                                <img src="https://via.placeholder.com/50" alt="No Image" class="rounded-circle" width="50" height="50">
                            </template>
                        </td>
                        <td x-text="dokter.nama"></td>
                        <td x-text="dokter.spesialis"></td>
                        <td x-text="dokter.poli ? dokter.poli.nama_poli : '-'"></td>
                        <td x-text="dokter.kontak || '-'"></td>
                        <td>
                            <template x-if="dokter.status === 'aktif'">
                                <span class="badge badge-success">Aktif</span>
                            </template>
                            <template x-if="dokter.status !== 'aktif'">
                                <span class="badge badge-secondary">Nonaktif</span>
                            </template>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-info" @click="editDokter(dokter.id)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" @click="deleteDokter(dokter.id)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </template>
                <tr x-show="!loading && dokters.length === 0">
                    <td colspan="8" class="text-center">Tidak ada data</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-between">
        <div x-show="dokters.length > 0">
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
                    <h5 class="modal-title" x-text="form.id ? 'Edit Dokter' : 'Tambah Dokter'"></h5>
                    <button type="button" class="close" @click="showModal = false" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="saveDokter()" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Dokter</label>
                                    <input type="text" class="form-control" x-model="form.nama" placeholder="Nama dokter">
                                    <template x-if="errors.nama">
                                        <small class="text-danger" x-text="errors.nama[0]"></small>
                                    </template>
                                </div>

                                <div class="form-group">
                                    <label>Spesialis</label>
                                    <input type="text" class="form-control" x-model="form.spesialis" placeholder="Spesialis">
                                    <template x-if="errors.spesialis">
                                        <small class="text-danger" x-text="errors.spesialis[0]"></small>
                                    </template>
                                </div>

                                <div class="form-group">
                                    <label>Poli</label>
                                    <select class="form-control" x-model="form.poli_id">
                                        <option value="">-- Pilih Poli --</option>
                                        <template x-for="poli in polis" :key="poli.id">
                                            <option :value="poli.id" x-text="poli.nama_poli"></option>
                                        </template>
                                    </select>
                                    <template x-if="errors.poli_id">
                                        <small class="text-danger" x-text="errors.poli_id[0]"></small>
                                    </template>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kontak</label>
                                    <input type="text" class="form-control" x-model="form.kontak" placeholder="Nomor telepon/HP">
                                    <template x-if="errors.kontak">
                                        <small class="text-danger" x-text="errors.kontak[0]"></small>
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
                                    <label>Foto</label>
                                    <input type="file" class="form-control" @change="form.foto = $event.target.files[0]" accept="image/*">
                                    <template x-if="form.foto && form.foto.type.startsWith('image/')">
                                        <img :src="URL.createObjectURL(form.foto)" class="mt-2 rounded shadow-sm" width="100">
                                    </template>
                                    <template x-if="errors.foto">
                                        <small class="text-danger" x-text="errors.foto[0]"></small>
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
document.addEventListener('alpine:init', () => {
    // Helper function to safely get CSRF token
    function getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    Alpine.data('kategoriManager', () => ({
        kategoris: [],
        loading: false,
        search: '',
        perPage: 10,
        pagination: {
            current_page: 1,
            last_page: 1,
            per_page: 10,
            total: 0,
            from: 0,
            to: 0,
        },
        
        // Form data
        form: {
            id: null,
            nama_kategori: '',
            slug: '',
        },
        
        // Form validation errors
        errors: {},
        
        // Modal state
        showModal: false,
        
        // Real-time polling interval
        pollingInterval: null,
        
        init() {
            this.loadKategoris();
            this.startPolling();
            
            // Watch for changes in nama_kategori to auto-update slug
            this.$watch('form.nama_kategori', (value) => {
                if (value) {
                    this.form.slug = value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
                }
            });
        },
        
        destroy() {
            this.stopPolling();
        },
        
        // Load kategoris with pagination and search
        async loadKategoris(page = 1) {
            this.loading = true;
            try {
                const params = new URLSearchParams({
                    page: page,
                    perPage: this.perPage,
                    search: this.search,
                });
                
                const response = await fetch(`/admin/api/kategori?${params}`);
                const data = await response.json();
                
                if (data.success) {
                    this.kategoris = data.data;
                    this.pagination = data.pagination;
                }
            } catch (error) {
                console.error('Error loading kategoris:', error);
                this.showToast('Error loading data', 'error');
            } finally {
                this.loading = false;
            }
        },
        
        // Save kategori (create or update)
        async saveKategori() {
            this.loading = true;
            this.errors = {};
            
            try {
                // Update slug when nama_kategori changes
                this.form.slug = this.form.nama_kategori.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
                
                const url = this.form.id 
                    ? `/admin/api/kategori/${this.form.id}` 
                    : '/admin/api/kategori';
                
                const method = this.form.id ? 'PUT' : 'POST';
                
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken(),
                    },
                    body: JSON.stringify(this.form),
                });
                
                const data = await response.json();
                
                if (data.success) {
                    this.showToast(data.message, 'success');
                    this.resetForm();
                    this.showModal = false;
                    this.loadKategoris(this.pagination.current_page);
                } else {
                    // Handle validation errors
                    if (data.errors) {
                        this.errors = data.errors;
                    }
                    this.showToast(data.message || 'Error saving data', 'error');
                }
            } catch (error) {
                console.error('Error saving kategori:', error);
                this.showToast('Error saving data', 'error');
            } finally {
                this.loading = false;
            }
        },
        
        // Edit kategori
        async editKategori(id) {
            try {
                const response = await fetch(`/admin/api/kategori/${id}`);
                const data = await response.json();
                
                if (data.success) {
                    this.form = {
                        id: data.data.id,
                        nama_kategori: data.data.nama_kategori,
                        slug: data.data.slug,
                    };
                    this.showModal = true;
                } else {
                    this.showToast(data.message || 'Error loading data', 'error');
                }
            } catch (error) {
                console.error('Error loading kategori:', error);
                this.showToast('Error loading data', 'error');
            }
        },
        
        // Delete kategori
        async deleteKategori(id) {
            try {
                const response = await fetch(`/admin/api/kategori/${id}`);
                const data = await response.json();
                
                if (data.success && data.data.beritas_count > 0) {
                    this.showToast('Kategori tidak dapat dihapus karena masih digunakan oleh berita', 'error');
                    return;
                }
                
                if (!confirm('Yakin ingin menghapus kategori ini?')) {
                    return;
                }
                
                const deleteResponse = await fetch(`/admin/api/kategori/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken(),
                    },
                });
                
                const deleteData = await deleteResponse.json();
                
                if (deleteData.success) {
                    this.showToast(deleteData.message, 'success');
                    this.loadKategoris(this.pagination.current_page);
                } else {
                    this.showToast(deleteData.message || 'Error deleting data', 'error');
                }
            } catch (error) {
                console.error('Error deleting kategori:', error);
                this.showToast('Error deleting data', 'error');
            }
        },
        
        // Reset form
        resetForm() {
            this.form = {
                id: null,
                nama_kategori: '',
                slug: '',
            };
            this.errors = {};
        },
        
        // Show toast notification
        showToast(message, type = 'success') {
            if (typeof Swal !== 'undefined') {
                const toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
                
                const iconMap = {
                    'success': 'success',
                    'error': 'error',
                    'warning': 'warning',
                    'info': 'info'
                };
                
                toast.fire({
                    icon: iconMap[type] || 'info',
                    title: message
                });
            } else {
                alert(message);
            }
        },
        
        // Start real-time polling
        startPolling() {
            this.pollingInterval = setInterval(() => {
                this.loadKategoris(this.pagination.current_page);
            }, 30000); // Poll every 30 seconds
        },
        
        // Stop real-time polling
        stopPolling() {
            if (this.pollingInterval) {
                clearInterval(this.pollingInterval);
                this.pollingInterval = null;
            }
        },
        
        // Handle search
        handleSearch() {
            this.pagination.current_page = 1;
            this.loadKategoris(1);
        },
        
        // Handle per page change
        handlePerPageChange() {
            this.pagination.current_page = 1;
            this.loadKategoris(1);
        },
        
        // Handle pagination
        goToPage(page) {
            if (page >= 1 && page <= this.pagination.last_page) {
                this.loadKategoris(page);
            }
        },
    }));
});
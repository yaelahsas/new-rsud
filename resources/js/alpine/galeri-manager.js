document.addEventListener('alpine:init', () => {
    // Helper function to safely get CSRF token
    function getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    Alpine.data('galeriManager', () => ({
        galeris: [],
        kategoris: [],
        loading: false,
        search: '',
        selectedKategori: '',
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
            judul: '',
            deskripsi: '',
            kategori: '',
            gambar: null,
            existing_gambar: null,
        },
        
        // Form validation errors
        errors: {},
        
        // Modal state
        showModal: false,
        
        // Real-time polling interval
        pollingInterval: null,
        
        init() {
            this.loadGaleris();
            this.loadKategoris();
            this.startPolling();
        },
        
        destroy() {
            this.stopPolling();
        },
        
        // Load galeris with pagination and search
        async loadGaleris(page = 1) {
            this.loading = true;
            try {
                const params = new URLSearchParams({
                    page: page,
                    perPage: this.perPage,
                    search: this.search,
                });
                
                if (this.selectedKategori) {
                    params.append('kategori', this.selectedKategori);
                }
                
                const response = await fetch(`/admin/api/galeri?${params}`);
                const data = await response.json();
                
                if (data.success) {
                    this.galeris = data.data;
                    this.pagination = data.pagination;
                }
            } catch (error) {
                console.error('Error loading galeris:', error);
                this.showToast('Error loading data', 'error');
            } finally {
                this.loading = false;
            }
        },
        
        // Load kategoris for dropdown
        async loadKategoris() {
            try {
                const response = await fetch('/admin/api/galeri/kategoris');
                const data = await response.json();
                
                if (data.success) {
                    this.kategoris = data.data;
                }
            } catch (error) {
                console.error('Error loading kategoris:', error);
            }
        },
        
        // Save galeri (create or update)
        async saveGaleri() {
            this.loading = true;
            this.errors = {};
            
            try {
                const url = this.form.id
                    ? `/admin/api/galeri/${this.form.id}`
                    : '/admin/api/galeri';
                 
                const method = this.form.id ? 'POST' : 'POST'; // Always use POST with FormData
                
                const formData = new FormData();
                
                // Add method spoofing for PUT requests
                if (this.form.id) {
                    formData.append('_method', 'PUT');
                }
                
                formData.append('judul', this.form.judul);
                formData.append('deskripsi', this.form.deskripsi);
                formData.append('kategori', this.form.kategori);
                
                if (this.form.gambar) {
                    formData.append('gambar', this.form.gambar);
                }
                
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'Accept': 'application/json',
                    },
                    body: formData,
                });
                
                // Check if response is a redirect (302)
                if (response.redirected) {
                    console.error('Request was redirected to:', response.url);
                    this.showToast('Request was redirected. Please check authentication.', 'error');
                    return;
                }
                
                // Check if response is HTML (indicating a redirect to login page)
                const contentType = response.headers.get('content-type');
                if (contentType && contentType.includes('text/html')) {
                    console.error('Received HTML response instead of JSON - likely a redirect');
                    this.showToast('Session expired. Please refresh the page.', 'error');
                    return;
                }
                
                const data = await response.json();
                
                if (data.success) {
                    this.showToast(data.message, 'success');
                    this.resetForm();
                    this.showModal = false;
                    this.loadGaleris(this.pagination.current_page);
                    this.loadKategoris(); // Reload kategoris in case new category was added
                } else {
                    // Handle validation errors
                    if (data.errors) {
                        this.errors = data.errors;
                    }
                    this.showToast(data.message || 'Error saving data', 'error');
                }
            } catch (error) {
                console.error('Error saving galeri:', error);
                this.showToast('Error saving data', 'error');
            } finally {
                this.loading = false;
            }
        },
        
        // Edit galeri
        async editGaleri(id) {
            try {
                const response = await fetch(`/admin/api/galeri/${id}`);
                const data = await response.json();
                
                if (data.success) {
                    this.form = {
                        id: data.data.id,
                        judul: data.data.judul,
                        deskripsi: data.data.deskripsi,
                        kategori: data.data.kategori,
                        gambar: null,
                        existing_gambar: data.data.gambar, // Store existing image
                    };
                    this.showModal = true;
                } else {
                    this.showToast(data.message || 'Error loading data', 'error');
                }
            } catch (error) {
                console.error('Error loading galeri:', error);
                this.showToast('Error loading data', 'error');
            }
        },
        
        // Delete galeri
        async deleteGaleri(id) {
            if (!confirm('Yakin ingin menghapus galeri ini?')) {
                return;
            }
            
            try {
                const response = await fetch(`/admin/api/galeri/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken(),
                    },
                });
                
                const data = await response.json();
                
                if (data.success) {
                    this.showToast(data.message, 'success');
                    this.loadGaleris(this.pagination.current_page);
                    this.loadKategoris(); // Reload kategoris in case category was removed
                } else {
                    this.showToast(data.message || 'Error deleting data', 'error');
                }
            } catch (error) {
                console.error('Error deleting galeri:', error);
                this.showToast('Error deleting data', 'error');
            }
        },
        
        // Reset form
        resetForm() {
            this.form = {
                id: null,
                judul: '',
                deskripsi: '',
                kategori: '',
                gambar: null,
                existing_gambar: null, // Reset existing image
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
                this.loadGaleris(this.pagination.current_page);
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
            this.loadGaleris(1);
        },
        
        // Handle category filter
        handleKategoriFilter() {
            this.pagination.current_page = 1;
            this.loadGaleris(1);
        },
        
        // Handle per page change
        handlePerPageChange() {
            this.pagination.current_page = 1;
            this.loadGaleris(1);
        },
        
        // Handle pagination
        goToPage(page) {
            if (page >= 1 && page <= this.pagination.last_page) {
                this.loadGaleris(page);
            }
        },
    }));
});
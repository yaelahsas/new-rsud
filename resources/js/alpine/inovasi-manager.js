document.addEventListener('alpine:init', () => {
    // Helper function to safely get CSRF token
    function getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    Alpine.data('inovasiManager', () => ({
        inovasis: [],
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
            nama_inovasi: '',
            slug: '',
            deskripsi: '',
            link: '',
            status: 'aktif',
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
            this.loadInovasis();
            this.startPolling();
            
            // Watch for changes in nama_inovasi to auto-update slug
            this.$watch('form.nama_inovasi', (value) => {
                if (value) {
                    this.form.slug = value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
                }
            });
        },
        
        destroy() {
            this.stopPolling();
        },
        
        // Load inovasis with pagination and search
        async loadInovasis(page = 1) {
            this.loading = true;
            try {
                const params = new URLSearchParams({
                    page: page,
                    perPage: this.perPage,
                    search: this.search,
                });
                
                const response = await fetch(`/admin/api/inovasi?${params}`);
                const data = await response.json();
                
                if (data.success) {
                    this.inovasis = data.data;
                    this.pagination = data.pagination;
                }
            } catch (error) {
                console.error('Error loading inovasis:', error);
                this.showToast('Error loading data', 'error');
            } finally {
                this.loading = false;
            }
        },
        
        // Save inovasi (create or update)
        async saveInovasi() {
            this.loading = true;
            this.errors = {};
            
            try {
                // Update slug when nama_inovasi changes
                this.form.slug = this.form.nama_inovasi.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
                
                const url = this.form.id
                    ? `/admin/api/inovasi/${this.form.id}`
                    : '/admin/api/inovasi';
                 
                const method = this.form.id ? 'POST' : 'POST'; // Always use POST with FormData
                
                const formData = new FormData();
                
                // Add method spoofing for PUT requests
                if (this.form.id) {
                    formData.append('_method', 'PUT');
                }
                
                formData.append('nama_inovasi', this.form.nama_inovasi);
                formData.append('slug', this.form.slug);
                formData.append('deskripsi', this.form.deskripsi);
                formData.append('link', this.form.link);
                formData.append('status', this.form.status);
                
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
                    this.loadInovasis(this.pagination.current_page);
                } else {
                    // Handle validation errors
                    if (data.errors) {
                        this.errors = data.errors;
                    }
                    this.showToast(data.message || 'Error saving data', 'error');
                }
            } catch (error) {
                console.error('Error saving inovasi:', error);
                this.showToast('Error saving data', 'error');
            } finally {
                this.loading = false;
            }
        },
        
        // Edit inovasi
        async editInovasi(id) {
            try {
                const response = await fetch(`/admin/api/inovasi/${id}`);
                const data = await response.json();
                
                if (data.success) {
                    this.form = {
                        id: data.data.id,
                        nama_inovasi: data.data.nama_inovasi,
                        slug: data.data.slug,
                        deskripsi: data.data.deskripsi,
                        link: data.data.link,
                        status: data.data.status,
                        gambar: null,
                        existing_gambar: data.data.gambar, // Store existing image
                    };
                    this.showModal = true;
                } else {
                    this.showToast(data.message || 'Error loading data', 'error');
                }
            } catch (error) {
                console.error('Error loading inovasi:', error);
                this.showToast('Error loading data', 'error');
            }
        },
        
        // Delete inovasi
        async deleteInovasi(id) {
            if (!confirm('Yakin ingin menghapus inovasi ini?')) {
                return;
            }
            
            try {
                const response = await fetch(`/admin/api/inovasi/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken(),
                    },
                });
                
                const data = await response.json();
                
                if (data.success) {
                    this.showToast(data.message, 'success');
                    this.loadInovasis(this.pagination.current_page);
                } else {
                    this.showToast(data.message || 'Error deleting data', 'error');
                }
            } catch (error) {
                console.error('Error deleting inovasi:', error);
                this.showToast('Error deleting data', 'error');
            }
        },
        
        // Toggle status
        async toggleStatus(id) {
            try {
                const response = await fetch(`/admin/api/inovasi/${id}/toggle`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken(),
                    },
                });
                
                const data = await response.json();
                
                if (data.success) {
                    this.showToast(data.message, 'success');
                    this.loadInovasis(this.pagination.current_page);
                } else {
                    this.showToast(data.message || 'Error updating status', 'error');
                }
            } catch (error) {
                console.error('Error toggling status:', error);
                this.showToast('Error updating status', 'error');
            }
        },
        
        // Reset form
        resetForm() {
            this.form = {
                id: null,
                nama_inovasi: '',
                slug: '',
                deskripsi: '',
                link: '',
                status: 'aktif',
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
                this.loadInovasis(this.pagination.current_page);
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
            this.loadInovasis(1);
        },
        
        // Handle per page change
        handlePerPageChange() {
            this.pagination.current_page = 1;
            this.loadInovasis(1);
        },
        
        // Handle pagination
        goToPage(page) {
            if (page >= 1 && page <= this.pagination.last_page) {
                this.loadInovasis(page);
            }
        },
    }));
});
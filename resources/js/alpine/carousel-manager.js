document.addEventListener('alpine:init', () => {
    // Helper function to safely get CSRF token
    function getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    Alpine.data('carouselManager', () => ({
        carousels: [],
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
            judul: '',
            deskripsi: '',
            link: '',
            urutan: 0,
            aktif: true,
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
            this.loadCarousels();
            this.startPolling();
        },
        
        destroy() {
            this.stopPolling();
        },
        
        // Load carousels with pagination and search
        async loadCarousels(page = 1) {
            this.loading = true;
            try {
                const params = new URLSearchParams({
                    page: page,
                    perPage: this.perPage,
                    search: this.search,
                });
                
                const response = await fetch(`/admin/api/carousel?${params}`);
                const data = await response.json();
                
                if (data.success) {
                    this.carousels = data.data;
                    this.pagination = data.pagination;
                }
            } catch (error) {
                console.error('Error loading carousels:', error);
                this.showToast('Error loading data', 'error');
            } finally {
                this.loading = false;
            }
        },
        
        // Save carousel (create or update)
        async saveCarousel() {
            this.loading = true;
            this.errors = {};
            
            try {
                const url = this.form.id
                    ? `/admin/api/carousel/${this.form.id}`
                    : '/admin/api/carousel';
                 
                const method = this.form.id ? 'POST' : 'POST'; // Always use POST with FormData
                
                const formData = new FormData();
                
                // Add method spoofing for PUT requests
                if (this.form.id) {
                    formData.append('_method', 'PUT');
                }
                
                formData.append('judul', this.form.judul);
                formData.append('deskripsi', this.form.deskripsi);
                formData.append('link', this.form.link);
                formData.append('urutan', this.form.urutan);
                formData.append('aktif', this.form.aktif ? '1' : '0'); // Convert boolean to string
                
                if (this.form.gambar) {
                    formData.append('gambar', this.form.gambar);
                }
                
                // Debug logging
                console.log('Saving carousel:', {
                    url,
                    method: this.form.id ? 'PUT (simulated with POST + _method)' : 'POST',
                    formData: Object.fromEntries(formData.entries())
                });
                
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
                console.log('Response data:', data);
                
                if (data.success) {
                    this.showToast(data.message, 'success');
                    this.resetForm();
                    this.showModal = false;
                    this.loadCarousels(this.pagination.current_page);
                } else {
                    // Handle validation errors
                    if (data.errors) {
                        this.errors = data.errors;
                    }
                    this.showToast(data.message || 'Error saving data', 'error');
                }
            } catch (error) {
                console.error('Error saving carousel:', error);
                this.showToast('Error saving data', 'error');
            } finally {
                this.loading = false;
            }
        },
        
        // Edit carousel
        async editCarousel(id) {
            try {
                const response = await fetch(`/admin/api/carousel/${id}`);
                const data = await response.json();
                
                if (data.success) {
                    this.form = {
                        id: data.data.id,
                        judul: data.data.judul,
                        deskripsi: data.data.deskripsi,
                        link: data.data.link,
                        urutan: data.data.urutan,
                        aktif: Boolean(data.data.aktif), // Ensure boolean
                        gambar: null,
                        existing_gambar: data.data.gambar, // Store existing image
                    };
                    this.showModal = true;
                } else {
                    this.showToast(data.message || 'Error loading data', 'error');
                }
            } catch (error) {
                console.error('Error loading carousel:', error);
                this.showToast('Error loading data', 'error');
            }
        },
        
        // Delete carousel
        async deleteCarousel(id) {
            if (!confirm('Yakin ingin menghapus carousel ini?')) {
                return;
            }
            
            try {
                const response = await fetch(`/admin/api/carousel/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken(),
                    },
                });
                
                const data = await response.json();
                
                if (data.success) {
                    this.showToast(data.message, 'success');
                    this.loadCarousels(this.pagination.current_page);
                } else {
                    this.showToast(data.message || 'Error deleting data', 'error');
                }
            } catch (error) {
                console.error('Error deleting carousel:', error);
                this.showToast('Error deleting data', 'error');
            }
        },
        
        // Toggle status
        async toggleStatus(id) {
            try {
                const response = await fetch(`/admin/api/carousel/${id}/toggle`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken(),
                    },
                });
                
                const data = await response.json();
                
                if (data.success) {
                    this.showToast(data.message, 'success');
                    this.loadCarousels(this.pagination.current_page);
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
                judul: '',
                deskripsi: '',
                link: '',
                urutan: 0,
                aktif: true,
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
                this.loadCarousels(this.pagination.current_page);
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
            this.loadCarousels(1);
        },
        
        // Handle per page change
        handlePerPageChange() {
            this.pagination.current_page = 1;
            this.loadCarousels(1);
        },
        
        // Handle pagination
        goToPage(page) {
            if (page >= 1 && page <= this.pagination.last_page) {
                this.loadCarousels(page);
            }
        },
    }));
});
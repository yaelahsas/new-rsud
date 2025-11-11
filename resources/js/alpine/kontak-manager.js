document.addEventListener('alpine:init', () => {
    // Helper function to safely get CSRF token
    function getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    Alpine.data('kontakManager', () => ({
        kontak: [],
        loading: false,
        search: '',
        selectedJenis: '',
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
            jenis_kontak: '',
            label: '',
            value: '',
            icon: '',
        },
        
        // Form validation errors
        errors: {},
        
        // Modal state
        showModal: false,
        
        // Real-time polling interval
        pollingInterval: null,
        
        // Predefined icons
        iconOptions: [
            'fas fa-phone',
            'fas fa-envelope',
            'fas fa-map-marker-alt',
            'fas fa-clock',
            'fas fa-globe',
            'fas fa-facebook',
            'fas fa-twitter',
            'fas fa-instagram',
            'fas fa-youtube',
            'fas fa-whatsapp',
            'fas fa-linkedin',
            'fas fa-tiktok',
        ],
        
        // Predefined jenis kontak
        jenisKontakOptions: [
            'Telepon',
            'Email',
            'Alamat',
            'Jam Operasional',
            'Website',
            'Social Media',
        ],
        
        init() {
            this.loadKontak();
            this.startPolling();
        },
        
        destroy() {
            this.stopPolling();
        },
        
        // Load kontak with pagination and search
        async loadKontak(page = 1) {
            this.loading = true;
            try {
                const params = new URLSearchParams({
                    page: page,
                    perPage: this.perPage,
                    search: this.search,
                });
                
                if (this.selectedJenis) {
                    params.append('jenis_kontak', this.selectedJenis);
                }
                
                const response = await fetch(`/admin/api/kontak?${params}`);
                const data = await response.json();
                
                if (data.success) {
                    this.kontak = data.data;
                    this.pagination = data.pagination;
                }
            } catch (error) {
                console.error('Error loading kontak:', error);
                this.showToast('Error loading data', 'error');
            } finally {
                this.loading = false;
            }
        },
        
        // Save kontak (create or update)
        async saveKontak() {
            this.loading = true;
            this.errors = {};
            
            try {
                const url = this.form.id
                    ? `/admin/api/kontak/${this.form.id}`
                    : '/admin/api/kontak';
                 
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
                    this.loadKontak(this.pagination.current_page);
                } else {
                    // Handle validation errors
                    if (data.errors) {
                        this.errors = data.errors;
                    }
                    this.showToast(data.message || 'Error saving data', 'error');
                }
            } catch (error) {
                console.error('Error saving kontak:', error);
                this.showToast('Error saving data', 'error');
            } finally {
                this.loading = false;
            }
        },
        
        // Edit kontak
        async editKontak(id) {
            try {
                const response = await fetch(`/admin/api/kontak/${id}`);
                const data = await response.json();
                
                if (data.success) {
                    this.form = {
                        id: data.data.id,
                        jenis_kontak: data.data.jenis_kontak,
                        label: data.data.label,
                        value: data.data.value,
                        icon: data.data.icon,
                    };
                    this.showModal = true;
                } else {
                    this.showToast(data.message || 'Error loading data', 'error');
                }
            } catch (error) {
                console.error('Error loading kontak:', error);
                this.showToast('Error loading data', 'error');
            }
        },
        
        // Delete kontak
        async deleteKontak(id) {
            if (!confirm('Yakin ingin menghapus kontak ini?')) {
                return;
            }
            
            try {
                const response = await fetch(`/admin/api/kontak/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken(),
                    },
                });
                
                const data = await response.json();
                
                if (data.success) {
                    this.showToast(data.message, 'success');
                    this.loadKontak(this.pagination.current_page);
                } else {
                    this.showToast(data.message || 'Error deleting data', 'error');
                }
            } catch (error) {
                console.error('Error deleting kontak:', error);
                this.showToast('Error deleting data', 'error');
            }
        },
        
        // Reset form
        resetForm() {
            this.form = {
                id: null,
                jenis_kontak: '',
                label: '',
                value: '',
                icon: '',
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
                this.loadKontak(this.pagination.current_page);
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
            this.loadKontak(1);
        },
        
        // Handle jenis filter
        handleJenisFilter() {
            this.pagination.current_page = 1;
            this.loadKontak(1);
        },
        
        // Handle per page change
        handlePerPageChange() {
            this.pagination.current_page = 1;
            this.loadKontak(1);
        },
        
        // Handle pagination
        goToPage(page) {
            if (page >= 1 && page <= this.pagination.last_page) {
                this.loadKontak(page);
            }
        },
    }));
});
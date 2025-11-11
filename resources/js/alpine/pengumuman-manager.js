document.addEventListener('alpine:init', () => {
    // Helper function to safely get CSRF token
    function getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    Alpine.data('pengumumanManager', () => ({
        pengumumen: [],
        loading: false,
        search: '',
        selectedStatus: '',
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
            isi: '',
            gambar: null,
            existing_gambar: null,
            tanggal_mulai: '',
            tanggal_selesai: '',
            aktif: true,
        },
        
        // Form validation errors
        errors: {},
        
        // Modal state
        showModal: false,
        
        // Real-time polling interval
        pollingInterval: null,
        
        init() {
            this.loadPengumumen();
            this.startPolling();
        },
        
        destroy() {
            this.stopPolling();
        },
        
        // Load pengumumen with pagination and search
        async loadPengumumen(page = 1) {
            this.loading = true;
            try {
                const params = new URLSearchParams({
                    page: page,
                    perPage: this.perPage,
                    search: this.search,
                });
                
                if (this.selectedStatus !== '') {
                    params.append('aktif', this.selectedStatus);
                }
                
                const response = await fetch(`/admin/api/pengumuman?${params}`);
                const data = await response.json();
                
                if (data.success) {
                    this.pengumumen = data.data;
                    this.pagination = data.pagination;
                }
            } catch (error) {
                console.error('Error loading pengumumen:', error);
                this.showToast('Error loading data', 'error');
            } finally {
                this.loading = false;
            }
        },
        
        // Save pengumuman (create or update)
        async savePengumuman() {
            this.loading = true;
            this.errors = {};
            
            try {
                const url = this.form.id
                    ? `/admin/api/pengumuman/${this.form.id}`
                    : '/admin/api/pengumuman';
                 
                const method = this.form.id ? 'POST' : 'POST'; // Always use POST with FormData
                
                const formData = new FormData();
                
                // Add method spoofing for PUT requests
                if (this.form.id) {
                    formData.append('_method', 'PUT');
                }
                
                formData.append('judul', this.form.judul);
                formData.append('isi', this.form.isi);
                formData.append('tanggal_mulai', this.form.tanggal_mulai);
                formData.append('tanggal_selesai', this.form.tanggal_selesai);
                formData.append('aktif', this.form.aktif ? '1' : '0');
                
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
                    this.loadPengumumen(this.pagination.current_page);
                } else {
                    // Handle validation errors
                    if (data.errors) {
                        this.errors = data.errors;
                    }
                    this.showToast(data.message || 'Error saving data', 'error');
                }
            } catch (error) {
                console.error('Error saving pengumuman:', error);
                this.showToast('Error saving data', 'error');
            } finally {
                this.loading = false;
            }
        },
        
        // Edit pengumuman
        async editPengumuman(id) {
            try {
                const response = await fetch(`/admin/api/pengumuman/${id}`);
                const data = await response.json();
                
                if (data.success) {
                    this.form = {
                        id: data.data.id,
                        judul: data.data.judul,
                        isi: data.data.isi,
                        gambar: null,
                        existing_gambar: data.data.gambar, // Store existing image
                        tanggal_mulai: data.data.tanggal_mulai || '',
                        tanggal_selesai: data.data.tanggal_selesai || '',
                        aktif: Boolean(data.data.aktif),
                    };
                    this.showModal = true;
                } else {
                    this.showToast(data.message || 'Error loading data', 'error');
                }
            } catch (error) {
                console.error('Error loading pengumuman:', error);
                this.showToast('Error loading data', 'error');
            }
        },
        
        // Delete pengumuman
        async deletePengumuman(id) {
            if (!confirm('Yakin ingin menghapus pengumuman ini?')) {
                return;
            }
            
            try {
                const response = await fetch(`/admin/api/pengumuman/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken(),
                    },
                });
                
                const data = await response.json();
                
                if (data.success) {
                    this.showToast(data.message, 'success');
                    this.loadPengumumen(this.pagination.current_page);
                } else {
                    this.showToast(data.message || 'Error deleting data', 'error');
                }
            } catch (error) {
                console.error('Error deleting pengumuman:', error);
                this.showToast('Error deleting data', 'error');
            }
        },
        
        // Toggle status
        async toggleStatus(id) {
            try {
                const response = await fetch(`/admin/api/pengumuman/${id}/toggle`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken(),
                    },
                });
                
                const data = await response.json();
                
                if (data.success) {
                    this.showToast(data.message, 'success');
                    this.loadPengumumen(this.pagination.current_page);
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
                isi: '',
                gambar: null,
                existing_gambar: null, // Reset existing image
                tanggal_mulai: '',
                tanggal_selesai: '',
                aktif: true,
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
                this.loadPengumumen(this.pagination.current_page);
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
            this.loadPengumumen(1);
        },
        
        // Handle status filter
        handleStatusFilter() {
            this.pagination.current_page = 1;
            this.loadPengumumen(1);
        },
        
        // Handle per page change
        handlePerPageChange() {
            this.pagination.current_page = 1;
            this.loadPengumumen(1);
        },
        
        // Handle pagination
        goToPage(page) {
            if (page >= 1 && page <= this.pagination.last_page) {
                this.loadPengumumen(page);
            }
        },
        
        // Format date for display
        formatDate(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            return date.toLocaleDateString('id-ID');
        },
    }));
});
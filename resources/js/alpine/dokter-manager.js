document.addEventListener('alpine:init', () => {
    // Helper function to safely get CSRF token
    function getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    Alpine.data('dokterManager', () => ({
        dokters: [],
        polis: [],
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
            nama: '',
            spesialis: '',
            poli_id: '',
            kontak: '',
            status: 'aktif',
            foto: null,
        },
        
        // Form validation errors
        errors: {},
        
        // Modal state
        showModal: false,
        
        // Real-time polling interval
        pollingInterval: null,
        
        init() {
            this.loadDokters();
            this.loadPolis();
            this.startPolling();
        },
        
        destroy() {
            this.stopPolling();
        },
        
        // Load dokters with pagination and search
        async loadDokters(page = 1) {
            this.loading = true;
            try {
                const params = new URLSearchParams({
                    page: page,
                    perPage: this.perPage,
                    search: this.search,
                });
                
                const response = await fetch(`/admin/api/dokter?${params}`);
                const data = await response.json();
                
                if (data.success) {
                    this.dokters = data.data;
                    this.pagination = data.pagination;
                }
            } catch (error) {
                console.error('Error loading dokters:', error);
                this.showToast('Error loading data', 'error');
            } finally {
                this.loading = false;
            }
        },
        
        // Load polis for dropdown
        async loadPolis() {
            try {
                const response = await fetch('/admin/api/dokter/polis');
                const data = await response.json();
                
                if (data.success) {
                    this.polis = data.data;
                }
            } catch (error) {
                console.error('Error loading polis:', error);
            }
        },
        
        // Save dokter (create or update)
        async saveDokter() {
            this.loading = true;
            this.errors = {};
            
            try {
                const url = this.form.id 
                    ? `/admin/api/dokter/${this.form.id}` 
                    : '/admin/api/dokter';
                
                const method = this.form.id ? 'PUT' : 'POST';
                
                const formData = new FormData();
                
                formData.append('nama', this.form.nama);
                formData.append('spesialis', this.form.spesialis);
                formData.append('poli_id', this.form.poli_id);
                formData.append('kontak', this.form.kontak);
                formData.append('status', this.form.status);
                
                if (this.form.foto) {
                    formData.append('foto', this.form.foto);
                }
                
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken(),
                    },
                    body: formData,
                });
                
                const data = await response.json();
                
                if (data.success) {
                    this.showToast(data.message, 'success');
                    this.resetForm();
                    this.showModal = false;
                    this.loadDokters(this.pagination.current_page);
                } else {
                    // Handle validation errors
                    if (data.errors) {
                        this.errors = data.errors;
                    }
                    this.showToast(data.message || 'Error saving data', 'error');
                }
            } catch (error) {
                console.error('Error saving dokter:', error);
                this.showToast('Error saving data', 'error');
            } finally {
                this.loading = false;
            }
        },
        
        // Edit dokter
        async editDokter(id) {
            try {
                const response = await fetch(`/admin/api/dokter/${id}`);
                const data = await response.json();
                
                if (data.success) {
                    this.form = {
                        id: data.data.id,
                        nama: data.data.nama,
                        spesialis: data.data.spesialis,
                        poli_id: data.data.poli_id,
                        kontak: data.data.kontak,
                        status: data.data.status,
                        foto: null,
                    };
                    this.showModal = true;
                } else {
                    this.showToast(data.message || 'Error loading data', 'error');
                }
            } catch (error) {
                console.error('Error loading dokter:', error);
                this.showToast('Error loading data', 'error');
            }
        },
        
        // Delete dokter
        async deleteDokter(id) {
            try {
                const response = await fetch(`/admin/api/dokter/${id}`);
                const data = await response.json();
                
                if (data.success && data.data.jadwals_count > 0) {
                    this.showToast('Dokter tidak dapat dihapus karena masih memiliki jadwal praktik', 'error');
                    return;
                }
                
                if (!confirm('Yakin ingin menghapus dokter ini?')) {
                    return;
                }
                
                const deleteResponse = await fetch(`/admin/api/dokter/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken(),
                    },
                });
                
                const deleteData = await deleteResponse.json();
                
                if (deleteData.success) {
                    this.showToast(deleteData.message, 'success');
                    this.loadDokters(this.pagination.current_page);
                } else {
                    this.showToast(deleteData.message || 'Error deleting data', 'error');
                }
            } catch (error) {
                console.error('Error deleting dokter:', error);
                this.showToast('Error deleting data', 'error');
            }
        },
        
        // Reset form
        resetForm() {
            this.form = {
                id: null,
                nama: '',
                spesialis: '',
                poli_id: '',
                kontak: '',
                status: 'aktif',
                foto: null,
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
                this.loadDokters(this.pagination.current_page);
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
            this.loadDokters(1);
        },
        
        // Handle per page change
        handlePerPageChange() {
            this.pagination.current_page = 1;
            this.loadDokters(1);
        },
        
        // Handle pagination
        goToPage(page) {
            if (page >= 1 && page <= this.pagination.last_page) {
                this.loadDokters(page);
            }
        },
    }));
});
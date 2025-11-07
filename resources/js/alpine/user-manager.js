document.addEventListener('alpine:init', () => {
    // Helper function to safely get CSRF token
    function getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    Alpine.data('userManager', () => ({
        users: [],
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
            email: '',
            role: '',
            password: '',
            password_confirmation: '',
        },
        
        // Form validation errors
        errors: {},
        
        // Modal state
        showModal: false,
        
        // Real-time polling interval
        pollingInterval: null,
        
        init() {
            this.loadUsers();
            this.startPolling();
        },
        
        destroy() {
            this.stopPolling();
        },
        
        // Load users with pagination and search
        async loadUsers(page = 1) {
            this.loading = true;
            try {
                const params = new URLSearchParams({
                    page: page,
                    perPage: this.perPage,
                    search: this.search,
                });
                
                const response = await fetch(`/admin/api/user?${params}`);
                const data = await response.json();
                
                if (data.success) {
                    this.users = data.data;
                    this.pagination = data.pagination;
                }
            } catch (error) {
                console.error('Error loading users:', error);
                this.showToast('Error loading data', 'error');
            } finally {
                this.loading = false;
            }
        },
        
        // Save user (create or update)
        async saveUser() {
            this.loading = true;
            this.errors = {};
            
            try {
                const url = this.form.id 
                    ? `/admin/api/user/${this.form.id}` 
                    : '/admin/api/user';
                
                const method = this.form.id ? 'PUT' : 'POST';
                
                const formData = {
                    nama: this.form.nama,
                    email: this.form.email,
                    role: this.form.role,
                };
                
                // Only include password if it's provided (for create or update)
                if (this.form.password) {
                    formData.password = this.form.password;
                }
                
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken(),
                    },
                    body: JSON.stringify(formData),
                });
                
                const data = await response.json();
                
                if (data.success) {
                    this.showToast(data.message, 'success');
                    this.resetForm();
                    this.showModal = false;
                    this.loadUsers(this.pagination.current_page);
                } else {
                    // Handle validation errors
                    if (data.errors) {
                        this.errors = data.errors;
                    }
                    this.showToast(data.message || 'Error saving data', 'error');
                }
            } catch (error) {
                console.error('Error saving user:', error);
                this.showToast('Error saving data', 'error');
            } finally {
                this.loading = false;
            }
        },
        
        // Edit user
        async editUser(id) {
            try {
                const response = await fetch(`/admin/api/user/${id}`);
                const data = await response.json();
                
                if (data.success) {
                    this.form = {
                        id: data.data.id,
                        nama: data.data.nama,
                        email: data.data.email,
                        role: data.data.role,
                        password: '',
                        password_confirmation: '',
                    };
                    this.showModal = true;
                } else {
                    this.showToast(data.message || 'Error loading data', 'error');
                }
            } catch (error) {
                console.error('Error loading user:', error);
                this.showToast('Error loading data', 'error');
            }
        },
        
        // Delete user
        async deleteUser(id) {
            if (!confirm('Yakin ingin menghapus user ini?')) {
                return;
            }
            
            try {
                const response = await fetch(`/admin/api/user/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken(),
                    },
                });
                
                const data = await response.json();
                
                if (data.success) {
                    this.showToast(data.message, 'success');
                    this.loadUsers(this.pagination.current_page);
                } else {
                    this.showToast(data.message || 'Error deleting data', 'error');
                }
            } catch (error) {
                console.error('Error deleting user:', error);
                this.showToast('Error deleting data', 'error');
            }
        },
        
        // Reset form
        resetForm() {
            this.form = {
                id: null,
                nama: '',
                email: '',
                role: '',
                password: '',
                password_confirmation: '',
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
                this.loadUsers(this.pagination.current_page);
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
            this.loadUsers(1);
        },
        
        // Handle per page change
        handlePerPageChange() {
            this.pagination.current_page = 1;
            this.loadUsers(1);
        },
        
        // Handle pagination
        goToPage(page) {
            if (page >= 1 && page <= this.pagination.last_page) {
                this.loadUsers(page);
            }
        },
    }));
});
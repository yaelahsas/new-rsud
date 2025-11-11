document.addEventListener('alpine:init', () => {
    // Helper function to safely get CSRF token
    function getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    Alpine.data('settingManager', () => ({
        settings: [],
        categories: [],
        loading: false,
        search: '',
        selectedCategory: '',
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
            key: '',
            value: '',
        },
        
        // Bulk update form
        bulkForm: {
            settings: [],
        },
        
        // Form validation errors
        errors: {},
        
        // Modal state
        showModal: false,
        showBulkModal: false,
        
        // Real-time polling interval
        pollingInterval: null,
        
        init() {
            this.loadSettings();
            this.loadCategories();
            this.startPolling();
        },
        
        destroy() {
            this.stopPolling();
        },
        
        // Load settings with pagination and search
        async loadSettings(page = 1) {
            this.loading = true;
            try {
                const params = new URLSearchParams({
                    page: page,
                    perPage: this.perPage,
                    search: this.search,
                });
                
                if (this.selectedCategory) {
                    params.append('category', this.selectedCategory);
                }
                
                const response = await fetch(`/admin/api/setting?${params}`);
                const data = await response.json();
                
                if (data.success) {
                    this.settings = data.data;
                    this.pagination = data.pagination;
                }
            } catch (error) {
                console.error('Error loading settings:', error);
                this.showToast('Error loading data', 'error');
            } finally {
                this.loading = false;
            }
        },
        
        // Load categories for dropdown
        async loadCategories() {
            try {
                const response = await fetch('/admin/api/setting/categories');
                const data = await response.json();
                
                if (data.success) {
                    this.categories = data.data;
                }
            } catch (error) {
                console.error('Error loading categories:', error);
            }
        },
        
        // Save setting (create or update)
        async saveSetting() {
            this.loading = true;
            this.errors = {};
            
            try {
                const url = this.form.id
                    ? `/admin/api/setting/${this.form.id}`
                    : '/admin/api/setting';
                 
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
                    this.loadSettings(this.pagination.current_page);
                } else {
                    // Handle validation errors
                    if (data.errors) {
                        this.errors = data.errors;
                    }
                    this.showToast(data.message || 'Error saving data', 'error');
                }
            } catch (error) {
                console.error('Error saving setting:', error);
                this.showToast('Error saving data', 'error');
            } finally {
                this.loading = false;
            }
        },
        
        // Edit setting
        async editSetting(id) {
            try {
                const response = await fetch(`/admin/api/setting/${id}`);
                const data = await response.json();
                
                if (data.success) {
                    this.form = {
                        id: data.data.id,
                        key: data.data.key,
                        value: data.data.value,
                    };
                    this.showModal = true;
                } else {
                    this.showToast(data.message || 'Error loading data', 'error');
                }
            } catch (error) {
                console.error('Error loading setting:', error);
                this.showToast('Error loading data', 'error');
            }
        },
        
        // Delete setting
        async deleteSetting(id) {
            if (!confirm('Yakin ingin menghapus setting ini?')) {
                return;
            }
            
            try {
                const response = await fetch(`/admin/api/setting/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken(),
                    },
                });
                
                const data = await response.json();
                
                if (data.success) {
                    this.showToast(data.message, 'success');
                    this.loadSettings(this.pagination.current_page);
                } else {
                    this.showToast(data.message || 'Error deleting data', 'error');
                }
            } catch (error) {
                console.error('Error deleting setting:', error);
                this.showToast('Error deleting data', 'error');
            }
        },
        
        // Bulk update settings
        async bulkUpdateSettings() {
            this.loading = true;
            this.errors = {};
            
            try {
                const response = await fetch('/admin/api/setting/bulk', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken(),
                    },
                    body: JSON.stringify({
                        settings: this.bulkForm.settings
                    }),
                });
                
                const data = await response.json();
                
                if (data.success) {
                    this.showToast(data.message, 'success');
                    this.resetBulkForm();
                    this.showBulkModal = false;
                    this.loadSettings(1);
                } else {
                    // Handle validation errors
                    if (data.errors) {
                        this.errors = data.errors;
                    }
                    this.showToast(data.message || 'Error updating data', 'error');
                }
            } catch (error) {
                console.error('Error bulk updating settings:', error);
                this.showToast('Error updating data', 'error');
            } finally {
                this.loading = false;
            }
        },
        
        // Reset form
        resetForm() {
            this.form = {
                id: null,
                key: '',
                value: '',
            };
            this.errors = {};
        },
        
        // Reset bulk form
        resetBulkForm() {
            this.bulkForm = {
                settings: [],
            };
            this.errors = {};
        },
        
        // Add setting to bulk form
        addBulkSetting() {
            this.bulkForm.settings.push({
                key: '',
                value: '',
            });
        },
        
        // Remove setting from bulk form
        removeBulkSetting(index) {
            this.bulkForm.settings.splice(index, 1);
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
                this.loadSettings(this.pagination.current_page);
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
            this.loadSettings(1);
        },
        
        // Handle category filter
        handleCategoryFilter() {
            this.pagination.current_page = 1;
            this.loadSettings(1);
        },
        
        // Handle per page change
        handlePerPageChange() {
            this.pagination.current_page = 1;
            this.loadSettings(1);
        },
        
        // Handle pagination
        goToPage(page) {
            if (page >= 1 && page <= this.pagination.last_page) {
                this.loadSettings(page);
            }
        },
    }));
});
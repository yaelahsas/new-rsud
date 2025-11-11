document.addEventListener('alpine:init', () => {
    // Helper function to safely get CSRF token
    function getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    Alpine.data('logAktivitasManager', () => ({
        logs: [],
        modules: [],
        users: [],
        loading: false,
        search: '',
        selectedModul: '',
        selectedUser: '',
        tanggalMulai: '',
        tanggalSelesai: '',
        perPage: 10,
        pagination: {
            current_page: 1,
            last_page: 1,
            per_page: 10,
            total: 0,
            from: 0,
            to: 0,
        },
        
        // Form data for clearing logs
        clearForm: {
            days: 30,
        },
        
        // Modal state
        showClearModal: false,
        
        // Real-time polling interval
        pollingInterval: null,
        
        init() {
            this.loadLogs();
            this.loadModules();
            this.loadUsers();
            this.startPolling();
        },
        
        destroy() {
            this.stopPolling();
        },
        
        // Load logs with pagination and search
        async loadLogs(page = 1) {
            this.loading = true;
            try {
                const params = new URLSearchParams({
                    page: page,
                    perPage: this.perPage,
                    search: this.search,
                });
                
                if (this.selectedModul) {
                    params.append('modul', this.selectedModul);
                }
                
                if (this.selectedUser) {
                    params.append('user_id', this.selectedUser);
                }
                
                if (this.tanggalMulai) {
                    params.append('tanggal_mulai', this.tanggalMulai);
                }
                
                if (this.tanggalSelesai) {
                    params.append('tanggal_selesai', this.tanggalSelesai);
                }
                
                const response = await fetch(`/admin/api/log-aktivitas?${params}`);
                const data = await response.json();
                
                if (data.success) {
                    this.logs = data.data;
                    this.pagination = data.pagination;
                }
            } catch (error) {
                console.error('Error loading logs:', error);
                this.showToast('Error loading data', 'error');
            } finally {
                this.loading = false;
            }
        },
        
        // Load modules for dropdown
        async loadModules() {
            try {
                const response = await fetch('/admin/api/log-aktivitas/modules');
                const data = await response.json();
                
                if (data.success) {
                    this.modules = data.data;
                }
            } catch (error) {
                console.error('Error loading modules:', error);
            }
        },
        
        // Load users for dropdown
        async loadUsers() {
            try {
                const response = await fetch('/admin/api/log-aktivitas/users');
                const data = await response.json();
                
                if (data.success) {
                    this.users = data.data;
                }
            } catch (error) {
                console.error('Error loading users:', error);
            }
        },
        
        // Show log details
        async showLog(id) {
            try {
                const response = await fetch(`/admin/api/log-aktivitas/${id}`);
                const data = await response.json();
                
                if (data.success) {
                    const log = data.data;
                    const html = `
                        <div class="row">
                            <div class="col-md-6">
                                <strong>User:</strong> ${log.user ? log.user.nama : '-'}<br>
                                <strong>Email:</strong> ${log.user ? log.user.email : '-'}
                            </div>
                            <div class="col-md-6">
                                <strong>Modul:</strong> ${log.modul}<br>
                                <strong>Aksi:</strong> ${log.aksi}
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <strong>IP Address:</strong> ${log.ip}
                            </div>
                            <div class="col-md-6">
                                <strong>Tanggal:</strong> ${new Date(log.created_at).toLocaleString('id-ID')}
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <strong>Detail:</strong><br>
                                <div class="border p-3 bg-light">
                                    ${log.detail || '-'}
                                </div>
                            </div>
                        </div>
                    `;
                    
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Detail Log Aktivitas',
                            html: html,
                            width: '800px',
                            showConfirmButton: true,
                            confirmButtonText: 'Tutup',
                        });
                    } else {
                        alert(html.replace(/<[^>]*>/g, ''));
                    }
                } else {
                    this.showToast(data.message || 'Error loading data', 'error');
                }
            } catch (error) {
                console.error('Error loading log:', error);
                this.showToast('Error loading data', 'error');
            }
        },
        
        // Delete log
        async deleteLog(id) {
            if (!confirm('Yakin ingin menghapus log ini?')) {
                return;
            }
            
            try {
                const response = await fetch(`/admin/api/log-aktivitas/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken(),
                    },
                });
                
                const data = await response.json();
                
                if (data.success) {
                    this.showToast(data.message, 'success');
                    this.loadLogs(this.pagination.current_page);
                } else {
                    this.showToast(data.message || 'Error deleting data', 'error');
                }
            } catch (error) {
                console.error('Error deleting log:', error);
                this.showToast('Error deleting data', 'error');
            }
        },
        
        // Clear old logs
        async clearOldLogs() {
            if (!confirm(`Yakin ingin menghapus log aktivitas yang lebih lama dari ${this.clearForm.days} hari?`)) {
                return;
            }
            
            try {
                const response = await fetch('/admin/api/log-aktivitas/clear', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken(),
                    },
                    body: JSON.stringify({
                        days: this.clearForm.days
                    }),
                });
                
                const data = await response.json();
                
                if (data.success) {
                    this.showToast(data.message, 'success');
                    this.showClearModal = false;
                    this.loadLogs(1);
                } else {
                    this.showToast(data.message || 'Error clearing logs', 'error');
                }
            } catch (error) {
                console.error('Error clearing logs:', error);
                this.showToast('Error clearing logs', 'error');
            }
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
                this.loadLogs(this.pagination.current_page);
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
            this.loadLogs(1);
        },
        
        // Handle modul filter
        handleModulFilter() {
            this.pagination.current_page = 1;
            this.loadLogs(1);
        },
        
        // Handle user filter
        handleUserFilter() {
            this.pagination.current_page = 1;
            this.loadLogs(1);
        },
        
        // Handle date filter
        handleDateFilter() {
            this.pagination.current_page = 1;
            this.loadLogs(1);
        },
        
        // Handle per page change
        handlePerPageChange() {
            this.pagination.current_page = 1;
            this.loadLogs(1);
        },
        
        // Handle pagination
        goToPage(page) {
            if (page >= 1 && page <= this.pagination.last_page) {
                this.loadLogs(page);
            }
        },
        
        // Format date for display
        formatDate(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            return date.toLocaleDateString('id-ID');
        },
        
        // Format datetime for display
        formatDateTime(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            return date.toLocaleString('id-ID');
        },
    }));
});
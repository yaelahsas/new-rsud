document.addEventListener('alpine:init', () => {
    // Helper function to safely get CSRF token
    function getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    Alpine.data('jadwalPoliManager', () => ({
        jadwals: [],
        dokters: [],
        polis: [],
        hariOptions: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
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
            dokter_id: '',
            poli_id: '',
            hari: '',
            jam_mulai: '',
            jam_selesai: '',
            is_cuti: false,
            tanggal_cuti: '',
            keterangan: '',
        },
        
        // Selected days for checkbox
        selectedDays: [],
        
        // Form validation errors
        errors: {},
        
        // Modal state
        showModal: false,
        
        // Real-time polling interval
        pollingInterval: null,
        
        init() {
            this.loadJadwals();
            this.loadDokters();
            this.loadPolis();
            this.startPolling();
        },
        
        destroy() {
            this.stopPolling();
        },
        
        // Load jadwals with pagination and search
        async loadJadwals(page = 1) {
            this.loading = true;
            try {
                const params = new URLSearchParams({
                    page: page,
                    perPage: this.perPage,
                    search: this.search,
                });
                
                const response = await fetch(`/admin/api/jadwal-poli?${params}`);
                const data = await response.json();
                
                if (data.success) {
                    this.jadwals = data.data;
                    this.pagination = data.pagination;
                }
            } catch (error) {
                console.error('Error loading jadwals:', error);
                this.showToast('Error loading data', 'error');
            } finally {
                this.loading = false;
            }
        },
        
        // Load dokters for dropdown
        async loadDokters() {
            try {
                const response = await fetch('/admin/api/jadwal-poli/dokters');
                const data = await response.json();
                
                if (data.success) {
                    this.dokters = data.data;
                }
            } catch (error) {
                console.error('Error loading dokters:', error);
            }
        },
        
        // Load polis for dropdown
        async loadPolis() {
            try {
                const response = await fetch('/admin/api/jadwal-poli/polis');
                const data = await response.json();
                
                if (data.success) {
                    this.polis = data.data;
                }
            } catch (error) {
                console.error('Error loading polis:', error);
            }
        },
        
        // Save jadwal (create or update)
        async saveJadwal() {
            // If multiple days selected, use the multiple save function
            if (this.selectedDays.length > 1) {
                await this.saveMultipleJadwals();
                return;
            }
            
            this.loading = true;
            this.errors = {};
            
            try {
                // Set the hari from selectedDays if available
                if (this.selectedDays.length === 1) {
                    this.form.hari = this.selectedDays[0];
                }
                
                const url = this.form.id
                    ? `/admin/api/jadwal-poli/${this.form.id}`
                    : '/admin/api/jadwal-poli';
                
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
                    this.loadJadwals(this.pagination.current_page);
                } else {
                    // Handle validation errors
                    if (data.errors) {
                        this.errors = data.errors;
                    }
                    this.showToast(data.message || 'Error saving data', 'error');
                }
            } catch (error) {
                console.error('Error saving jadwal:', error);
                this.showToast('Error saving data', 'error');
            } finally {
                this.loading = false;
            }
        },
        
        // Edit jadwal
        async editJadwal(id) {
            try {
                const response = await fetch(`/admin/api/jadwal-poli/${id}`);
                const data = await response.json();
                
                if (data.success) {
                    this.form = {
                        id: data.data.id,
                        dokter_id: data.data.dokter_id,
                        poli_id: data.data.poli_id,
                        hari: data.data.hari,
                        jam_mulai: data.data.jam_mulai,
                        jam_selesai: data.data.jam_selesai,
                        is_cuti: data.data.is_cuti,
                        tanggal_cuti: data.data.tanggal_cuti,
                        keterangan: data.data.keterangan,
                    };
                    // Set selectedDays for editing
                    this.selectedDays = [data.data.hari];
                    this.showModal = true;
                } else {
                    this.showToast(data.message || 'Error loading data', 'error');
                }
            } catch (error) {
                console.error('Error loading jadwal:', error);
                this.showToast('Error loading data', 'error');
            }
        },
        
        // Delete jadwal
        async deleteJadwal(id) {
            try {
                const response = await fetch(`/admin/api/jadwal-poli/${id}`);
                const data = await response.json();
                
                if (data.success && data.data.related_records > 0) {
                    this.showToast('Jadwal tidak dapat dihapus karena memiliki data terkait', 'error');
                    return;
                }
                
                if (!confirm('Yakin ingin menghapus jadwal ini?')) {
                    return;
                }
                
                const deleteResponse = await fetch(`/admin/api/jadwal-poli/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken(),
                    },
                });
                
                const deleteData = await deleteResponse.json();
                
                if (deleteData.success) {
                    this.showToast(deleteData.message, 'success');
                    this.loadJadwals(this.pagination.current_page);
                } else {
                    this.showToast(deleteData.message || 'Error deleting data', 'error');
                }
            } catch (error) {
                console.error('Error deleting jadwal:', error);
                this.showToast('Error deleting data', 'error');
            }
        },
        
        // Reset form
        resetForm() {
            this.form = {
                id: null,
                dokter_id: '',
                poli_id: '',
                hari: '',
                jam_mulai: '',
                jam_selesai: '',
                is_cuti: false,
                tanggal_cuti: '',
                keterangan: '',
            };
            this.selectedDays = [];
            this.errors = {};
        },
        
        // Format time to Indonesian display format
        formatTimeDisplay(time) {
            if (!time) return '';
            
            const [hours, minutes] = time.split(':');
            const hour = parseInt(hours);
            const minute = minutes;
            
            let period = 'Pagi';
            let displayHour = hour;
            
            if (hour >= 4 && hour < 10) {
                period = 'Pagi';
                displayHour = hour;
            } else if (hour >= 10 && hour < 15) {
                period = 'Siang';
                displayHour = hour;
            } else if (hour >= 15 && hour < 18) {
                period = 'Sore';
                displayHour = hour;
            } else if (hour >= 18 && hour < 24) {
                period = 'Malam';
                displayHour = hour;
            } else {
                period = 'Dini Hari';
                displayHour = hour;
            }
            
            return `${displayHour}.${minute} ${period}`;
        },
        
        // Format time input (validation)
        formatTimeIndonesia(field) {
            // This function can be used for additional validation if needed
            // For now, the HTML5 time input handles the format
            console.log(`Time formatted for ${field}:`, this.form[field]);
        },
        // Select days pattern for quick selection
        selectDaysPattern(pattern) {
            switch(pattern) {
                case 'senin-kamis':
                    this.selectedDays = ['Senin', 'Selasa', 'Rabu', 'Kamis'];
                    break;
                case 'jumat':
                    this.selectedDays = ['Jumat'];
                    break;
                case 'sabtu':
                    this.selectedDays = ['Sabtu'];
                    break;
            }
        },
        
        // Save multiple schedules for selected days
        async saveMultipleJadwals() {
            if (this.selectedDays.length === 0) {
                this.showToast('Pilih minimal satu hari untuk praktik', 'warning');
                return;
            }
            
            this.loading = true;
            this.errors = {};
            
            try {
                const formData = {
                    dokter_id: this.form.dokter_id,
                    poli_id: this.form.poli_id,
                    jam_mulai: this.form.jam_mulai,
                    jam_selesai: this.form.jam_selesai,
                    is_cuti: this.form.is_cuti,
                    tanggal_cuti: this.form.tanggal_cuti,
                    keterangan: this.form.keterangan,
                    multiple_days: this.selectedDays
                };
                
                const response = await fetch('/admin/api/jadwal-poli', {
                    method: 'POST',
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
                    this.loadJadwals(this.pagination.current_page);
                } else {
                    // Handle validation errors
                    if (data.errors) {
                        this.errors = data.errors;
                    }
                    this.showToast(data.message || 'Error saving data', 'error');
                }
            } catch (error) {
                console.error('Error saving multiple jadwals:', error);
                this.showToast('Error saving data', 'error');
            } finally {
                this.loading = false;
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
                this.loadJadwals(this.pagination.current_page);
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
            this.loadJadwals(1);
        },
        
        // Handle per page change
        handlePerPageChange() {
            this.pagination.current_page = 1;
            this.loadJadwals(1);
        },
        
        // Handle pagination
        goToPage(page) {
            if (page >= 1 && page <= this.pagination.last_page) {
                this.loadJadwals(page);
            }
        },
    }));
});
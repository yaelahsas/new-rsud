document.addEventListener('alpine:init', () => {
    // Helper function to safely get CSRF token
    function getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    Alpine.data('reviewManager', () => ({
        reviews: [],
        inovasis: [],
        loading: false,
        search: '',
        selectedInovasi: '',
        selectedRating: '',
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
            rating: 5,
            pesan: '',
            inovasi_id: '',
        },
        
        // Form validation errors
        errors: {},
        
        // Modal state
        showModal: false,
        
        // Real-time polling interval
        pollingInterval: null,
        
        init() {
            this.loadReviews();
            this.loadInovasis();
            this.startPolling();
        },
        
        destroy() {
            this.stopPolling();
        },
        
        // Load reviews with pagination and search
        async loadReviews(page = 1) {
            this.loading = true;
            try {
                const params = new URLSearchParams({
                    page: page,
                    perPage: this.perPage,
                    search: this.search,
                });
                
                if (this.selectedInovasi) {
                    params.append('inovasi_id', this.selectedInovasi);
                }
                
                if (this.selectedRating) {
                    params.append('rating', this.selectedRating);
                }
                
                const response = await fetch(`/admin/api/review?${params}`);
                const data = await response.json();
                
                if (data.success) {
                    this.reviews = data.data;
                    this.pagination = data.pagination;
                }
            } catch (error) {
                console.error('Error loading reviews:', error);
                this.showToast('Error loading data', 'error');
            } finally {
                this.loading = false;
            }
        },
        
        // Load inovasis for dropdown
        async loadInovasis() {
            try {
                const response = await fetch('/admin/api/review/inovasis');
                const data = await response.json();
                
                if (data.success) {
                    this.inovasis = data.data;
                }
            } catch (error) {
                console.error('Error loading inovasis:', error);
            }
        },
        
        // Save review (create or update)
        async saveReview() {
            this.loading = true;
            this.errors = {};
            
            try {
                const url = this.form.id
                    ? `/admin/api/review/${this.form.id}`
                    : '/admin/api/review';
                 
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
                    this.loadReviews(this.pagination.current_page);
                } else {
                    // Handle validation errors
                    if (data.errors) {
                        this.errors = data.errors;
                    }
                    this.showToast(data.message || 'Error saving data', 'error');
                }
            } catch (error) {
                console.error('Error saving review:', error);
                this.showToast('Error saving data', 'error');
            } finally {
                this.loading = false;
            }
        },
        
        // Edit review
        async editReview(id) {
            try {
                const response = await fetch(`/admin/api/review/${id}`);
                const data = await response.json();
                
                if (data.success) {
                    this.form = {
                        id: data.data.id,
                        nama: data.data.nama,
                        rating: data.data.rating,
                        pesan: data.data.pesan,
                        inovasi_id: data.data.inovasi_id,
                    };
                    this.showModal = true;
                } else {
                    this.showToast(data.message || 'Error loading data', 'error');
                }
            } catch (error) {
                console.error('Error loading review:', error);
                this.showToast('Error loading data', 'error');
            }
        },
        
        // Delete review
        async deleteReview(id) {
            if (!confirm('Yakin ingin menghapus review ini?')) {
                return;
            }
            
            try {
                const response = await fetch(`/admin/api/review/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken(),
                    },
                });
                
                const data = await response.json();
                
                if (data.success) {
                    this.showToast(data.message, 'success');
                    this.loadReviews(this.pagination.current_page);
                } else {
                    this.showToast(data.message || 'Error deleting data', 'error');
                }
            } catch (error) {
                console.error('Error deleting review:', error);
                this.showToast('Error deleting data', 'error');
            }
        },
        
        // Reset form
        resetForm() {
            this.form = {
                id: null,
                nama: '',
                rating: 5,
                pesan: '',
                inovasi_id: '',
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
                this.loadReviews(this.pagination.current_page);
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
            this.loadReviews(1);
        },
        
        // Handle inovasi filter
        handleInovasiFilter() {
            this.pagination.current_page = 1;
            this.loadReviews(1);
        },
        
        // Handle rating filter
        handleRatingFilter() {
            this.pagination.current_page = 1;
            this.loadReviews(1);
        },
        
        // Handle per page change
        handlePerPageChange() {
            this.pagination.current_page = 1;
            this.loadReviews(1);
        },
        
        // Handle pagination
        goToPage(page) {
            if (page >= 1 && page <= this.pagination.last_page) {
                this.loadReviews(page);
            }
        },
        
        // Display rating stars
        displayRating(rating) {
            let stars = '';
            for (let i = 1; i <= 5; i++) {
                if (i <= rating) {
                    stars += '<i class="fas fa-star text-warning"></i> ';
                } else {
                    stars += '<i class="far fa-star text-warning"></i> ';
                }
            }
            return stars;
        },
    }));
});
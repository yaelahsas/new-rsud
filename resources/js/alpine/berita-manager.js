document.addEventListener('alpine:init', () => {
    // Helper function to safely get CSRF token
    function getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }

    Alpine.data('beritaManager', () => ({
        beritas: [],
        kategoris: [],
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
            slug: '',
            kategori_id: '',
            isi: '',
            thumbnail: null,
            existing_thumbnail: null, // Store existing thumbnail path
            publish: false,
            tanggal_publish: '',
        },
        
        // Form validation errors
        errors: {},
        
        // Modal state
        showModal: false,
        
        // Real-time polling interval
        pollingInterval: null,
        
        init() {
            console.log('Initializing berita manager...');
            this.loadBeritas();
            this.loadKategoris();
            this.startPolling();
            
            // Initialize Summernote when modal is shown
            this.$watch('showModal', (value) => {
                if (value) {
                    this.$nextTick(() => {
                        setTimeout(() => {
                            this.initSummernote();
                        }, 200);
                    });
                }
            });
            
            // Watch for changes in judul to auto-update slug
            this.$watch('form.judul', (value) => {
                if (value) {
                    this.form.slug = value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
                }
            });
        },
        
        destroy() {
            this.stopPolling();
            
            // Destroy Summernote instance if it exists
            if (typeof $ !== 'undefined' && $.fn.summernote && $('#summernote').data('summernote')) {
                $('#summernote').summernote('destroy');
            }
        },
        
        // Load beritas with pagination and search
        async loadBeritas(page = 1) {
            this.loading = true;
            try {
                const params = new URLSearchParams({
                    page: page,
                    perPage: this.perPage,
                    search: this.search,
                });
                
                console.log('Loading beritas with params:', params.toString());
                
                const response = await fetch(`/admin/api/berita?${params}`);
                const data = await response.json();
                
                console.log('Beritas response:', data);
                
                if (data.success) {
                    this.beritas = data.data;
                    this.pagination = data.pagination;
                } else {
                    console.error('Failed to load beritas:', data.message);
                    this.showToast(data.message || 'Error loading data', 'error');
                }
            } catch (error) {
                console.error('Error loading beritas:', error);
                this.showToast('Error loading data', 'error');
            } finally {
                this.loading = false;
            }
        },
        
        // Load kategoris for dropdown
        async loadKategoris() {
            try {
                console.log('Loading kategoris...');
                const response = await fetch('/admin/api/berita/kategoris');
                const data = await response.json();
                
                console.log('Kategoris response:', data);
                
                if (data.success) {
                    this.kategoris = data.data;
                    console.log('Kategoris loaded:', this.kategoris); // Debug log
                } else {
                    console.error('Failed to load kategoris:', data.message);
                    this.showToast(data.message || 'Error loading kategoris', 'error');
                }
            } catch (error) {
                console.error('Error loading kategoris:', error);
                this.showToast('Error loading kategoris', 'error');
            }
        },
        
        // Save berita (create or update)
        async saveBerita() {
            this.loading = true;
            this.errors = {};
            
            try {
                // Get content from Summernote if it exists
                if (typeof $ !== 'undefined' && $.fn.summernote && $('#summernote').data('summernote')) {
                    this.form.isi = $('#summernote').summernote('code');
                }
                
                const formData = new FormData();
                
                // Update slug when judul changes
                this.form.slug = this.form.judul.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
                
                // Always append all fields to ensure they're sent in the request
                formData.append('judul', this.form.judul || '');
                formData.append('slug', this.form.slug || '');
                formData.append('kategori_id', this.form.kategori_id || '');
                formData.append('isi', this.form.isi || '');
                formData.append('publish', this.form.publish ? '1' : '0');
                formData.append('tanggal_publish', this.form.tanggal_publish || '');
                
                // Only append thumbnail if a new file is selected
                if (this.form.thumbnail) {
                    formData.append('thumbnail', this.form.thumbnail);
                }
                
                console.log('FormData contents:');
                for (let [key, value] of formData.entries()) {
                    console.log(key, value);
                }
                
                const url = this.form.id
                    ? `/admin/api/berita/${this.form.id}`
                    : '/admin/api/berita';
                
                // For FormData, we need to use POST and add _method field for PUT
                if (this.form.id) {
                    formData.append('_method', 'PUT');
                }
                
                console.log('Saving berita:', {
                    url,
                    method: this.form.id ? 'PUT (simulated with POST + _method)' : 'POST',
                    formData: Object.fromEntries(formData.entries())
                });
                
                const response = await fetch(url, {
                    method: 'POST', // Always use POST with FormData
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'Accept': 'application/json',
                    },
                    body: formData,
                });
                
                const data = await response.json();
                
                console.log('Response:', data);
                
                if (data.success) {
                    this.showToast(data.message, 'success');
                    this.resetForm();
                    this.showModal = false;
                    this.loadBeritas(this.pagination.current_page);
                } else {
                    // Handle validation errors
                    if (data.errors) {
                        this.errors = data.errors;
                    }
                    this.showToast(data.message || 'Error saving data', 'error');
                }
            } catch (error) {
                console.error('Error saving berita:', error);
                this.showToast('Error saving data', 'error');
            } finally {
                this.loading = false;
            }
        },
        
        // Edit berita
        async editBerita(id) {
            try {
                const response = await fetch(`/admin/api/berita/${id}`);
                const data = await response.json();
                
                if (data.success) {
                    this.form = {
                        id: data.data.id,
                        judul: data.data.judul,
                        slug: data.data.slug,
                        kategori_id: data.data.kategori_id,
                        isi: data.data.isi,
                        thumbnail: null,
                        existing_thumbnail: data.data.thumbnail, // Store existing thumbnail
                        publish: data.data.publish,
                        tanggal_publish: data.data.tanggal_publish || '',
                    };
                    this.showModal = true;
                    
                    // Initialize Summernote after modal is shown and content is loaded
                    this.$nextTick(() => {
                        setTimeout(() => {
                            this.initSummernote();
                        }, 300);
                    });
                } else {
                    this.showToast(data.message || 'Error loading data', 'error');
                }
            } catch (error) {
                console.error('Error loading berita:', error);
                this.showToast('Error loading data', 'error');
            }
        },
        
        // Delete berita
        async deleteBerita(id) {
            if (!confirm('Yakin ingin menghapus berita ini?')) {
                return;
            }
            
            try {
                const response = await fetch(`/admin/api/berita/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken(),
                    },
                });
                
                const data = await response.json();
                
                if (data.success) {
                    this.showToast(data.message, 'success');
                    this.loadBeritas(this.pagination.current_page);
                } else {
                    this.showToast(data.message || 'Error deleting data', 'error');
                }
            } catch (error) {
                console.error('Error deleting berita:', error);
                this.showToast('Error deleting data', 'error');
            }
        },
        
        // Reset form
        resetForm() {
            this.form = {
                id: null,
                judul: '',
                slug: '',
                kategori_id: '',
                isi: '',
                thumbnail: null,
                existing_thumbnail: null, // Reset existing thumbnail
                publish: false,
                tanggal_publish: '',
            };
            this.errors = {};
            
            // Clear Summernote if exists
            if (typeof $ !== 'undefined' && $.fn.summernote && $('#summernote').data('summernote')) {
                $('#summernote').summernote('code', '');
            }
        },
        
        // Initialize Summernote
        initSummernote() {
            // Destroy existing instance if it exists
            if (typeof $ !== 'undefined' && $.fn.summernote && $('#summernote').data('summernote')) {
                $('#summernote').summernote('destroy');
            }
            
            if (typeof $ !== 'undefined' && $.fn.summernote) {
                $('#summernote').summernote({
                    height: 300,
                    placeholder: 'Tulis artikel di sini...',
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'italic', 'underline', 'clear']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ],
                    callbacks: {
                        onChange: (contents) => {
                            this.form.isi = contents;
                        },
                        onInit: () => {
                            // Set content if editing after initialization
                            if (this.form.isi) {
                                setTimeout(() => {
                                    $('#summernote').summernote('code', this.form.isi);
                                }, 100);
                            }
                        }
                    }
                });
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
                this.loadBeritas(this.pagination.current_page);
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
            this.loadBeritas(1);
        },
        
        // Handle per page change
        handlePerPageChange() {
            this.pagination.current_page = 1;
            this.loadBeritas(1);
        },
        
        // Handle pagination
        goToPage(page) {
            if (page >= 1 && page <= this.pagination.last_page) {
                this.loadBeritas(page);
            }
        },
    }));
});
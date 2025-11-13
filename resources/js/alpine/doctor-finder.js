document.addEventListener('alpine:init', () => {
    Alpine.data('doctorFinder', () => ({
        doctors: [],
        filteredDoctors: [],
        loading: false,
        
        // Filters
        filters: {
            search: '',
            specialization: '',
            schedule: '',
            available: false
        },
        
        // Pagination
        pagination: {
            currentPage: 1,
            perPage: 12,
            totalPages: 1,
            total: 0
        },
        
        // Specializations (will be loaded from API)
        specializations: ['Semua Spesialisasi'],
        
        // Schedule options
        scheduleOptions: [
            { value: '', label: 'Semua Jadwal' },
            { value: 'morning', label: 'Pagi (07:00 - 12:00)' },
            { value: 'afternoon', label: 'Siang (12:00 - 17:00)' },
            { value: 'evening', label: 'Sore (17:00 - 21:00)' }
        ],
        
        // SEO data
        seoData: {
            title: 'Temukan Dokter Kami - RSUD Genteng',
            description: 'Cari dokter berdasarkan nama, spesialisasi, atau jadwal praktik di RSUD Genteng',
            keywords: 'dokter, spesialis, jadwal praktik, RSUD Genteng',
            ogImage: '/img/og-doctor-finder.jpg'
        },
        
        init() {
            // Check for search query in URL
            const urlParams = new URLSearchParams(window.location.search);
            const searchQuery = urlParams.get('search');
            const specializationQuery = urlParams.get('specialization');
            const scheduleQuery = urlParams.get('schedule');
            const availableQuery = urlParams.get('available');
            
            if (searchQuery) {
                this.filters.search = searchQuery;
            }
            if (specializationQuery) {
                this.filters.specialization = specializationQuery;
            }
            if (scheduleQuery) {
                this.filters.schedule = scheduleQuery;
            }
            if (availableQuery === 'true') {
                this.filters.available = true;
            }
            
            // Initialize page
            this.initializePage();
            
            // Watch for filter changes
            this.$watch('filters', () => {
                // Reset to first page when filters change
                this.pagination.currentPage = 1;
                this.applyFilters();
                // Update URL with search query
                this.updateURL();
            }, { deep: true });
            
            // Initialize search debounce
            this.initSearchDebounce();
        },
        
        // Initialize page
        async initializePage() {
            await Promise.all([
                this.loadSpecializations(),
                this.loadDoctors()
            ]);
            
            this.updatePageMeta();
        },
        
        // Load specializations from API
        async loadSpecializations() {
            try {
                const response = await fetch('/api/doctor-specializations');
                const data = await response.json();
                
                if (data.success) {
                    this.specializations = data.specializations;
                }
            } catch (error) {
                console.error('Error loading specializations:', error);
            }
        },
        
        // Load doctors from API
        async loadDoctors() {
            this.loading = true;
            
            try {
                // Build query parameters
                const params = new URLSearchParams();
                // Only add search parameter if it's not empty
                if (this.filters.search && this.filters.search.trim()) {
                    params.append('search', this.filters.search);
                }
                if (this.filters.specialization && this.filters.specialization !== 'Semua Spesialisasi') {
                    params.append('specialization', this.filters.specialization);
                }
                
                const response = await fetch(`/api/doctors?${params.toString()}`);
                const data = await response.json();
                
                // Debug logging
                console.log('API Response:', data);
                
                if (data.success && Array.isArray(data.doctors)) {
                    this.doctors = data.doctors;
                    // Apply filters after loading new data
                    this.applyFilters();
                } else {
                    // Fallback to mock data if response is not as expected
                    console.log('Using mock data - API response not as expected');
                    this.loadMockData();
                }
            } catch (error) {
                console.error('Error loading doctors:', error);
                // Fallback to mock data
                this.loadMockData();
            } finally {
                this.loading = false;
            }
        },
        
        // Load mock data for development
        loadMockData() {
            this.doctors = [
                {
                    id: 1,
                    slug: 'ahmad-santoso',
                    name: 'dr. Ahmad Santoso, Sp.PD',
                    specialization: 'Spesialis Penyakit Dalam',
                    image: 'https://rsudgenteng.banyuwangikab.go.id/gambar/dokter/default.jpg',
                    schedule: 'Senin - Jumat 08:00 - 14:00',
                    scheduleTime: 'morning',
                    available: true,
                    profile_url: `/medis/ahmad-santoso`
                },
                {
                    id: 2,
                    slug: 'maria-citra',
                    name: 'dr. Maria Citra, Sp.A',
                    specialization: 'Spesialis Anak',
                    image: 'https://rsudgenteng.banyuwangikab.go.id/gambar/dokter/default2.jpg',
                    schedule: 'Selasa - Sabtu 09:00 - 13:00',
                    scheduleTime: 'morning',
                    available: true,
                    profile_url: `/medis/maria-citra`
                },
                {
                    id: 3,
                    slug: 'budi-santoso',
                    name: 'dr. Budi Santoso, Sp.JP',
                    specialization: 'Spesialis Jantung',
                    image: 'https://rsudgenteng.banyuwangikab.go.id/gambar/dokter/default3.jpg',
                    schedule: 'Senin - Kamis 14:00 - 20:00',
                    scheduleTime: 'afternoon',
                    available: false,
                    profile_url: `/medis/budi-santoso`
                },
                {
                    id: 4,
                    slug: 'siti-nurhaliza',
                    name: 'dr. Siti Nurhaliza, Sp.KK',
                    specialization: 'Spesialis Kulit',
                    image: 'https://rsudgenteng.banyuwangikab.go.id/gambar/dokter/default4.jpg',
                    schedule: 'Rabu - Sabtu 10:00 - 16:00',
                    scheduleTime: 'afternoon',
                    available: true,
                    profile_url: `/medis/siti-nurhaliza`
                }
            ];
            
            this.applyFilters();
        },
        
        // Apply filters to doctors
        applyFilters() {
            // Ensure doctors is an array before filtering
            if (!Array.isArray(this.doctors)) {
                this.filteredDoctors = [];
                return;
            }
            
            let filtered = [...this.doctors];
            
            // Search filter - only apply if search query is not empty
            if (this.filters.search && this.filters.search.trim()) {
                const searchLower = this.filters.search.toLowerCase().trim();
                filtered = filtered.filter(doctor =>
                    doctor.name.toLowerCase().includes(searchLower) ||
                    doctor.specialization.toLowerCase().includes(searchLower) ||
                    (doctor.poli && doctor.poli.toLowerCase().includes(searchLower))
                );
            }
            
            // Specialization filter
            if (this.filters.specialization && this.filters.specialization !== 'Semua Spesialisasi') {
                filtered = filtered.filter(doctor =>
                    doctor.specialization === this.filters.specialization
                );
            }
            
            // Schedule filter
            if (this.filters.schedule) {
                filtered = filtered.filter(doctor =>
                    doctor.scheduleTime === this.filters.schedule
                );
            }
            
            // Available filter
            if (this.filters.available) {
                filtered = filtered.filter(doctor => doctor.available);
            }
            
            this.filteredDoctors = filtered;
            this.updatePagination();
        },
        
        // Update pagination
        updatePagination() {
            this.pagination.total = this.filteredDoctors.length;
            this.pagination.totalPages = Math.ceil(this.pagination.total / this.pagination.perPage);
            this.pagination.currentPage = 1;
        },
        
        // Get paginated doctors
        get paginatedDoctors() {
            const start = (this.pagination.currentPage - 1) * this.pagination.perPage;
            const end = start + this.pagination.perPage;
            return this.filteredDoctors.slice(start, end);
        },
        
        // Change page
        changePage(page) {
            if (page >= 1 && page <= this.pagination.totalPages) {
                this.pagination.currentPage = page;
                this.scrollToTop();
            }
        },
        
        // Scroll to top of results
        scrollToTop() {
            const element = document.getElementById('doctor-results');
            if (element) {
                element.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        },
        
        // Clear all filters
        clearFilters() {
            this.filters = {
                search: '',
                specialization: '',
                schedule: '',
                available: false
            };
            // Update URL first to reflect cleared filters
            this.updateURL();
            // Reset pagination to first page
            this.pagination.currentPage = 1;
            // Apply filters immediately to update the display
            this.applyFilters();
        },
        
        // Get specialization count
        getSpecializationCount(specialization) {
            if (specialization === 'Semua Spesialisasi') {
                return this.doctors.length;
            }
            return this.doctors.filter(doctor => doctor.specialization === specialization).length;
        },
        
        // Toggle favorite doctor
        toggleFavorite(doctorSlug) {
            const favorites = JSON.parse(localStorage.getItem('favoriteDoctors') || '[]');
            const index = favorites.indexOf(doctorSlug);
            
            if (index > -1) {
                favorites.splice(index, 1);
            } else {
                favorites.push(doctorSlug);
            }
            
            localStorage.setItem('favoriteDoctors', JSON.stringify(favorites));
        },
        
        // Check if doctor is favorite
        isFavorite(doctorSlug) {
            const favorites = JSON.parse(localStorage.getItem('favoriteDoctors') || '[]');
            return favorites.includes(doctorSlug);
        },
        
        // Book appointment
        bookAppointment(doctor) {
            // Store selected doctor for booking
            localStorage.setItem('selectedDoctor', JSON.stringify(doctor));
            
            // Navigate to booking page
            window.location.href = '/booking';
        },
        
        // Update URL with search parameters
        updateURL() {
            const url = new URL(window.location);
            const params = new URLSearchParams();
            
            if (this.filters.search) {
                params.set('search', this.filters.search);
            }
            if (this.filters.specialization && this.filters.specialization !== 'Semua Spesialisasi') {
                params.set('specialization', this.filters.specialization);
            }
            if (this.filters.schedule) {
                params.set('schedule', this.filters.schedule);
            }
            if (this.filters.available) {
                params.set('available', 'true');
            }
            
            // Update URL without page reload
            const newUrl = params.toString() ? `${url.pathname}?${params.toString()}` : url.pathname;
            window.history.replaceState({}, '', newUrl);
        },
        
        // Update page meta tags
        updatePageMeta() {
            // Update title
            document.title = this.seoData.title;
            
            // Update meta description
            const metaDescription = document.querySelector('meta[name="description"]');
            if (metaDescription) {
                metaDescription.setAttribute('content', this.seoData.description);
            }
            
            // Update meta keywords
            const metaKeywords = document.querySelector('meta[name="keywords"]');
            if (metaKeywords) {
                metaKeywords.setAttribute('content', this.seoData.keywords);
            }
            
            // Update Open Graph tags
            const ogTitle = document.querySelector('meta[property="og:title"]');
            if (ogTitle) {
                ogTitle.setAttribute('content', this.seoData.title);
            }
            
            const ogDescription = document.querySelector('meta[property="og:description"]');
            if (ogDescription) {
                ogDescription.setAttribute('content', this.seoData.description);
            }
            
            const ogImage = document.querySelector('meta[property="og:image"]');
            if (ogImage) {
                ogImage.setAttribute('content', this.seoData.ogImage);
            }
            
            // Update canonical URL
            const canonical = document.querySelector('link[rel="canonical"]');
            if (canonical) {
                canonical.setAttribute('href', window.location.href);
            } else {
                const link = document.createElement('link');
                link.rel = 'canonical';
                link.href = window.location.href;
                document.head.appendChild(link);
            }
        },
        
        // Initialize search debounce
        initSearchDebounce() {
            let timeout;
            let previousValue = this.filters.search || '';
            
            this.$watch('filters.search', (newValue) => {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    // Always reload doctors when search changes
                    this.loadDoctors();
                }, 300);
                
                previousValue = newValue;
            });
        }
    }));
});
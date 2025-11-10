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
        
        // Specializations
        specializations: [
            'Semua Spesialisasi',
            'Spesialis Penyakit Dalam',
            'Spesialis Anak',
            'Spesialis Kandungan',
            'Spesialis Bedah',
            'Spesialis Jantung',
            'Spesialis Saraf',
            'Spesialis Mata',
            'Spesialis THT',
            'Spesialis Kulit',
            'Spesialis Paru',
            'Spesialis Orthopedi',
            'Spesialis Urologi',
            'Spesialis Psikiatri'
        ],
        
        // Schedule options
        scheduleOptions: [
            { value: '', label: 'Semua Jadwal' },
            { value: 'morning', label: 'Pagi (07:00 - 12:00)' },
            { value: 'afternoon', label: 'Siang (12:00 - 17:00)' },
            { value: 'evening', label: 'Sore (17:00 - 21:00)' }
        ],
        
        init() {
            // Check for search query in URL
            const urlParams = new URLSearchParams(window.location.search);
            const searchQuery = urlParams.get('search');
            if (searchQuery) {
                this.filters.search = searchQuery;
            }
            
            this.loadDoctors();
            
            // Watch for filter changes
            this.$watch('filters', () => {
                this.applyFilters();
                // Update URL with search query
                this.updateURL();
            }, { deep: true });
        },
        
        // Load doctors from API
        async loadDoctors() {
            this.loading = true;
            
            try {
                // Use the correct API endpoint
                const response = await fetch('/admin/api/dokter');
                const data = await response.json();
                
                // Transform the data to match expected format
                this.doctors = (data.data || []).map(doctor => ({
                    id: doctor.id,
                    name: doctor.nama,
                    specialization: doctor.spesialis,
                    image: doctor.foto ? `/storage/${doctor.foto}` : 'https://rsudgenteng.banyuwangikab.go.id/gambar/dokter/default.jpg',
                    schedule: 'Senin - Jumat (08.00 - 14.00)', // Default schedule
                    scheduleTime: 'morning',
                    available: doctor.status === 'aktif',
                    experience: '5+ tahun', // Default experience
                    education: 'Universitas', // Default education
                    profile_url: `/medis/${doctor.id}`,
                    poli: doctor.poli
                }));
                
                this.applyFilters();
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
                    name: 'dr. Ahmad Santoso, Sp.PD',
                    specialization: 'Spesialis Penyakit Dalam',
                    image: 'https://rsudgenteng.banyuwangikab.go.id/gambar/dokter/default.jpg',
                    schedule: 'Senin - Jumat (08.00 - 14.00)',
                    scheduleTime: 'morning',
                    available: true,
                    experience: '15 tahun',
                    education: 'Universitas Airlangga',
                    profile_url: '/dokter/1'
                },
                {
                    id: 2,
                    name: 'dr. Maria Citra, Sp.A',
                    specialization: 'Spesialis Anak',
                    image: 'https://rsudgenteng.banyuwangikab.go.id/gambar/dokter/default2.jpg',
                    schedule: 'Selasa - Sabtu (09.00 - 13.00)',
                    scheduleTime: 'morning',
                    available: true,
                    experience: '10 tahun',
                    education: 'Universitas Indonesia',
                    profile_url: '/dokter/2'
                },
                {
                    id: 3,
                    name: 'dr. Budi Santoso, Sp.JP',
                    specialization: 'Spesialis Jantung',
                    image: 'https://rsudgenteng.banyuwangikab.go.id/gambar/dokter/default3.jpg',
                    schedule: 'Senin - Kamis (14.00 - 20.00)',
                    scheduleTime: 'afternoon',
                    available: false,
                    experience: '12 tahun',
                    education: 'Universitas Gadjah Mada',
                    profile_url: '/dokter/3'
                },
                {
                    id: 4,
                    name: 'dr. Siti Nurhaliza, Sp.KK',
                    specialization: 'Spesialis Kulit',
                    image: 'https://rsudgenteng.banyuwangikab.go.id/gambar/dokter/default4.jpg',
                    schedule: 'Rabu - Sabtu (10.00 - 16.00)',
                    scheduleTime: 'afternoon',
                    available: true,
                    experience: '8 tahun',
                    education: 'Universitas Brawijaya',
                    profile_url: '/dokter/4'
                }
            ];
            
            this.applyFilters();
        },
        
        // Apply filters to doctors
        applyFilters() {
            let filtered = [...this.doctors];
            
            // Search filter
            if (this.filters.search) {
                const searchLower = this.filters.search.toLowerCase();
                filtered = filtered.filter(doctor => 
                    doctor.name.toLowerCase().includes(searchLower) ||
                    doctor.specialization.toLowerCase().includes(searchLower)
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
        },
        
        // Get specialization count
        getSpecializationCount(specialization) {
            if (specialization === 'Semua Spesialisasi') {
                return this.doctors.length;
            }
            return this.doctors.filter(doctor => doctor.specialization === specialization).length;
        },
        
        // Toggle favorite doctor
        toggleFavorite(doctorId) {
            const favorites = JSON.parse(localStorage.getItem('favoriteDoctors') || '[]');
            const index = favorites.indexOf(doctorId);
            
            if (index > -1) {
                favorites.splice(index, 1);
            } else {
                favorites.push(doctorId);
            }
            
            localStorage.setItem('favoriteDoctors', JSON.stringify(favorites));
        },
        
        // Check if doctor is favorite
        isFavorite(doctorId) {
            const favorites = JSON.parse(localStorage.getItem('favoriteDoctors') || '[]');
            return favorites.includes(doctorId);
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
        }
    }));
});
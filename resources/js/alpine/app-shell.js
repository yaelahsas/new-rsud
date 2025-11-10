document.addEventListener('alpine:init', () => {
    Alpine.data('appShell', () => ({
        // Navigation state
        mobileMenuOpen: false,
        stickyBannerVisible: true,
        scrolled: false,
        
        // Global search state
        searchQuery: '',
        searchResults: [],
        searchLoading: false,
        searchOpen: false,
        
        // Current page tracking
        currentPage: window.location.pathname,
        
        // Initialize
        init() {
            // Check if sticky banner was previously closed by admin
           
            // Handle scroll events
            window.addEventListener('scroll', () => {
                this.scrolled = window.scrollY > 50;
            });
            
            // Handle escape key for search
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && this.searchOpen) {
                    this.closeSearch();
                }
            });
            
            // Handle click outside search
            document.addEventListener('click', (e) => {
                if (this.searchOpen && !e.target.closest('.search-container')) {
                    this.closeSearch();
                }
            });
        },
        
        // Mobile menu toggle
        toggleMobileMenu() {
            this.mobileMenuOpen = !this.mobileMenuOpen;
            document.body.style.overflow = this.mobileMenuOpen ? 'hidden' : '';
        },
        
        // Close mobile menu
        closeMobileMenu() {
            this.mobileMenuOpen = false;
            document.body.style.overflow = '';
        },
        
        // Sticky banner management (disabled - banner cannot be closed by users)
        // Admin function to show banner again (if needed in the future)
        showStickyBanner() {
            this.stickyBannerVisible = true;
            localStorage.removeItem('stickyBannerClosed');
        },
        
        // Global search functionality
        openSearch() {
            this.searchOpen = true;
            this.$nextTick(() => {
                this.$refs.searchInput?.focus();
            });
        },
        
        closeSearch() {
            this.searchOpen = false;
            this.searchQuery = '';
            this.searchResults = [];
        },
        
        async performSearch() {
            if (this.searchQuery.length < 2) {
                this.searchResults = [];
                return;
            }
            
            this.searchLoading = true;
            
            try {
                // Check if search is for doctors specifically
                const doctorKeywords = ['dokter', 'doctor', 'spesialis', 'poli', 'klinik'];
                const isDoctorSearch = doctorKeywords.some(keyword =>
                    this.searchQuery.toLowerCase().includes(keyword)
                ) || this.searchQuery.toLowerCase().includes('dr.');
                
                if (isDoctorSearch) {
                    // Redirect to doctor page with search query
                    window.location.href = `/medis?search=${encodeURIComponent(this.searchQuery)}`;
                    return;
                }
                
                // For other searches, try the API
                const response = await fetch(`/api/search?q=${encodeURIComponent(this.searchQuery)}`);
                const data = await response.json();
                
                this.searchResults = data.results || [];
            } catch (error) {
                console.error('Search error:', error);
                // If API fails, still try to redirect to doctor page for medical terms
                const medicalKeywords = ['dokter', 'doctor', 'spesialis', 'poli', 'klinik', 'penyakit', 'obat'];
                const isMedicalSearch = medicalKeywords.some(keyword =>
                    this.searchQuery.toLowerCase().includes(keyword)
                );
                
                if (isMedicalSearch) {
                    window.location.href = `/medis?search=${encodeURIComponent(this.searchQuery)}`;
                } else {
                    this.searchResults = [];
                }
            } finally {
                this.searchLoading = false;
            }
        },
        
        // Debounced search
        initSearchDebounce() {
            let timeout;
            this.$watch('searchQuery', () => {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    this.performSearch();
                }, 300);
            });
        },
        
        // Navigation helper
        navigateTo(path, event) {
            event.preventDefault();
            
            // Update current page
            this.currentPage = path;
            
            // Close mobile menu if open
            this.closeMobileMenu();
            
            // Push to history
            history.pushState({}, '', path);
            
            // Here you would typically load the page content via AJAX
            // For now, we'll just do a simple navigation
            window.location.href = path;
        },
        
        // Check if menu item is active
        isActive(path) {
            return this.currentPage === path || this.currentPage.startsWith(path + '/');
        }
    }));
    
    // Global store for shared state
    Alpine.store('app', {
        // User data (would come from backend)
        user: null,
        
        // App settings
        settings: {
            animations: true,
            darkMode: false
        },
        
        // Global loading state
        loading: false,
        
        // Notification system
        notifications: [],
        
        // Methods
        setUser(userData) {
            this.user = userData;
        },
        
        showNotification(message, type = 'info') {
            const notification = {
                id: Date.now(),
                message,
                type,
                show: true
            };
            
            this.notifications.push(notification);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                this.removeNotification(notification.id);
            }, 5000);
        },
        
        removeNotification(id) {
            const index = this.notifications.findIndex(n => n.id === id);
            if (index > -1) {
                this.notifications.splice(index, 1);
            }
        },
        
        setLoading(state) {
            this.loading = state;
        }
    });
});
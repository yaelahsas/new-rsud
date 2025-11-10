document.addEventListener('alpine:init', () => {
    Alpine.data('smartSearch', () => ({
        query: '',
        results: [],
        loading: false,
        open: false,
        selectedIndex: -1,
        
        // Search categories
        categories: [
            { id: 'doctors', name: 'Dokter', icon: 'user-md' },
            { id: 'services', name: 'Layanan', icon: 'heartbeat' },
            { id: 'articles', name: 'Artikel', icon: 'file-medical' },
            { id: 'general', name: 'Umum', icon: 'search' }
        ],
        selectedCategory: 'all',
        
        init() {
            // Handle keyboard navigation
            this.$watch('open', (value) => {
                if (value) {
                    document.addEventListener('keydown', this.handleKeydown.bind(this));
                } else {
                    document.removeEventListener('keydown', this.handleKeydown.bind(this));
                }
            });
        },
        
        // Open search
        openSearch() {
            this.open = true;
            this.$nextTick(() => {
                this.$refs.searchInput?.focus();
            });
        },
        
        // Close search
        closeSearch() {
            this.open = false;
            this.query = '';
            this.results = [];
            this.selectedIndex = -1;
        },
        
        // Handle keyboard navigation
        handleKeydown(e) {
            if (!this.open) return;
            
            switch (e.key) {
                case 'ArrowDown':
                    e.preventDefault();
                    this.selectedIndex = Math.min(this.selectedIndex + 1, this.results.length - 1);
                    break;
                case 'ArrowUp':
                    e.preventDefault();
                    this.selectedIndex = Math.max(this.selectedIndex - 1, -1);
                    break;
                case 'Enter':
                    e.preventDefault();
                    if (this.selectedIndex >= 0) {
                        this.selectResult(this.results[this.selectedIndex]);
                    }
                    break;
                case 'Escape':
                    this.closeSearch();
                    break;
            }
        },
        
        // Perform search
        async performSearch() {
            if (this.query.length < 2) {
                this.results = [];
                return;
            }
            
            this.loading = true;
            this.selectedIndex = -1;
            
            try {
                // Simulate API call - replace with actual endpoint
                const response = await fetch(`/api/search?q=${encodeURIComponent(this.query)}&category=${this.selectedCategory}`);
                const data = await response.json();
                
                this.results = this.formatResults(data.results || []);
            } catch (error) {
                console.error('Search error:', error);
                this.results = [];
            } finally {
                this.loading = false;
            }
        },
        
        // Format search results
        formatResults(rawResults) {
            return rawResults.map(result => ({
                ...result,
                highlightText: this.highlightMatch(result.title, this.query)
            }));
        },
        
        // Highlight matching text
        highlightMatch(text, query) {
            if (!text || !query) return text;
            
            const regex = new RegExp(`(${query})`, 'gi');
            return text.replace(regex, '<mark class="bg-yellow-200">$1</mark>');
        },
        
        // Select result
        selectResult(result) {
            window.location.href = result.url;
        },
        
        // Get category icon
        getCategoryIcon(categoryId) {
            const category = this.categories.find(cat => cat.id === categoryId);
            return category ? category.icon : 'search';
        },
        
        // Get category name
        getCategoryName(categoryId) {
            const category = this.categories.find(cat => cat.id === categoryId);
            return category ? category.name : 'Umum';
        },
        
        // Set category filter
        setCategory(categoryId) {
            this.selectedCategory = categoryId;
            this.performSearch();
        },
        
        // Clear search
        clearSearch() {
            this.query = '';
            this.results = [];
            this.selectedIndex = -1;
            this.$refs.searchInput?.focus();
        }
    }));
});
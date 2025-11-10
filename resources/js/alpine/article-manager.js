document.addEventListener('alpine:init', () => {
    Alpine.data('articleManager', () => ({
        articles: [],
        categories: [],
        loading: false,
        
        // DEBUG: Add missing properties that are referenced in the blade template
        filteredArticles: [], // This is referenced in blade but was missing
        popularTags: [], // This is referenced in blade but was missing
        
        // Filters
        filters: {
            search: '',
            category: '',
            date: ''
        },
        
        // Pagination
        pagination: {
            currentPage: 1,
            perPage: 9,
            totalPages: 1,
            total: 0
        },
        
        // View mode
        viewMode: 'grid', // grid or list
        
        init() {
            console.log('DEBUG: articleManager init() called');
            this.loadArticles();
            this.loadCategories();
            this.loadPopularTags(); // DEBUG: Load popular tags
            
            // Watch for filter changes
            this.$watch('filters', () => {
                this.applyFilters();
            }, { deep: true });
        },
        
        // Load articles from API
        async loadArticles() {
            this.loading = true;
            
            try {
                // Simulate API call - replace with actual endpoint
                const response = await fetch('/api/articles');
                const data = await response.json();
                
                this.articles = data.articles || [];
                this.applyFilters();
            } catch (error) {
                console.error('Error loading articles:', error);
                // Fallback to mock data
                this.loadMockData();
            } finally {
                this.loading = false;
            }
        },
        
        // Load categories from API
        async loadCategories() {
            try {
                const response = await fetch('/api/article-categories');
                const data = await response.json();
                
                this.categories = data.categories || [];
            } catch (error) {
                console.error('Error loading categories:', error);
                // Fallback to mock data
                this.categories = [
                    { id: 1, name: 'Kesehatan', slug: 'kesehatan' },
                    { id: 2, name: 'Umum', slug: 'umum' },
                    { id: 3, name: 'Artikel', slug: 'artikel' }
                ];
            }
        },
        
        // DEBUG: Load popular tags
        async loadPopularTags() {
            console.log('DEBUG: loadPopularTags() called');
            try {
                const response = await fetch('/api/article-tags');
                const data = await response.json();
                
                this.popularTags = data.tags || [];
            } catch (error) {
                console.error('Error loading popular tags:', error);
                // Fallback to mock data
                this.popularTags = [
                    { id: 1, name: 'Kesehatan', slug: 'kesehatan', count: 15 },
                    { id: 2, name: 'Poli', slug: 'poli', count: 8 },
                    { id: 3, name: 'Dokter', slug: 'dokter', count: 12 },
                    { id: 4, name: 'Vaksinasi', slug: 'vaksinasi', count: 6 },
                    { id: 5, name: 'Pandemi', slug: 'pandemi', count: 4 }
                ];
            }
        },
        
        // Load mock data for development
        loadMockData() {
            this.articles = [
                {
                    id: 1,
                    title: 'Poli Gigi Bedah Mulut dan Maksilofasial Sudah Bisa Melayani Pasien BPJS Kesehatan',
                    slug: 'poli-gigi-bedah-mulut-dan-maksilofasial',
                    excerpt: 'Dengan ini kami informasikan bahwa dokter spesialis bedah mulut di RSUD Genteng telah resmi dapat melayani pasien dengan...',
                    content: 'Dengan ini kami informasikan bahwa dokter spesialis bedah mulut di RSUD Genteng telah resmi dapat melayani pasien dengan...',
                    thumbnail: 'https://rsudgenteng.banyuwangikab.go.id/gambar/artikel/artikel-250925-035ed3f858.jpg',
                    category: { id: 1, name: 'Kesehatan', slug: 'kesehatan' },
                    author: { name: 'Admin RSUD' },
                    published_at: '2025-09-25',
                    read_time: '5 min',
                    views: 1250,
                    featured: true
                },
                {
                    id: 2,
                    title: 'Tindakan Odontektomi, Beri Solusi Masalah Gigi',
                    slug: 'tindakan-odontektomi-beri-solusi-masalah-gigi',
                    excerpt: 'Odontektomi atau pencabutan gigi adalah prosedur medis yang dilakukan untuk menghilangkan gigi yang bermasalah...',
                    content: 'Odontektomi atau pencabutan gigi adalah prosedur medis yang dilakukan untuk menghilangkan gigi yang bermasalah...',
                    thumbnail: 'https://rsudgenteng.banyuwangikab.go.id/gambar/artikel/artikel_-250814-9ecc4d246a.jpg',
                    category: { id: 1, name: 'Kesehatan', slug: 'kesehatan' },
                    author: { name: 'Dr. Ahmad Santoso' },
                    published_at: '2025-08-14',
                    read_time: '3 min',
                    views: 890,
                    featured: false
                },
                {
                    id: 3,
                    title: 'Pentingnya Vaksinasi Anak Sesuai Jadwal',
                    slug: 'pentingnya-vaksinasi-anak-sesuai-jadwal',
                    excerpt: 'Vaksinasi adalah salah satu upaya pencegahan penyakit yang paling efektif untuk anak-anak...',
                    content: 'Vaksinasi adalah salah satu upaya pencegahan penyakit yang paling efektif untuk anak-anak...',
                    thumbnail: 'https://rsudgenteng.banyuwangikab.go.id/gambar/artikel/artikel-250720-123456789ab.jpg',
                    category: { id: 1, name: 'Kesehatan', slug: 'kesehatan' },
                    author: { name: 'Dr. Maria Citra' },
                    published_at: '2025-07-20',
                    read_time: '7 min',
                    views: 2100,
                    featured: true
                },
                {
                    id: 4,
                    title: 'Inovasi Pelayanan RSUD Genteng: Gerakpol Kangmas',
                    slug: 'inovasi-pelayanan-rsud-genteng-gerakpol-kangmas',
                    excerpt: 'RSUD Genteng terus berinovasi untuk memberikan pelayanan terbaik bagi masyarakat...',
                    content: 'RSUD Genteng terus berinovasi untuk memberikan pelayanan terbaik bagi masyarakat...',
                    thumbnail: 'https://rsudgenteng.banyuwangikab.go.id/gambar/artikel/artikel-250615-abcdef123456.jpg',
                    category: { id: 2, name: 'Umum', slug: 'umum' },
                    author: { name: 'Admin RSUD' },
                    published_at: '2025-06-15',
                    read_time: '4 min',
                    views: 1567,
                    featured: false
                },
                {
                    id: 5,
                    title: 'Tips Menjaga Kesehatan Jantung di Masa Pandemi',
                    slug: 'tips-menjaga-kesehatan-jantung-di-masa-pandemi',
                    excerpt: 'Kesehatan jantung menjadi perhatian khusus di masa pandemi, berikut tips untuk menjaganya...',
                    content: 'Kesehatan jantung menjadi perhatian khusus di masa pandemi, berikut tips untuk menjaganya...',
                    thumbnail: 'https://rsudgenteng.banyuwangikab.go.id/gambar/artikel/artikel-250510-789def456789.jpg',
                    category: { id: 1, name: 'Kesehatan', slug: 'kesehatan' },
                    author: { name: 'Dr. Budi Santoso' },
                    published_at: '2025-05-10',
                    read_time: '6 min',
                    views: 3200,
                    featured: true
                }
            ];
            
            this.applyFilters();
        },
        
        // Apply filters to articles
        applyFilters() {
            console.log('DEBUG: applyFilters() called with filters:', this.filters);
            let filtered = [...this.articles];
            
            // Search filter
            if (this.filters.search) {
                const searchLower = this.filters.search.toLowerCase();
                filtered = filtered.filter(article =>
                    article.title.toLowerCase().includes(searchLower) ||
                    article.excerpt.toLowerCase().includes(searchLower) ||
                    article.content.toLowerCase().includes(searchLower)
                );
                console.log('DEBUG: After search filter, articles count:', filtered.length);
            }
            
            // Category filter
            if (this.filters.category) {
                filtered = filtered.filter(article =>
                    article.category.slug === this.filters.category
                );
                console.log('DEBUG: After category filter, articles count:', filtered.length);
            }
            
            // Date filter
            if (this.filters.date) {
                filtered = filtered.filter(article =>
                    article.published_at.startsWith(this.filters.date)
                );
                console.log('DEBUG: After date filter, articles count:', filtered.length);
            }
            
            this.filteredArticles = filtered;
            console.log('DEBUG: Final filteredArticles count:', this.filteredArticles.length);
            this.updatePagination();
        },
        
        // Update pagination
        updatePagination() {
            this.pagination.total = this.filteredArticles.length;
            this.pagination.totalPages = Math.ceil(this.pagination.total / this.pagination.perPage);
            this.pagination.currentPage = 1;
        },
        
        // Get paginated articles
        get paginatedArticles() {
            const start = (this.pagination.currentPage - 1) * this.pagination.perPage;
            const end = start + this.pagination.perPage;
            return this.filteredArticles.slice(start, end);
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
            const element = document.getElementById('article-results');
            if (element) {
                element.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        },
        
        // Clear all filters
        clearFilters() {
            this.filters = {
                search: '',
                category: '',
                date: ''
            };
        },
        
        // Toggle view mode
        toggleViewMode() {
            this.viewMode = this.viewMode === 'grid' ? 'list' : 'grid';
            localStorage.setItem('articleViewMode', this.viewMode);
        },
        
        // Format date
        formatDate(dateString) {
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return new Date(dateString).toLocaleDateString('id-ID', options);
        },
        
        // Get category count
        getCategoryCount(categorySlug) {
            if (!categorySlug) {
                return this.articles.length;
            }
            return this.articles.filter(article => article.category.slug === categorySlug).length;
        },
        
        // Save article for later
        saveArticle(articleId) {
            const savedArticles = JSON.parse(localStorage.getItem('savedArticles') || '[]');
            const index = savedArticles.indexOf(articleId);
            
            if (index > -1) {
                savedArticles.splice(index, 1);
            } else {
                savedArticles.push(articleId);
            }
            
            localStorage.setItem('savedArticles', JSON.stringify(savedArticles));
        },
        
        // Check if article is saved
        isSaved(articleId) {
            const savedArticles = JSON.parse(localStorage.getItem('savedArticles') || '[]');
            return savedArticles.includes(articleId);
        },
        
        // Share article
        shareArticle(article, platform) {
            console.log('DEBUG: shareArticle() called with article:', article, 'platform:', platform);
            
            // Handle case where article is null (called from sidebar share buttons)
            if (!article) {
                const url = window.location.href;
                const text = 'Artikel Kesehatan RSUD Genteng';
                
                let shareUrl = '';
                
                switch (platform) {
                    case 'facebook':
                        shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
                        break;
                    case 'twitter':
                        shareUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(url)}`;
                        break;
                    case 'whatsapp':
                        shareUrl = `https://wa.me/?text=${encodeURIComponent(text + ' ' + url)}`;
                        break;
                    case 'telegram':
                        shareUrl = `https://t.me/share/url?url=${encodeURIComponent(url)}&text=${encodeURIComponent(text)}`;
                        break;
                    case 'copy':
                        navigator.clipboard.writeText(url);
                        this.showNotification('Link berhasil disalin!', 'success');
                        return;
                }
                
                window.open(shareUrl, '_blank', 'width=600,height=400');
                return;
            }
            
            // Original code for when article is provided
            const url = `${window.location.origin}/artikel/${article.slug}`;
            const text = article.title;
            
            let shareUrl = '';
            
            switch (platform) {
                case 'facebook':
                    shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
                    break;
                case 'twitter':
                    shareUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(url)}`;
                    break;
                case 'whatsapp':
                    shareUrl = `https://wa.me/?text=${encodeURIComponent(text + ' ' + url)}`;
                    break;
                case 'telegram':
                    shareUrl = `https://t.me/share/url?url=${encodeURIComponent(url)}&text=${encodeURIComponent(text)}`;
                    break;
                case 'copy':
                    navigator.clipboard.writeText(url);
                    this.showNotification('Link berhasil disalin!', 'success');
                    return;
            }
            
            window.open(shareUrl, '_blank', 'width=600,height=400');
        },
        
        // DEBUG: Missing method referenced in blade template
        filterByTag(tagSlug) {
            console.log('DEBUG: filterByTag() called with tagSlug:', tagSlug);
            this.filters.search = '';
            this.filters.category = '';
            this.filters.date = '';
            // Apply tag filter (this would need to be implemented based on your data structure)
            // For now, we'll just apply filters to refresh the view
            this.applyFilters();
        },
        
        // Show notification
        showNotification(message, type = 'info') {
            console.log('DEBUG: showNotification() called with message:', message, 'type:', type);
            if (window.Alpine && Alpine.store('app')) {
                Alpine.store('app').showNotification(message, type);
            } else {
                alert(message);
            }
        }
    }));
});
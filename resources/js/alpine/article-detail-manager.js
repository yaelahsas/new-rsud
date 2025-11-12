document.addEventListener('alpine:init', () => {
    Alpine.data('articleDetailManager', () => ({
        article: null,
        relatedArticles: [],
        loading: true,
        error: null,
        slug: null,
        
        // Theme management
        darkMode: false,
        
        // Table of contents
        tableOfContents: [],
        
        // Article tags
        articleTags: [],
        
        // Reading progress
        readingProgress: 0,
        
        // Comments
        comments: [],
        commentForm: {
            name: '',
            email: '',
            comment: ''
        },
        commentLoading: false,
        
        // Structured data for SEO
        structuredData: {},
        
        init(slug) {
            // Get slug from parameter or URL
            this.slug = slug || this.$el.dataset.slug || window.location.pathname.split('/').pop();
            
            // Initialize theme
            this.darkMode = localStorage.getItem('darkMode') === 'true';
            this.applyTheme();
            
            // Load article data
            this.loadArticle();
            
            // Initialize reading progress tracker
            this.initReadingProgress();
            
            // Initialize table of contents
            this.initTableOfContents();
        },
        
        // Load article from API
        async loadArticle() {
            this.loading = true;
            this.error = null;
            
            try {
                const response = await fetch(`/api/article/${this.slug}`);
                const data = await response.json();
                
                if (data.success) {
                    this.article = data.article;
                    this.articleTags = this.extractTags(data.article.content);
                    this.generateStructuredData();
                    
                    // Load related articles
                    await this.loadRelatedArticles();
                    
                    // Load comments
                    await this.loadComments();
                    
                    // Update page title and meta
                    this.updatePageMeta();
                } else {
                    this.error = data.message || 'Artikel tidak ditemukan';
                }
            } catch (error) {
                console.error('Error loading article:', error);
                this.error = 'Terjadi kesalahan saat memuat artikel';
            } finally {
                this.loading = false;
            }
        },
        
        // Load related articles
        async loadRelatedArticles() {
            if (!this.article || !this.article.category) return;
            
            try {
                const response = await fetch(`/api/articles?category=${this.article.category.slug}&limit=4`);
                const data = await response.json();
                
                if (data.success) {
                    // Filter out current article
                    this.relatedArticles = data.articles.filter(a => a.id !== this.article.id).slice(0, 3);
                }
            } catch (error) {
                console.error('Error loading related articles:', error);
                this.relatedArticles = [];
            }
        },
        
        // Load comments
        async loadComments() {
            if (!this.article) return;
            
            try {
                const response = await fetch(`/api/article/${this.article.id}/comments`);
                const data = await response.json();
                
                if (data.success) {
                    this.comments = data.comments || [];
                }
            } catch (error) {
                console.error('Error loading comments:', error);
                this.comments = [];
            }
        },
        
        // Submit comment
        async submitComment() {
            if (!this.article) return;
            
            this.commentLoading = true;
            
            try {
                const response = await fetch(`/api/article/${this.article.id}/comment`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                    },
                    body: JSON.stringify(this.commentForm)
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Reset form
                    this.commentForm = {
                        name: '',
                        email: '',
                        comment: ''
                    };
                    
                    // Reload comments
                    await this.loadComments();
                    
                    this.showNotification('Komentar berhasil dikirim!', 'success');
                } else {
                    this.showNotification(data.message || 'Gagal mengirim komentar', 'error');
                }
            } catch (error) {
                console.error('Error submitting comment:', error);
                this.showNotification('Terjadi kesalahan saat mengirim komentar', 'error');
            } finally {
                this.commentLoading = false;
            }
        },
        
        // Initialize reading progress tracker
        initReadingProgress() {
            window.addEventListener('scroll', () => {
                if (!this.article) return;
                
                const articleElement = document.querySelector('.article-content');
                if (!articleElement) return;
                
                const articleTop = articleElement.offsetTop;
                const articleHeight = articleElement.offsetHeight;
                const windowHeight = window.innerHeight;
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                
                const progress = Math.min(100, Math.max(0, 
                    ((scrollTop - articleTop + windowHeight) / articleHeight) * 100
                ));
                
                this.readingProgress = Math.round(progress);
            });
        },
        
        // Initialize table of contents
        initTableOfContents() {
            this.$watch('article', () => {
                if (!this.article) return;
                
                // Wait for content to be rendered
                this.$nextTick(() => {
                    const headings = document.querySelectorAll('.article-content h2, .article-content h3, .article-content h4');
                    this.tableOfContents = Array.from(headings).map((heading, index) => {
                        const id = `heading-${index}`;
                        heading.id = id;
                        
                        return {
                            id,
                            text: heading.textContent,
                            level: parseInt(heading.tagName.substring(1))
                        };
                    });
                });
            });
        },
        
        // Extract tags from content
        extractTags(content) {
            // This is a simple implementation - in a real app, you might have a tags system
            const commonTags = [
                { id: 1, name: 'Kesehatan', slug: 'kesehatan' },
                { id: 2, name: 'Tips', slug: 'tips' },
                { id: 3, name: 'Poli', slug: 'poli' },
                { id: 4, name: 'Dokter', slug: 'dokter' },
                { id: 5, name: 'Vaksinasi', slug: 'vaksinasi' },
                { id: 6, name: 'Pandemi', slug: 'pandemi' }
            ];
            
            // Return random tags for demo
            return commonTags.sort(() => 0.5 - Math.random()).slice(0, 4);
        },
        
        // Generate structured data for SEO
        generateStructuredData() {
            if (!this.article) return;
            
            this.structuredData = {
                "@context": "https://schema.org",
                "@type": "Article",
                "headline": this.article.title,
                "description": this.article.excerpt,
                "image": this.article.thumbnail,
                "author": {
                    "@type": "Person",
                    "name": this.article.author?.name || 'RSUD Genteng'
                },
                "publisher": {
                    "@type": "Organization",
                    "name": "RSUD Genteng",
                    "logo": {
                        "@type": "ImageObject",
                        "url": window.location.origin + "/img/logo.png"
                    }
                },
                "datePublished": this.article.published_at,
                "dateModified": this.article.updated_at || this.article.published_at,
                "mainEntityOfPage": {
                    "@type": "WebPage",
                    "@id": window.location.href
                }
            };
        },
        
        // Update page meta tags
        updatePageMeta() {
            if (!this.article) return;
            
            document.title = `${this.article.title} - RSUD Genteng`;
            
            // Update meta description
            const metaDescription = document.querySelector('meta[name="description"]');
            if (metaDescription) {
                metaDescription.setAttribute('content', this.article.excerpt);
            }
            
            // Update Open Graph tags
            const ogTitle = document.querySelector('meta[property="og:title"]');
            if (ogTitle) {
                ogTitle.setAttribute('content', this.article.title);
            }
            
            const ogDescription = document.querySelector('meta[property="og:description"]');
            if (ogDescription) {
                ogDescription.setAttribute('content', this.article.excerpt);
            }
            
            const ogImage = document.querySelector('meta[property="og:image"]');
            if (ogImage) {
                ogImage.setAttribute('content', this.article.thumbnail);
            }
        },
        
        // Toggle theme
        toggleTheme() {
            this.darkMode = !this.darkMode;
            localStorage.setItem('darkMode', this.darkMode);
            this.applyTheme();
        },
        
        // Apply theme
        applyTheme() {
            if (this.darkMode) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        },
        
        // Format date
        formatDate(dateString) {
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return new Date(dateString).toLocaleDateString('id-ID', options);
        },
        
        // Scroll to heading
        scrollToHeading(id) {
            const element = document.getElementById(id);
            if (element) {
                element.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        },
        
        // Filter by tag
        filterByTag(tagSlug) {
            window.location.href = `/artikel?tag=${tagSlug}`;
        },
        
        // Share article
        shareArticle(platform) {
            const url = window.location.href;
            const text = this.article?.title || 'Artikel Kesehatan RSUD Genteng';
            
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
        
        // Show notification
        showNotification(message, type = 'info') {
            if (window.Alpine && Alpine.store('app')) {
                Alpine.store('app').showNotification(message, type);
            } else {
                alert(message);
            }
        }
    }));
});
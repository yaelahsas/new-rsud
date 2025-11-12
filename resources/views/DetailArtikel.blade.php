<x-layout>
    <div x-data="articleDetailManager" x-init="init('{{ $slug }}')"
         :class="darkMode ? 'dark bg-gray-900' : 'bg-gray-50'"
         class="min-h-screen transition-colors duration-300"
         >
        
        <!-- SEO Meta Tags -->
        <title x-text="article ? article?.title + ' - RSUD Genteng' : 'Artikel - RSUD Genteng'"></title>
        <meta name="description" x-content="article ? article?.excerpt : 'Baca artikel kesehatan terbaru dari RSUD Genteng'">
        <meta name="keywords" x-content="article ? article?.category?.name + ', ' + article?.title : 'artikel kesehatan, rsud genteng'">
        <meta name="author" x-content="article?.author?.name || 'RSUD Genteng'">
        <meta property="og:title" x-content="article ? article?.title : 'Artikel - RSUD Genteng'">
        <meta property="og:description" x-content="article ? article?.excerpt : 'Baca artikel kesehatan terbaru dari RSUD Genteng'">
        <meta property="og:image" x-content="article?.thumbnail || '/img/default-og.jpg'">
        <meta property="og:url" x-content="window.location.href">
        <meta property="og:type" content="article">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" x-content="article ? article?.title : 'Artikel - RSUD Genteng'">
        <meta name="twitter:description" x-content="article ? article?.excerpt : 'Baca artikel kesehatan terbaru dari RSUD Genteng'">
        <meta name="twitter:image" x-content="article?.thumbnail || '/img/default-twitter.jpg'">
        
        <!-- Structured Data -->
        <script type="application/ld+json" x-html="JSON.stringify(structuredData)"></script>
        
        <!-- Loading Skeleton -->
        <div x-show="loading" class="container mx-auto px-4 py-8">
            <div class="animate-pulse">
                <div class="h-8 bg-gray-300 rounded w-3/4 mb-4"></div>
                <div class="h-4 bg-gray-300 rounded w-1/2 mb-8"></div>
                <div class="h-64 bg-gray-300 rounded mb-8"></div>
                <div class="space-y-4">
                    <div class="h-4 bg-gray-300 rounded"></div>
                    <div class="h-4 bg-gray-300 rounded"></div>
                    <div class="h-4 bg-gray-300 rounded w-5/6"></div>
                </div>
            </div>
        </div>
        
        <!-- Article Content -->
        <div x-show="!loading && article" x-transition:enter="transition ease-out duration-300" 
             x-transition:enter-start="opacity-0 transform translate-y-4"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             class="container mx-auto px-4 py-8 max-w-4xl">
            
            <!-- Breadcrumb -->
            <nav class="flex mb-8 text-sm" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="/" class="text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            Beranda
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <a href="/artikel" class="ml-1 text-gray-500 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-blue-400">Artikel</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-gray-500 md:ml-2 dark:text-gray-400" x-show="article" x-text="article?.title"></span>
                        </div>
                    </li>
                </ol>
            </nav>
            
            <!-- Article Header -->
            <header class="mb-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-6">
                    <div class="flex-1">
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4 leading-tight"
                            x-show="article" x-text="article?.title"></h1>
                        
                        <div class="flex flex-wrap items-center text-sm text-gray-600 dark:text-gray-400 space-x-4">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                </svg>
                                <span x-show="article" x-text="formatDate(article?.published_at)"></span>
                            </span>
                            
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                                <span x-show="article" x-text="article?.read_time"></span>
                            </span>
                            
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span x-show="article" x-text="article?.views + ' views'"></span>
                            </span>
                        </div>
                    </div>
                    
                    <!-- Theme Toggle -->
                    <button @click="toggleTheme()" 
                            class="mt-4 lg:mt-0 p-2 rounded-lg bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors"
                            :title="darkMode ? 'Switch to light mode' : 'Switch to dark mode'">
                        <svg x-show="!darkMode" class="w-5 h-5 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
                        </svg>
                        <svg x-show="darkMode" class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Category Badge -->
                <div class="mb-6">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path>
                        </svg>
                        <span x-show="article" x-text="article?.category?.name"></span>
                    </span>
                </div>
            </header>
            
            <!-- Featured Image -->
            <div x-show="article" class="mb-8 rounded-xl overflow-hidden shadow-lg relative">
                <img :src="article?.thumbnail"
                     :alt="article?.title"
                     class="w-full h-auto object-cover"
                     loading="lazy">
                <div x-show="article?.featured" class="absolute top-4 right-4 bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                    Featured
                </div>
            </div>
            
            <!-- Table of Contents -->
            <div x-show="tableOfContents.length > 0" 
                 class="mb-8 p-6 bg-white dark:bg-gray-800 rounded-xl shadow-md">
                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    Daftar Isi
                </h3>
                <ul class="space-y-2">
                    <template x-for="item in tableOfContents" :key="item.id">
                        <li>
                            <a :href="'#' + item.id" 
                               @click="scrollToHeading(item.id)"
                               class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors"
                               :class="'ml-' + (item.level * 4)">
                                <span x-text="item.text"></span>
                            </a>
                        </li>
                    </template>
                </ul>
            </div>
            
            <!-- Article Content -->
            <article x-show="article" class="prose prose-lg max-w-none dark:prose-invert prose-headings:scroll-mt-20">
                <div x-html="article?.content" class="article-content"></div>
            </article>
            
            <!-- Article Footer -->
            <footer class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-700">
                <!-- Tags -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Tag Terkait</h3>
                    <div class="flex flex-wrap gap-2">
                        <template x-for="tag in articleTags" :key="tag.id">
                            <button @click="filterByTag(tag.slug)"
                                    class="px-3 py-1 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-full text-sm transition-colors">
                                <span x-show="articleTags.length > 0" x-text="tag.name"></span>
                            </button>
                        </template>
                    </div>
                </div>
                
                <!-- Share Buttons -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Bagikan Artikel</h3>
                    <div class="flex flex-wrap gap-3">
                        <button @click="shareArticle('facebook')"
                                class="flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12 5.373 12 12 12zm-12-10.067c-2.4 0-4.333 1.933-4.333 4.333 0 2.4 1.933 4.333 4.333 4.333 2.4 0 4.333-1.933 4.333-4.333zm0 5.733c-1.067 0-2.067-.267-2.933-.667l-2.133 2.133c-.667.667-1.6 1.067-2.667 1.067-2.4 0-4.333-1.933-4.333-4.333 0-2.4 1.933-4.333 4.333-4.333.8 0 1.6.133.267 2.4.667l2.133-2.133c.667-.667 1.067-1.6 1.067-2.667z" />
                            </svg>
                            Facebook
                        </button>
                        
                        <button @click="shareArticle('twitter')"
                                class="flex items-center px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white rounded-lg transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.748 5.074 5.074 0 011.524 2.322 5.074 5.074 0 012.71 1.837 5.074 5.074 0 012.571 2.06 5.074 5.074 0 013.229-.665 5.074 5.074 0 011.315-1.126 5.074 5.074 0 011.498-1.782 5.074 5.074 0 011.653-2.404 5.074 5.074 0 011.858-2.918 5.074 5.074 0 012.166-3.43 5.074 5.074 0 012.656-4.971C-1.845 1.263 5.495 0 12 0c2.655 0 5.197.748 7.466 2.115v2.847c-1.356.35-2.557.998-3.38 1.825l3.426-3.426c1.067-1.067 1.825-2.571 1.825-4.247 0-3.297-2.689-5.986-5.986-5.986 0-1.676.688-3.261 1.825-4.247l-3.426 3.426c-1.067 1.067-2.571 1.825-4.247 1.825-3.297 0-5.986-2.689-5.986-5.986 0-1.676.688-3.261 1.825-4.247l3.426-3.426c1.067-1.067 1.825-2.571 1.825-4.247z" />
                            </svg>
                            Twitter
                        </button>
                        
                        <button @click="shareArticle('whatsapp')"
                                class="flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                            </svg>
                            WhatsApp
                        </button>
                        
                        <button @click="shareArticle('telegram')"
                                class="flex items-center px-4 py-2 bg-blue-400 hover:bg-blue-500 text-white rounded-lg transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.562 8.161c-.18 1.897-.962 6.502-1.359 8.627-.168.9-.5 1.201-.82 1.23-.697.064-1.226-.461-1.901-.903-1.056-.692-1.653-1.123-2.678-1.799-1.185-.781-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.139-5.062 3.345-.479.329-.913.49-1.302.481-.428-.008-1.252-.241-1.865-.44-.752-.244-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.831-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635.099-.002.325.018.468.111.119.078.193.183.224.297.023.083.053.297.032.458z" />
                            </svg>
                            Telegram
                        </button>
                        
                        <button @click="shareArticle('copy')"
                                class="flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            Salin Link
                        </button>
                    </div>
                </div>
            </footer>
        </div>
        
        <!-- Error State -->
        <div x-show="!loading && error" class="container mx-auto px-4 py-8 max-w-4xl">
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-6 text-center">
                <svg class="w-16 h-16 text-red-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h2 class="text-xl font-semibold text-red-800 dark:text-red-200 mb-2">Artikel Tidak Ditemukan</h2>
                <p class="text-red-600 dark:text-red-400 mb-4" x-text="error"></p>
                <a href="/artikel" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                    Kembali ke Daftar Artikel
                </a>
            </div>
        </div>
        
        <!-- Reading Progress Bar -->
        <div x-show="!loading && article"
             class="fixed top-0 left-0 w-full h-1 bg-gray-200 dark:bg-gray-700 z-50">
            <div class="h-full bg-blue-600 transition-all duration-150"
                 :style="`width: ${readingProgress}%`"></div>
        </div>
        
        <!-- Related Articles Section -->
        <div x-show="!loading && article && relatedArticles.length > 0"
             class="container mx-auto px-4 py-12 max-w-6xl">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Artikel Terkait</h2>
                <p class="text-gray-600 dark:text-gray-400">Baca artikel lainnya yang mungkin Anda sukai</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <template x-for="relatedArticle in relatedArticles" :key="relatedArticle.id">
                    <article class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow hover:shadow-lg transition-all duration-300">
                        <div class="relative">
                            <img :src="relatedArticle?.thumbnail"
                                 :alt="relatedArticle?.title"
                                 class="w-full h-48 object-cover">
                            <span class="absolute top-3 left-3 bg-blue-600 text-white text-xs font-semibold px-2 py-1 rounded-full">
                                <span x-text="relatedArticle?.category?.name"></span>
                            </span>
                        </div>
                        
                        <div class="p-5">
                            <h3 class="text-lg font-semibold mb-2">
                                <a :href="`/artikel/${relatedArticle?.slug}`"
                                   class="text-gray-900 dark:text-white hover:text-blue-600 transition-colors">
                                    <span x-text="relatedArticle?.title"></span>
                                </a>
                            </h3>
                            
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-3" x-text="relatedArticle?.excerpt"></p>
                            
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-500 dark:text-gray-400" x-text="formatDate(relatedArticle?.published_at)"></span>
                                <a :href="`/artikel/${relatedArticle?.slug}`"
                                   class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                    Baca Selengkapnya →
                                </a>
                            </div>
                        </div>
                    </article>
                </template>
            </div>
        </div>
        
        <!-- Comments Section -->
        <div x-show="!loading && article"
             class="container mx-auto px-4 py-12 max-w-4xl">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Komentar</h2>
                
                <!-- Comment Form -->
                <div class="mb-8 p-6 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Tinggalkan Komentar</h3>
                    
                    <form @submit.prevent="submitComment()">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama</label>
                                <input type="text" x-model="commentForm.name" required
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:text-white">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                                <input type="email" x-model="commentForm.email" required
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:text-white">
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Komentar</label>
                            <textarea x-model="commentForm.comment" rows="4" required
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:text-white"></textarea>
                        </div>
                        
                        <button type="submit"
                                :disabled="commentLoading"
                                class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                            <span x-show="!commentLoading">Kirim Komentar</span>
                            <span x-show="commentLoading">Mengirim...</span>
                        </button>
                    </form>
                </div>
                
                <!-- Comments List -->
                <div x-show="comments.length > 0" class="space-y-6">
                    <template x-for="comment in comments" :key="comment.id">
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-6 last:border-0">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold">
                                        <span x-text="comment.name.charAt(0).toUpperCase()"></span>
                                    </div>
                                </div>
                                
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-2">
                                        <h4 class="font-semibold text-gray-900 dark:text-white" x-text="comment.name"></h4>
                                        <span class="text-sm text-gray-500 dark:text-gray-400" x-text="formatDate(comment.created_at)"></span>
                                    </div>
                                    
                                    <p class="text-gray-700 dark:text-gray-300" x-text="comment.comment"></p>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
                
                <!-- No Comments -->
                <div x-show="comments.length === 0" class="text-center py-8">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                </div>
            </div>
        </div>
    </div>
</x-layout>

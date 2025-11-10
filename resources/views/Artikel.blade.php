<x-layout>
    <section class="bg-gray-50 py-10" x-data="articleManager" x-init="init()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Artikel Utama -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Header dengan Search dan View Toggle -->
                <div class="bg-white rounded-2xl shadow p-6 mb-6 fade-in">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4">
                        <h2 class="text-2xl font-bold text-gray-900">Artikel Kesehatan</h2>

                        <!-- View Mode Toggle -->
                        <div class="flex items-center space-x-2">
                            <button @click="toggleViewMode()"
                                :class="viewMode === 'grid' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-600'"
                                class="p-2 rounded-lg transition-all duration-200 transform hover:scale-110"
                                title="Grid View">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                                    </path>
                                </svg>
                            </button>
                            <button @click="toggleViewMode()"
                                :class="viewMode === 'list' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-600'"
                                class="p-2 rounded-lg transition-all duration-200 transform hover:scale-110"
                                title="List View">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Search Bar -->
                    <div class="relative">
                        <input type="text" x-model="filters.search" @input.debounce.300ms="applyFilters()"
                            placeholder="Cari artikel..."
                            class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2 pr-10 text-gray-700 focus:border-blue-500 focus:ring focus:ring-blue-200 focus-transition">
                        <svg class="absolute right-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Loading State -->
                <div x-show="loading" class="text-center py-12 fade-in">
                    <div class="inline-flex items-center">
                        <svg class="animate-spin -ml-1 mr-3 h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span class="text-gray-600 text-lg">Memuat artikel...</span>
                    </div>
                </div>

                <!-- No Results -->
                <div x-show="!loading && filteredArticles.length === 0" class="text-center py-12 fade-in">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada artikel yang ditemukan</h3>
                    <p class="text-gray-600 mb-4">Coba ubah filter atau kata kunci pencarian Anda.</p>
                    <button @click="clearFilters()"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 btn-hover">
                        Hapus Filter
                    </button>
                </div>

                <!-- Grid View -->
                <div x-show="!loading && filteredArticles.length > 0 && viewMode === 'grid'" id="article-results"
                    class="grid sm:grid-cols-2 gap-6">

                    <template x-for="article in paginatedArticles" :key="article.id">
                        <article
                            class="bg-white rounded-2xl overflow-hidden shadow hover:shadow-lg transition-all duration-300 flex flex-col group card-hover stagger-item">
                            <div class="relative">
                                <img :src="article.thumbnail" :alt="article.title"
                                    class="w-full h-52 object-cover group-hover:scale-105 transition-transform duration-500 image-placeholder">

                                <!-- Category Badge -->
                                <span
                                    class="absolute top-3 left-3 bg-blue-600 text-white text-sm font-semibold px-3 py-1 rounded-full">
                                    <span x-text="article.category.name"></span>
                                </span>

                                <!-- Featured Badge -->
                                <span x-show="article.featured"
                                    class="absolute top-3 right-3 bg-yellow-500 text-white text-xs font-semibold px-2 py-1 rounded-full">
                                    Featured
                                </span>
                            </div>

                            <div class="p-5 flex flex-col justify-between flex-grow">
                                <div>
                                    <h3 class="text-lg font-semibold mb-2">
                                        <a :href="`/artikel/${article.slug}`"
                                            class="text-gray-900 hover:text-blue-600 transition">
                                            <span x-text="article.title"></span>
                                        </a>
                                    </h3>
                                    <p class="text-gray-500 text-sm mb-3">
                                        <i class="bi bi-folder"></i>
                                        <span x-text="article.category.name"></span> •
                                        <span x-text="article.read_time + ' baca'"></span>
                                    </p>
                                    <p class="text-gray-600 mb-4 line-clamp-3" x-text="article.excerpt"></p>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex items-center justify-between">
                                    <a :href="`/artikel/${article.slug}`"
                                        class="inline-flex items-center text-blue-600 hover:underline font-medium text-sm transition-all duration-200 hover:text-blue-700">
                                        Baca Selengkapnya
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor"
                                            class="w-4 h-4 ml-1 transition-transform duration-200 group-hover:translate-x-1">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M17.25 8.25L21 12l-3.75 3.75M3 12h18" />
                                        </svg>
                                    </a>

                                    <!-- Save Button -->
                                    <button @click="saveArticle(article.id)"
                                        :class="isSaved(article.id) ? 'text-red-500' : 'text-gray-400'"
                                        class="p-2 hover:bg-gray-100 rounded-lg transition-all duration-200 transform hover:scale-110"
                                        :title="isSaved(article.id) ? 'Hapus dari tersimpan' : 'Simpan artikel'">
                                        <svg class="w-5 h-5" :class="isSaved(article.id) ? 'fill-current' : ''"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </article>
                    </template>
                </div>

                <!-- List View -->
                <div x-show="!loading && filteredArticles.length > 0 && viewMode === 'list'" id="article-results"
                    class="space-y-6">

                    <template x-for="article in paginatedArticles" :key="article.id">
                        <article
                            class="bg-white rounded-2xl overflow-hidden shadow hover:shadow-lg transition-all duration-300 card-hover stagger-item">
                            <div class="flex flex-col sm:flex-row">
                                <div class="sm:w-1/3">
                                    <img :src="article.thumbnail" :alt="article.title"
                                        class="w-full h-48 sm:h-full object-cover image-placeholder">
                                </div>
                                <div class="flex-1 p-6">
                                    <div class="flex items-start justify-between mb-2">
                                        <div>
                                            <span
                                                class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded-full mb-2">
                                                <span x-text="article.category.name"></span>
                                            </span>
                                            <span x-show="article.featured"
                                                class="inline-block bg-yellow-100 text-yellow-800 text-xs font-semibold px-2 py-1 rounded-full mb-2 ml-2">
                                                Featured
                                            </span>
                                        </div>

                                        <!-- Save Button -->
                                        <button @click="saveArticle(article.id)"
                                            :class="isSaved(article.id) ? 'text-red-500' : 'text-gray-400'"
                                            class="p-2 hover:bg-gray-100 rounded-lg transition-all duration-200 transform hover:scale-110">
                                            <svg class="w-5 h-5" :class="isSaved(article.id) ? 'fill-current' : ''"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                            </svg>
                                        </button>
                                    </div>

                                    <h3 class="text-xl font-semibold mb-2">
                                        <a :href="`/artikel/${article.slug}`"
                                            class="text-gray-900 hover:text-blue-600 transition">
                                            <span x-text="article.title"></span>
                                        </a>
                                    </h3>

                                    <p class="text-gray-600 mb-4" x-text="article.excerpt"></p>

                                    <div class="flex items-center justify-between">
                                        <div class="text-sm text-gray-500">
                                            <span x-text="formatDate(article.published_at)"></span> •
                                            <span x-text="article.read_time + ' baca'"></span> •
                                            <span x-text="article.views + ' views'"></span>
                                        </div>

                                        <a :href="`/artikel/${article.slug}`"
                                            class="inline-flex items-center text-blue-600 hover:underline font-medium text-sm transition-all duration-200 hover:text-blue-700">
                                            Baca Selengkapnya
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="w-4 h-4 ml-1 transition-transform duration-200 group-hover:translate-x-1">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M17.25 8.25L21 12l-3.75 3.75M3 12h18" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </template>
                </div>

                <!-- Pagination -->
                <div x-show="pagination.totalPages > 1" class="flex justify-center mt-8">
                    <nav class="inline-flex rounded-md shadow-sm isolate">
                        <!-- Previous -->
                        <button @click="changePage(pagination.currentPage - 1)"
                            :disabled="pagination.currentPage === 1"
                            class="px-3 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200 pagination-item">
                            Previous
                        </button>

                        <!-- Page Numbers -->
                        <template x-for="page in Math.min(5, pagination.totalPages)" :key="page">
                            <button @click="changePage(page)"
                                :class="pagination.currentPage === page ? 'bg-blue-600 text-white' :
                                    'bg-white text-gray-700 hover:bg-gray-50'"
                                class="px-3 py-2 border border-gray-300 text-sm font-medium transition-all duration-200 pagination-item">
                                <span x-text="page"></span>
                            </button>
                        </template>

                        <!-- Next -->
                        <button @click="changePage(pagination.currentPage + 1)"
                            :disabled="pagination.currentPage === pagination.totalPages"
                            class="px-3 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200 pagination-item">
                            Next
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Sidebar -->
            <aside class="space-y-8">
                <!-- Pencarian Lanjutan -->
                <div class="bg-white rounded-2xl shadow p-6 fade-in">
                    <h3 class="text-lg font-semibold mb-4">Filter Artikel</h3>

                    <!-- Category Filter -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                        <select x-model="filters.category" @change="applyFilters()"
                            class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-700 focus:border-blue-500 focus:ring focus:ring-blue-200 focus-transition">
                            <option value="">Semua Kategori</option>
                            <template x-for="category in categories" :key="category.id">
                                <option :value="category.slug"
                                    x-text="`${category.name} (${getCategoryCount(category.slug)})`"></option>
                            </template>
                        </select>
                    </div>

                    <!-- Date Filter -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Bulan</label>
                        <input type="month" x-model="filters.date" @change="applyFilters()"
                            class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-700 focus:border-blue-500 focus:ring focus:ring-blue-200 focus-transition">
                    </div>

                    <!-- Clear Filters -->
                    <button @click="clearFilters()"
                        class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-lg transition-all duration-200 btn-hover">
                        Hapus Semua Filter
                    </button>
                </div>

                <!-- Artikel Terbaru -->
                <div class="bg-white rounded-2xl shadow p-6 fade-in">
                    <h3 class="text-lg font-semibold mb-4">Artikel Terbaru</h3>
                    <div class="space-y-4">
                        <template x-for="article in articles.slice(0, 5)" :key="article.id">
                            <div class="flex items-start space-x-3 stagger-item">
                                <img :src="article.thumbnail" :alt="article.title"
                                    class="w-20 h-16 object-cover rounded-lg transition-transform duration-200 hover:scale-105">
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium leading-tight">
                                        <a :href="`/artikel/${article.slug}`"
                                            class="text-gray-900 hover:text-blue-600 transition-colors duration-200">
                                            <span x-text="article.title"></span>
                                        </a>
                                    </h4>
                                    <time class="text-xs text-gray-500"
                                        x-text="formatDate(article.published_at)"></time>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Share Section -->
                <div class="bg-white rounded-2xl shadow p-6 fade-in">
                    <h3 class="text-lg font-semibold mb-4">Bagikan Artikel</h3>
                    <div class="grid grid-cols-2 gap-2">
                        <button @click="shareArticle(null, 'facebook')"
                            class="flex items-center justify-center p-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 btn-hover">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12 5.373 12 12 12zm-12-10.067c-2.4 0-4.333 1.933-4.333 4.333 0 2.4 1.933 4.333 4.333 4.333 2.4 0 4.333-1.933 4.333-4.333zm0 5.733c-1.067 0-2.067-.267-2.933-.667l-2.133 2.133c-.667.667-1.6 1.067-2.667 1.067-2.4 0-4.333-1.933-4.333-4.333 0-2.4 1.933-4.333 4.333-4.333.8 0 1.6.133.267 2.4.667l2.133-2.133c.667-.667 1.067-1.6 1.067-2.667z" />
                            </svg>
                        </button>
                        <button @click="shareArticle(null, 'twitter')"
                            class="flex items-center justify-center p-3 bg-sky-500 text-white rounded-lg hover:bg-sky-600 transition-all duration-200 btn-hover">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M23.953 4.57a10 10 0 01-2.825.748 5.074 5.074 0 011.524 2.322 5.074 5.074 0 012.71 1.837 5.074 5.074 0 012.571 2.06 5.074 5.074 0 013.229-.665 5.074 5.074 0 014.292 2.756 5.074 5.074 0 011.315-1.126 5.074 5.074 0 011.498-1.782 5.074 5.074 0 011.653-2.404 5.074 5.074 0 011.858-2.918 5.074 5.074 0 012.166-3.43 5.074 5.074 0 012.656-4.971c-1.845 1.263-4.069 2-6.43 2-2.655 0-5.197-.748-7.466-2.115v2.847c1.356.35 2.557.998 3.38 1.825l3.426-3.426c1.067-1.067 1.825-2.571 1.825-4.247 0-3.297-2.689-5.986-5.986-3.297 0-5.986 2.689-5.986 5.986 0 1.676.688 3.261 1.825 4.247l-3.426 3.426c-1.067 1.067-2.571 1.825-4.247 1.825-3.297 0-5.986-2.689-5.986-5.986 0-1.676.688-3.261 1.825-4.247l3.426-3.426c1.067-1.067 1.825-2.571 1.825-4.247z" />
                            </svg>
                        </button>
                        <button @click="shareArticle(null, 'whatsapp')"
                            class="flex items-center justify-center p-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-all duration-200 btn-hover">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                            </svg>
                        </button>
                        <button @click="shareArticle(null, 'telegram')"
                            class="flex items-center justify-center p-3 bg-blue-400 text-white rounded-lg hover:bg-blue-500 transition-all duration-200 btn-hover">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.562 8.161c-.18 1.897-.962 6.502-1.359 8.627-.168.9-.5 1.201-.82 1.23-.697.064-1.226-.461-1.901-.903-1.056-.692-1.653-1.123-2.678-1.799-1.185-.781-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.139-5.062 3.345-.479.329-.913.49-1.302.481-.428-.008-1.252-.241-1.865-.44-.752-.244-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.831-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635.099-.002.325.018.468.111.119.078.193.183.224.297.023.083.053.297.032.458z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Popular Tags -->
                <div class="bg-white rounded-2xl shadow p-6 fade-in">
                    <h3 class="text-lg font-semibold mb-4">Tag Populer</h3>
                    <div class="flex flex-wrap gap-2">
                        <template x-for="tag in popularTags" :key="tag.id">
                            <button @click="filterByTag(tag.slug)"
                                class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-full text-sm transition-all duration-200">
                                <span x-text="tag.name"></span>
                                <span class="text-xs text-gray-500" x-text="'(' + tag.count + ')'"></span>
                            </button>
                        </template>
                    </div>
                </div>
            </aside>
        </div>
    </section>
</x-layout>
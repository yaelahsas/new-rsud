<!-- SECTION: Sticky Banner + Header -->
<section x-data="appShell" x-init="init()" class="fixed top-0 left-0 w-full z-50"
    :class="{ 'shadow-lg': scrolled }">
    <!-- Sticky Banner -->
    <div id="sticky-banner"
         class="flex justify-between w-full py-2 px-4 border-b border-gray-200 bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
        <div class="flex items-center mx-auto">
            <p class="flex items-center text-sm font-normal text-gray-500 dark:text-gray-400">
                <span
                    class="inline-flex p-1 me-3 bg-gray-200 rounded-full dark:bg-gray-600 w-6 h-6 items-center justify-center shrink-0">
                    <svg class="w-3 h-3 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 19">
                        <path
                            d="M15 1.943v12.114a1 1 0 0 1-1.581.814L8 11V5l5.419-3.871A1 1 0 0 1 15 1.943ZM7 4H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2v5a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2V4ZM4 17v-5h1v5H4ZM16 5.183v5.634a2.984 2.984 0 0 0 0-5.634Z" />
                    </svg>
                </span>
                <span>
                    🚀 <strong>Informasi:</strong> Pelayanan online RSUD Genteng kini bisa diakses lewat
                    <a href="#" class="font-medium text-blue-600 underline dark:text-blue-400 hover:no-underline">
                        aplikasi Genpas
                    </a>.
                </span>
            </p>
        </div>
        <div class="flex items-center">
            <!-- Sticky banner tidak bisa ditutup oleh user -->
        </div>
    </div>

    <!-- Header / Navbar -->
    <header class="bg-white border-gray-200 px-4 lg:px-6 py-2.5 shadow-md dark:bg-gray-800 transition-all duration-300">
        <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
            <!-- Logo -->
            <a href="/" class="flex items-center">
                <img src="https://flowbite.com/docs/images/logo.svg"
                    class="mr-3 h-6 sm:h-9 transition-transform duration-300 hover:scale-105" alt="Logo RS" />
                <span
                    class="self-center text-xl font-semibold whitespace-nowrap dark:text-white transition-colors duration-300 group-hover:text-blue-600">RSUD
                    Genteng</span>
            </a>

            <!-- Right side items -->
            <div class="flex items-center lg:order-1 space-x-4">
                <!-- Search Button (Desktop) -->
                <button @click="openSearch()"
                    class="hidden md:inline-flex items-center p-2 text-gray-500 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-all duration-200 transform hover:scale-110">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span class="sr-only">Search</span>
                </button>

                <!-- Mobile menu toggle -->
                <button @click="toggleMobileMenu()" :class="{ 'text-gray-900 bg-gray-100': mobileMenuOpen }"
                    class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600 transition-all duration-200 transform hover:scale-110"
                    :aria-expanded="mobileMenuOpen">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>

            <!-- Navigation Menu -->
            <div :class="mobileMenuOpen ? 'block' : 'hidden'"
                class="justify-between items-center w-full lg:flex lg:w-auto lg:order-2" id="mobile-menu-2">
                <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                    <li>
                        <a href="/" @click="navigateTo('/', $event)"
                            :class="isActive('/') ? 'text-blue-700' : 'text-gray-700 hover:text-blue-700'"
                            class="block lg:p-0 dark:text-white transition-colors duration-200 relative group">
                            Beranda
                            <span
                                class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-200"></span>
                        </a>
                    </li>
                    <li>
                        <a href="/layanan" @click="navigateTo('/layanan', $event)"
                            :class="isActive('/layanan') ? 'text-blue-700' : 'text-gray-700 hover:text-blue-700'"
                            class="block lg:p-0 dark:text-gray-400 dark:hover:text-white transition-colors duration-200 relative group">
                            Layanan
                            <span
                                class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-200"></span>
                        </a>
                    </li>
                    <li>
                        <a href="/medis" @click="navigateTo('/medis', $event)"
                            :class="isActive('/medis') ? 'text-blue-700' : 'text-gray-700 hover:text-blue-700'"
                            class="block lg:p-0 dark:text-gray-400 dark:hover:text-white transition-colors duration-200 relative group">
                            Dokter
                            <span
                                class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-200"></span>
                        </a>
                    </li>
                    <li>
                        <a href="/inovasi" @click="navigateTo('/inovasi', $event)"
                            :class="isActive('/inovasi') ? 'text-blue-700' : 'text-gray-700 hover:text-blue-700'"
                            class="block lg:p-0 dark:text-gray-400 dark:hover:text-white transition-colors duration-200 relative group">
                            Inovasi
                            <span
                                class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-200"></span>
                        </a>
                    </li>
                    <li>
                        <a href="/artikel" @click="navigateTo('/artikel', $event)"
                            :class="isActive('/artikel') ? 'text-blue-700' : 'text-gray-700 hover:text-blue-700'"
                            class="block lg:p-0 dark:text-gray-400 dark:hover:text-white transition-colors duration-200 relative group">
                            Artikel
                            <span
                                class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-200"></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Global Search Overlay -->
    <div x-show="searchOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-start justify-center pt-20"
        @click.self="closeSearch()">

        <div class="search-container bg-white rounded-lg shadow-xl w-full max-w-2xl mx-4 modal-content"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95">

            <div class="p-4 border-b border-gray-200">
                <div class="relative">
                    <input x-ref="searchInput" x-model="searchQuery" @input.debounce.300ms="performSearch()"
                        type="text" placeholder="Cari dokter, layanan, atau informasi..."
                        class="w-full pl-10 pr-4 py-3 text-gray-700 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus-transition">
                    <svg class="absolute left-3 top-3.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <button @click="closeSearch()" class="absolute right-3 top-3.5 text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Search Results -->
            <div class="max-h-96 overflow-y-auto">
                <!-- Loading State -->
                <div x-show="searchLoading" class="p-8 text-center">
                    <div class="inline-flex items-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span class="text-gray-600">Mencari...</span>
                    </div>
                </div>

                <!-- Results -->
                <div x-show="!searchLoading && searchResults.length > 0" class="p-4">
                    <!-- Doctor Results -->
                    <template x-for="result in searchResults.filter(r => r.category === 'doctors')"
                        :key="result.id">
                        <a :href="result.url"
                            class="block p-3 hover:bg-gray-50 rounded-lg transition-all duration-200 search-result-item stagger-item">
                            <div class="flex items-center space-x-3">
                                <img x-show="result.image" :src="result.image" :alt="result.title"
                                    class="w-12 h-12 rounded-lg object-cover">
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900" x-text="result.title"></h4>
                                    <p class="text-sm text-gray-500" x-text="result.description"></p>
                                </div>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Dokter
                                </span>
                            </div>
                        </a>
                    </template>

                    <!-- Service Results -->
                    <template x-for="result in searchResults.filter(r => r.category === 'services')"
                        :key="result.id">
                        <a :href="result.url"
                            class="block p-3 hover:bg-gray-50 rounded-lg transition-all duration-200 search-result-item stagger-item">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                        </path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900" x-text="result.title"></h4>
                                    <p class="text-sm text-gray-500" x-text="result.description"></p>
                                </div>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Layanan
                                </span>
                            </div>
                        </a>
                    </template>

                    <!-- Article Results -->
                    <template x-for="result in searchResults.filter(r => r.category === 'articles')"
                        :key="result.id">
                        <a :href="result.url"
                            class="block p-3 hover:bg-gray-50 rounded-lg transition-all duration-200 search-result-item stagger-item">
                            <div class="flex items-center space-x-3">
                                <img x-show="result.image" :src="result.image" :alt="result.title"
                                    class="w-12 h-12 rounded-lg object-cover">
                                <div x-show="!result.image"
                                    class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                        </path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900" x-text="result.title"></h4>
                                    <p class="text-sm text-gray-500" x-text="result.description"></p>
                                </div>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    Artikel
                                </span>
                            </div>
                        </a>
                    </template>

                    <!-- View all results link -->
                    <div class="mt-3 pt-3 border-t border-gray-200">
                        <a :href="`/medis?search=${encodeURIComponent(searchQuery)}`"
                            class="block w-full text-center text-sm text-blue-600 hover:text-blue-700 font-medium">
                            Lihat semua hasil untuk "<span x-text="searchQuery"></span>"
                        </a>
                    </div>
                </div>

                <!-- No Results -->
                <div x-show="!searchLoading && searchQuery.length >= 2 && searchResults.length === 0"
                    class="p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada hasil</h3>
                    <p class="mt-1 text-sm text-gray-500">Coba kata kunci lain atau periksa ejaan Anda.</p>
                </div>

                <!-- Initial State -->
                <div x-show="searchQuery.length < 2" class="p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Mulai pencarian</h3>
                    <p class="mt-1 text-sm text-gray-500">Ketik minimal 2 karakter untuk memulai pencarian.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Spacer (tinggi total banner + navbar) -->
<div class="h-10 md:h-18"></div>

<x-layout>
    <!-- SEO Meta Tags -->
    <title x-text="seoData.title">Temukan Dokter Kami - RSUD Genteng</title>
    <meta name="description" x-content="seoData.description" content="Cari dokter berdasarkan nama, spesialisasi, atau jadwal praktik di RSUD Genteng">
    <meta name="keywords" x-content="seoData.keywords" content="dokter, spesialis, jadwal praktik, RSUD Genteng">
    <meta property="og:title" x-content="seoData.title" content="Temukan Dokter Kami - RSUD Genteng">
    <meta property="og:description" x-content="seoData.description" content="Cari dokter berdasarkan nama, spesialisasi, atau jadwal praktik di RSUD Genteng">
    <meta property="og:image" x-content="seoData.ogImage" content="/img/og-doctor-finder.jpg">
    <meta property="og:url" x-content="window.location.href" content="">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" x-content="seoData.title" content="Temukan Dokter Kami - RSUD Genteng">
    <meta name="twitter:description" x-content="seoData.description" content="Cari dokter berdasarkan nama, spesialisasi, atau jadwal praktik di RSUD Genteng">
    <meta name="twitter:image" x-content="seoData.ogImage" content="/img/og-doctor-finder.jpg">
    <link rel="canonical" x-href="window.location.href" href="">
    
    <section id="doctors" class="py-20 bg-gray-50" x-data="doctorFinder" x-init="init()">
        <div class="container mx-auto px-4">
            <!-- Judul -->
            <div class="text-center mb-12" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-semibold text-gray-900 tracking-tight mb-2">
                    Temukan Dokter Kami
                </h2>
                <p class="text-gray-600 text-base md:text-lg">
                    Cari dokter berdasarkan nama, spesialisasi, atau jadwal praktik
                </p>
            </div>

            <!-- Search and Filters -->
            <div class="max-w-6xl mx-auto mb-10" data-aos="fade-up" data-aos-delay="100">
                <div class="bg-white rounded-2xl shadow-md p-6">
                    <!-- Search Bar -->
                    <div class="mb-6">
                        <div class="relative">
                            <input
                                type="text"
                                x-model="filters.search"
                                placeholder="🔍 Cari nama dokter atau spesialisasi..."
                                class="w-full rounded-2xl border border-gray-300 bg-white px-5 py-4 pr-12 text-gray-700 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-300 text-lg" />
                            <div class="absolute right-4 top-1/2 transform -translate-y-1/2">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Filters -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <!-- Specialization Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Spesialisasi</label>
                            <select
                                x-model="filters.specialization"
                                class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-700 focus:border-blue-500 focus:ring focus:ring-blue-200">
                                <template x-for="spec in specializations" :key="spec">
                                    <option :value="spec" x-text="`${spec} (${getSpecializationCount(spec)})`"></option>
                                </template>
                            </select>
                        </div>

                        <!-- Schedule Filter -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jadwal Praktik</label>
                            <select
                                x-model="filters.schedule"
                                class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-gray-700 focus:border-blue-500 focus:ring focus:ring-blue-200">
                                <template x-for="option in scheduleOptions" :key="option.value">
                                    <option :value="option.value" x-text="option.label"></option>
                                </template>
                            </select>
                        </div>

                        <!-- Available Filter -->
                        <div class="flex items-end">
                            <label class="flex items-center cursor-pointer">
                                <input
                                    type="checkbox"
                                    x-model="filters.available"
                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Hanya dokter yang tersedia</span>
                            </label>
                        </div>
                    </div>

                    <!-- Clear Filters -->
                    <div class="flex justify-between items-center">
                        <div class="text-sm text-gray-600">
                            Menampilkan <span x-text="filteredDoctors.length"></span> dokter
                        </div>
                        <button 
                            @click="clearFilters()"
                            class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                            Hapus Filter
                        </button>
                    </div>
                </div>
            </div>

            <!-- Loading State -->
            <div x-show="loading" class="text-center py-12 fade-in">
                <div class="inline-flex items-center">
                    <svg class="animate-spin -ml-1 mr-3 h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-gray-600 text-lg">Memuat data dokter...</span>
                </div>
            </div>

            <!-- No Results -->
            <div x-show="!loading && filteredDoctors.length === 0" class="text-center py-12 fade-in">
                <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada dokter yang ditemukan</h3>
                <p class="text-gray-600 mb-4">Coba ubah filter atau kata kunci pencarian Anda.</p>
                <button
                    @click="clearFilters()"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 btn-hover">
                    Hapus Filter
                </button>
            </div>

            <!-- Grid Dokter -->
            <div id="doctor-results" class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8" data-aos="fade-up"
                data-aos-delay="200" x-show="!loading && filteredDoctors.length > 0">
                
                <template x-for="doctor in paginatedDoctors" :key="doctor.id">
                    <!-- Kartu Dokter -->
                    <div class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 relative">
                        <!-- Favorite Button -->
                        <button 
                            @click="toggleFavorite(doctor.id)"
                            class="absolute top-3 right-3 z-10 p-2 bg-white rounded-full shadow-md hover:shadow-lg transition-all duration-200"
                            :class="isFavorite(doctor.id) ? 'text-red-500' : 'text-gray-400'">
                            <svg class="w-5 h-5" :class="isFavorite(doctor.id) ? 'fill-current' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </button>

                        <div class="relative overflow-hidden">
                            <img :src="doctor.image" :alt="doctor.name"
                                class="w-full h-60 object-cover group-hover:scale-105 transition-transform duration-500" />
                            
                            <!-- Availability Badge -->
                            <div class="absolute bottom-3 left-3">
                                <span x-show="doctor.available"
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3"></circle>
                                    </svg>
                                    Tersedia
                                </span>
                                <span x-show="!doctor.available"
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3"></circle>
                                    </svg>
                                    Tidak Tersedia
                                </span>
                            </div>
                        </div>
                        
                        <div class="p-5 text-center">
                            <h3 class="text-xl font-semibold text-gray-900 mb-1 group-hover:text-blue-600 transition-colors">
                                <span x-text="doctor.name"></span>
                            </h3>
                            <p class="text-gray-500 text-sm mb-3" x-text="doctor.specialization"></p>
                            
                            <!-- Doctor Info -->
                            <div class="space-y-2 mb-4 text-sm text-gray-600">
                                <div class="flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span x-text="doctor.schedule"></span>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="flex flex-col space-y-2">
                                <a :href="doctor.profile_url"
                                    class="inline-flex items-center justify-center gap-2 rounded-full bg-blue-600 text-white px-5 py-2 text-sm font-medium hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition-all duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Lihat Profil
                                </a>
                                
                                <button 
                                    @click="bookAppointment(doctor)"
                                    :disabled="!doctor.available"
                                    class="inline-flex items-center justify-center gap-2 rounded-full border border-blue-600 text-blue-600 px-5 py-2 text-sm font-medium hover:bg-blue-50 focus:ring-4 focus:ring-blue-200 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span x-text="doctor.available ? 'Buat Janji' : 'Tidak Tersedia'"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Pagination -->
            <div x-show="pagination.totalPages > 1" class="flex justify-center mt-12">
                <nav class="inline-flex rounded-md shadow-sm isolate">
                    <!-- Previous -->
                    <button
                        @click="changePage(pagination.currentPage - 1)"
                        :disabled="pagination.currentPage === 1"
                        class="px-3 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200 pagination-item">
                        Previous
                    </button>
                    
                    <!-- Page Numbers -->
                    <template x-for="page in Math.min(5, pagination.totalPages)" :key="page">
                        <button
                            @click="changePage(page)"
                            :class="pagination.currentPage === page ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'"
                            class="px-3 py-2 border border-gray-300 text-sm font-medium transition-all duration-200 pagination-item">
                            <span x-text="page"></span>
                        </button>
                    </template>
                    
                    <!-- Next -->
                    <button
                        @click="changePage(pagination.currentPage + 1)"
                        :disabled="pagination.currentPage === pagination.totalPages"
                        class="px-3 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200 pagination-item">
                        Next
                    </button>
                </nav>
            </div>
        </div>
        
    
    </section>
</x-layout>

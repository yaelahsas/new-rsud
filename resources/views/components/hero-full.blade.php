<section x-data="heroSearch" class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Background with gradient overlay -->
    <div class="absolute inset-0 z-0">
        <!-- Background gradient -->
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-900"></div>
        
        <!-- Pattern overlay -->
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid)" />
            </svg>
        </div>
        
        <!-- Animated background elements -->
        <div class="absolute top-20 left-10 w-72 h-72 bg-blue-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse"></div>
        <div class="absolute top-40 right-10 w-96 h-96 bg-indigo-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse animation-delay-2000"></div>
        <div class="absolute bottom-20 left-1/2 w-80 h-80 bg-purple-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse animation-delay-4000"></div>
    </div>
    
    <!-- Content container -->
    <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Left side: Text content -->
            <div class="text-center lg:text-left">
                <!-- Badge -->
                <div class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full text-white text-sm font-medium mb-6">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    Pelayanan Kesehatan Terpercaya
                </div>
                
                <!-- Main heading -->
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white leading-tight mb-6">
                    Selamat Datang di <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-200 to-indigo-200">RSUD Genteng</span>
                </h1>
                
                <!-- Subheading -->
                <p class="text-xl text-blue-100 mb-8 max-w-lg mx-auto lg:mx-0">
                    Rumah Sakit Umum Daerah Genteng Banyuwangi berkomitmen memberikan pelayanan kesehatan terbaik dengan mengedepankan profesionalisme, empati, dan teknologi terkini.
                </p>
                
                <!-- Search bar -->
                <div class="max-w-2xl mx-auto lg:mx-0 mb-8">
                    <form @submit.prevent="performSearch()" 
                          class="relative flex items-center bg-white/10 backdrop-blur-md rounded-full shadow-xl overflow-hidden focus-within:ring-2 focus-within:ring-white/30 transition-all duration-300">
                        <div class="absolute left-4">
                            <svg class="w-5 h-5 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input x-model="searchQuery" 
                               type="text" 
                               id="hero-search" 
                               name="hero-search"
                               placeholder="Cari layanan, dokter, atau informasi..." 
                               class="w-full pl-12 pr-32 py-4 bg-transparent text-white placeholder-blue-200 focus:outline-none text-lg">
                        <button type="submit" 
                                class="absolute right-0 top-0 bottom-0 px-8 bg-white text-blue-700 font-semibold hover:bg-blue-50 transition-colors duration-300 rounded-r-full">
                            Cari
                        </button>
                    </form>
                </div>
                
                <!-- CTA buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="https://rsudgenteng.banyuwangikab.go.id/pendaftaran" 
                       target="_blank"
                       class="inline-flex items-center justify-center px-8 py-4 bg-white text-blue-700 font-semibold rounded-full hover:bg-blue-50 transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Daftar Online
                    </a>
                    <a href="https://www.youtube.com/watch?v=pMBiQ3Pt8p0" 
                       target="_blank"
                       class="inline-flex items-center justify-center px-8 py-4 bg-transparent text-white font-semibold border-2 border-white/30 rounded-full hover:bg-white/10 transition-all duration-300 backdrop-blur-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Panduan Pendaftaran
                    </a>
                </div>
            </div>
            
            <!-- Right side: Image/Visual -->
            <div class="relative flex justify-center lg:justify-end">
                <!-- Decorative elements -->
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-blue-500/20 to-transparent rounded-3xl transform rotate-3"></div>
                
                <!-- Image container -->
                <div class="relative z-10">
                    <div class="relative">
                        <!-- Glow effect -->
                        <div class="absolute inset-0 bg-blue-400 rounded-3xl blur-3xl opacity-20 scale-110"></div>
                        
                        <!-- Image -->
                        <img class="relative z-10 w-full max-w-md mx-auto rounded-3xl shadow-2xl object-cover" 
                             alt="Direktur RSUD Genteng" 
                             src="{{ asset('img/dr.sugiyo.png') }}">
                        
                        <!-- Floating badges -->
                        <div class="absolute -top-4 -right-4 bg-white rounded-full shadow-lg p-3 animate-bounce">
                            <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </div>
                        
                        <div class="absolute -bottom-4 -left-4 bg-white rounded-full shadow-lg p-3 animate-bounce animation-delay-1000">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Stats section -->
        <div class="mt-20 grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="text-3xl font-bold text-white mb-2">50+</div>
                <div class="text-blue-200">Dokter Spesialis</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-white mb-2">20+</div>
                <div class="text-blue-200">Layanan Medis</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-white mb-2">24/7</div>
                <div class="text-blue-200">Layanan Darurat</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-white mb-2">15+</div>
                <div class="text-blue-200">Pengalaman Tahun</div>
            </div>
        </div>
    </div>
    
    <!-- Scroll indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-10">
        <div class="animate-bounce">
            <svg class="w-6 h-6 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </div>
</section>

<style>
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    .animation-delay-4000 {
        animation-delay: 4s;
    }
    .animation-delay-1000 {
        animation-delay: 1s;
    }
</style>
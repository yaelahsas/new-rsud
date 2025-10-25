<div id="default-carousel" class="relative w-full h-full" data-carousel="slide">
    <!-- 🔍 Panel Pencarian Dokter -->
    <div
        class="absolute z-40 left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 w-full px-4 sm:px-6 flex justify-center">
        <div class="w-full px-20  rounded-2xl   flex flex-col sm:flex-row items-center gap-3 text-white">

            <!-- Input + Tombol Cari -->
            <div class="flex w-full sm:flex-1 items-center gap-2">
                <input type="text" id="search-doctor" placeholder="Cari nama dokter..."
                    class="w-full rounded-lg bg-white/30 text-white placeholder-white/80
               p-2 sm:p-2.5 md:p-3 text-xs sm:text-sm md:text-base
               focus:ring-2 focus:ring-blue-400 focus:outline-none" />
                <button
                    class="bg-blue-600/40 hover:bg-blue-600/60 border border-blue-400/30 text-white font-semibold
               px-3 sm:px-4 md:px-5 py-1.5 sm:py-2 md:py-2.5
               rounded-lg shadow-md transition-all text-xs sm:text-sm md:text-base whitespace-nowrap">
                    <i class="fas fa-search mr-1"></i> Cari
                </button>
            </div>

            <!-- Tombol Jadwal Dokter -->
            <a href="https://rsudgenteng.banyuwangikab.go.id/medis" target="_blank"
                class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold px-3 md:px-5 py-2 md:py-2.5 rounded-lg text-center transition-all text-sm md:text-base">
                <i class="fas fa-user-md mr-2"></i> Jadwal Dokter
            </a>
        </div>
    </div>
    <!-- Carousel wrapper -->
    <div class="relative h-56 overflow-hidden rounded-lg md:h-96 lg:h-[700px]" data-carousel="static">
        <!-- Item 1 -->
        <div class="hidden duration-700 ease-in-out" data-carousel-item="active">
            <img src="https://rsudgenteng.banyuwangikab.go.id/gambar/profil/Profil-240927-fb6fb2b942.png"
                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 object-cover"
                alt="Profil RSUD Genteng">
        </div>
        <!-- Item 2 -->
        <div class="hidden duration-700 ease-in-out" data-carousel-item>
            <img src="https://rsudgenteng.banyuwangikab.go.id/gambar/profil/Profil-251023-5b16350998.jpg"
                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 object-cover"
                alt="Gunung hijau">
        </div>
        <!-- Item 3 -->
        <div class="hidden duration-700 ease-in-out" data-carousel-item>
            <img src="https://rsudgenteng.banyuwangikab.go.id/gambar/profil/Profil-251023-1051ab6063.jpg"
                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 object-cover"
                alt="Kota malam">
        </div>
        <!-- Item 4 -->
        <div class="hidden duration-700 ease-in-out" data-carousel-item>
            <img src="https://images.unsplash.com/photo-1519125323398-675f0ddb6308?auto=format&fit=crop&w=1920&q=80"
                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 object-cover"
                alt="Danau dan pegunungan">
        </div>
        <!-- Item 5 -->
        <div class="hidden duration-700 ease-in-out" data-carousel-item>
            <img src="https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=1920&q=80"
                class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 object-cover"
                alt="Padang rumput hijau">
        </div>
    </div>

    <!-- Slider indicators -->
    <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
        <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide 1"
            data-carousel-slide-to="0"></button>
        <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2"
            data-carousel-slide-to="1"></button>
        <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3"
            data-carousel-slide-to="2"></button>
        <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 4"
            data-carousel-slide-to="3"></button>
        <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 5"
            data-carousel-slide-to="4"></button>
    </div>

    <!-- Slider controls -->
    <button type="button"
        class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
        data-carousel-prev>
        <span
            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white transition">
            <svg class="w-4 h-4 text-white rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 1 1 5l4 4" />
            </svg>
        </span>
    </button>
    <button type="button"
        class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
        data-carousel-next>
        <span
            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white transition">
            <svg class="w-4 h-4 text-white rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 9 4-4-4-4" />
            </svg>
        </span>
    </button>
</div>

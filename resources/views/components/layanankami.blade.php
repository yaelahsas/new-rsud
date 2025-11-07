<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fadeInUp {
        animation: fadeInUp 0.8s ease-out forwards;
    }
</style>

<!-- Services Section -->
<section class="py-20 ">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 text-blue-900 tracking-wide animate-fadeInUp">
            Layanan Kami
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Service Card -->
            <div
                class="group bg-white rounded-2xl p-8 shadow-md hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border-t-4 border-blue-500 animate-fadeInUp">
                <div
                    class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mb-5 group-hover:bg-blue-600 transition">
                    <i class="fas fa-heartbeat text-blue-600 group-hover:text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-semibold mb-2 text-gray-800">Rawat Jalan</h3>
                <p class="text-gray-600 mb-6 leading-relaxed">
                    Pelayanan medis tanpa perlu menginap dengan berbagai spesialisasi dokter terbaik.
                </p>
                <a href="#"
                    class="inline-flex items-center text-blue-600 font-medium group-hover:text-blue-700 transition">
                    Selengkapnya
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor"
                        class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-300">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
            </div>

            <!-- Service Card 2 -->
            <div
                class="group bg-white rounded-2xl p-8 shadow-md hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border-t-4 border-blue-500 animate-fadeInUp delay-100">
                <div
                    class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mb-5 group-hover:bg-blue-600 transition">
                    <i class="fas fa-hospital text-blue-600 group-hover:text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-semibold mb-2 text-gray-800">Rawat Inap</h3>
                <p class="text-gray-600 mb-6 leading-relaxed">
                    Ruang perawatan nyaman dengan fasilitas modern dan tenaga perawat profesional 24 jam.
                </p>
                <a href="#"
                    class="inline-flex items-center text-blue-600 font-medium group-hover:text-blue-700 transition">
                    Selengkapnya
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor"
                        class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-300">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
            </div>

            <!-- Service Card 3 -->
            <div
                class="group bg-white rounded-2xl p-8 shadow-md hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border-t-4 border-blue-500 animate-fadeInUp delay-200">
                <div
                    class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mb-5 group-hover:bg-blue-600 transition">
                    <i class="fas fa-truck-medical text-blue-600 group-hover:text-white text-2xl"></i>
                </div>
                <h3 class="text-2xl font-semibold mb-2 text-gray-800">IGD 24 Jam</h3>
                <p class="text-gray-600 mb-6 leading-relaxed">
                    Unit gawat darurat siap siaga 24 jam dengan tenaga medis berpengalaman dan peralatan lengkap.
                </p>
                <a href="#"
                    class="inline-flex items-center text-blue-600 font-medium group-hover:text-blue-700 transition">
                    Selengkapnya
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor"
                        class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-300">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>

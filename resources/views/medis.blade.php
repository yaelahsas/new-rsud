<x-layout>
    <section id="doctors" class="py-20 bg-gray-50">
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

            <!-- Pencarian -->
            <div class="max-w-2xl mx-auto mb-10" data-aos="fade-up" data-aos-delay="100">
                <div class="relative">
                    <input type="text" id="search-doctor" placeholder="🔍 Cari dokter..."
                        class="w-full rounded-2xl border border-gray-300 bg-white px-5 py-3 text-gray-700 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 transition duration-300" />
                </div>
            </div>

            <!-- Grid Dokter -->
            <div id="doctor-list" class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8" data-aos="fade-up"
                data-aos-delay="200">
                <!-- Kartu Dokter -->
                <div
                    class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
                    <div class="relative overflow-hidden">
                        <img src="https://rsudgenteng.banyuwangikab.go.id/gambar/dokter/default.jpg"
                            alt="Dr. Ahmad Santoso"
                            class="w-full h-60 object-cover group-hover:scale-105 transition-transform duration-500" />
                    </div>
                    <div class="p-5 text-center">
                        <h3
                            class="text-xl font-semibold text-gray-900 mb-1 group-hover:text-blue-600 transition-colors">
                            dr. Ahmad Santoso, Sp.PD
                        </h3>
                        <p class="text-gray-500 text-sm mb-3">Spesialis Penyakit Dalam</p>
                        <p class="text-gray-600 text-sm mb-4">Jadwal: Senin - Jumat (08.00 - 14.00)</p>
                        <a href="#"
                            class="inline-flex items-center gap-2 rounded-full bg-blue-600 text-white px-5 py-2 text-sm font-medium hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                            Lihat Profil
                        </a>
                    </div>
                </div>

                <!-- Ulangi card sesuai jumlah dokter -->
                <div
                    class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100">
                    <div class="relative overflow-hidden">
                        <img src="https://rsudgenteng.banyuwangikab.go.id/gambar/dokter/default2.jpg"
                            alt="dr. Maria Citra, Sp.A"
                            class="w-full h-60 object-cover group-hover:scale-105 transition-transform duration-500" />
                    </div>
                    <div class="p-5 text-center">
                        <h3
                            class="text-xl font-semibold text-gray-900 mb-1 group-hover:text-blue-600 transition-colors">
                            dr. Maria Citra, Sp.A
                        </h3>
                        <p class="text-gray-500 text-sm mb-3">Spesialis Anak</p>
                        <p class="text-gray-600 text-sm mb-4">Jadwal: Selasa - Sabtu (09.00 - 13.00)</p>
                        <a href="#"
                            class="inline-flex items-center gap-2 rounded-full bg-blue-600 text-white px-5 py-2 text-sm font-medium hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                            Lihat Profil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-layout>

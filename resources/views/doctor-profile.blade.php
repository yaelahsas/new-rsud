<x-layout>
    <!-- SEO Meta Tags with Schema Markup -->
    <title x-text="seoData.title">Profil Dokter - RSUD Genteng</title>
    <meta name="description" x-content="seoData.description" content="Profil lengkap dokter di RSUD Genteng">
    <meta name="keywords" x-content="seoData.keywords" content="dokter, profil, spesialis, RSUD Genteng">
    <meta property="og:title" x-content="seoData.title" content="Profil Dokter - RSUD Genteng">
    <meta property="og:description" x-content="seoData.description" content="Profil lengkap dokter di RSUD Genteng">
    <meta property="og:image" x-content="seoData.ogImage" content="">
    <meta property="og:url" x-content="window.location.href" content="">
    <meta property="og:type" content="profile">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" x-content="seoData.title" content="Profil Dokter - RSUD Genteng">
    <meta name="twitter:description" x-content="seoData.description" content="Profil lengkap dokter di RSUD Genteng">
    <meta name="twitter:image" x-content="seoData.ogImage" content="">
    <link rel="canonical" x-href="window.location.href" href="">

    <!-- Schema.org structured data for Physician -->
    <script type="application/ld+json" x-html="schemaMarkup"></script>

    <!-- Accessibility Styles -->
    <style>
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        .sr-only:focus,
        .focus:not-sr-only:focus {
            position: static;
            width: auto;
            height: auto;
            padding: inherit;
            margin: inherit;
            overflow: visible;
            clip: auto;
            white-space: normal;
        }

        /* High contrast mode support */
        @media (prefers-contrast: high) {
            .bg-blue-600 {
                background-color: #000080;
            }

            .text-blue-600 {
                color: #000080;
            }

            .border-blue-600 {
                border-color: #000080;
            }
        }

        /* Reduced motion support */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        /* Focus indicators */
        *:focus {
            outline: 2px solid #2563eb;
            outline-offset: 2px;
        }

        button:focus,
        a:focus,
        input:focus,
        textarea:focus,
        select:focus {
            outline: 2px solid #2563eb;
            outline-offset: 2px;
        }
    </style>

    <!-- Skip to main content link for accessibility -->
    <a href="#main-content"
        class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-blue-600 text-white px-4 py-2 rounded-md z-50">
        Skip to main content
    </a>

    <div x-data="doctorProfile" x-init="initPage('{{ $slug }}')" class="min-h-screen bg-gray-50" role="main"
        id="main-content">
        <!-- Loading State -->
        <div x-show="loading" class="fixed inset-0 bg-white bg-opacity-90 z-50 flex items-center justify-center"
            role="status" aria-live="polite">
            <div class="text-center">
                <div class="inline-flex items-center">
                    <svg class="animate-spin -ml-1 mr-3 h-12 w-12 text-blue-600" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24" aria-hidden="true">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    <span class="text-gray-600 text-lg">Memuat profil dokter...</span>
                </div>
            </div>
        </div>

        <!-- Error State -->
        <div x-show="error" class="min-h-screen flex items-center justify-center" role="alert">
            <div class="text-center">
                <svg class="mx-auto h-16 w-16 text-red-400 mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Dokter tidak ditemukan</h3>
                <p class="text-gray-600 mb-4">Maaf, dokter yang Anda cari tidak tersedia.</p>
                <a href="/medis"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Kembali ke Daftar Dokter
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div x-show="!loading && !error && doctor">
            <!-- Hero Section -->
            <section
                class="relative bg-gradient-to-br from-blue-700 via-blue-800 to-indigo-900 text-white overflow-hidden rounded-2xl shadow-lg mb-16">
                <div class="absolute inset-0 bg-[url('/images/pattern.svg')] opacity-10"></div>
                <div class="absolute inset-0 bg-black/30 backdrop-blur-sm"></div>

                <div class="relative container mx-auto px-6 py-20 flex flex-col lg:flex-row items-center gap-10"
                   >

                    <!-- Doctor Photo -->
                    <div
                        class="relative w-56 h-56 sm:w-64 sm:h-64 rounded-3xl overflow-hidden shadow-2xl border-4 border-white/30 group transition-all duration-500 hover:scale-105">
                        <img :src="doctor?.image" :alt="`Foto dr. ${doctor?.name}`"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <div
                            class="absolute bottom-3 right-3 bg-emerald-500/90 text-white p-2 rounded-full shadow-md flex items-center justify-center">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Doctor Info -->
                    <div class="flex-1 text-center lg:text-left space-y-6">
                        <div>
                            <h1 id="doctor-name"
                                class="text-4xl sm:text-5xl font-extrabold tracking-tight drop-shadow-md"
                                x-text="doctor?.name"></h1>
                            <p class="text-xl sm:text-2xl text-blue-200 font-medium mt-1"
                                x-text="doctor?.specialization"></p>
                            <p class="text-blue-100 italic text-base sm:text-lg" x-text="doctor?.tagline"></p>
                        </div>

                        <!-- Quick Stats -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
                            <!-- Rating -->
                            <div
                                class="bg-white/10 border border-white/20 rounded-2xl p-5 text-center shadow-sm hover:bg-white/20 transition-all duration-300">
                                <div class="text-3xl mb-2">⭐</div>
                                <div class="font-semibold text-lg" x-text="doctor?.rating ?? '0.0'"></div>
                                <div class="text-sm text-blue-100"><span x-text="doctor?.reviewCount ?? 0"></span>
                                    ulasan</div>
                            </div>

                            <!-- Experience -->
                            <div
                                class="bg-white/10 border border-white/20 rounded-2xl p-5 text-center shadow-sm hover:bg-white/20 transition-all duration-300">
                                <div class="text-3xl mb-2">⏳</div>
                                <div class="font-semibold text-lg" x-text="doctor?.experience ?? '0 thn'"></div>
                                <div class="text-sm text-blue-100">pengalaman</div>
                            </div>

                            <!-- Patients -->
                            <div
                                class="bg-white/10 border border-white/20 rounded-2xl p-5 text-center shadow-sm hover:bg-white/20 transition-all duration-300">
                                <div class="text-3xl mb-2">👥</div>
                                <div class="font-semibold text-lg" x-text="doctor?.patientCount ?? 0"></div>
                                <div class="text-sm text-blue-100">pasien</div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-wrap justify-center lg:justify-start gap-4 mt-8">
                            <button @click="bookAppointment()"
                                class="inline-flex items-center gap-2 bg-white text-blue-700 px-7 py-3 rounded-full font-semibold shadow-md hover:bg-blue-50 transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Buat Janji Temu
                            </button>

                            <button @click="sendMessage()" :aria-label="`Kirim pesan ke dr. ${doctor?.name || '...'}`"
                                class="inline-flex items-center gap-2 bg-blue-500/30 border border-white/20 px-7 py-3 rounded-full font-semibold text-white hover:bg-blue-500/50 transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Kirim Pesan
                            </button>

                            <button @click="toggleFavorite()"
                                :aria-label="isFavorite ? `Hapus simpanan dr. ${doctor?.name}` : `Simpan dr. ${doctor?.name}`"
                                class="inline-flex items-center gap-2 bg-white/10 border border-white/20 px-6 py-3 rounded-full font-semibold text-white hover:bg-white/20 transition-all duration-300">
                                <svg class="w-5 h-5" :class="isFavorite ? 'fill-current text-pink-500' : ''"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                <span x-text="isFavorite ? 'Disimpan' : 'Simpan'"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </section>


            <!-- Biography Section -->
            <section class="py-16 bg-white" aria-labelledby="about-heading">
                <div class="container mx-auto px-4">
                    <div class="max-w-4xl mx-auto">
                        <h2 id="about-heading" class="text-3xl font-bold text-gray-900 mb-8 text-center">Tentang Saya
                        </h2>
                        <div class="prose prose-lg max-w-none text-gray-600 leading-relaxed"
                            x-html="doctor?.biography" role="article"></div>
                    </div>
                </div>
            </section>

            <!-- Credentials & Education Timeline -->
            <section class="py-16 bg-gray-50">
                <div class="container mx-auto px-4">
                    <h2 class="text-3xl font-bold text-gray-900 mb-12 text-center">Pendidikan & Sertifikasi</h2>
                    <div class="max-w-4xl mx-auto">
                        <div class="relative">
                            <!-- Timeline Line -->
                            <div class="absolute left-8 top-0 bottom-0 w-0.5 bg-blue-200"></div>

                            <!-- Timeline Items -->
                            <template x-for="item in doctor?.credentials" :key="item.id">
                                <div class="relative flex items-start mb-8">
                                    <!-- Timeline Dot -->
                                    <div
                                        class="flex-shrink-0 w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center text-white shadow-lg z-10">
                                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z">
                                            </path>
                                        </svg>
                                    </div>

                                    <!-- Content -->
                                    <div class="ml-6 flex-1 bg-white rounded-lg shadow-md p-6">
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                                            <div>
                                                <h3 class="text-xl font-semibold text-gray-900" x-text="item.title">
                                                </h3>
                                                <p class="text-gray-600" x-text="item.institution"></p>
                                            </div>
                                            <div class="text-right mt-2 sm:mt-0">
                                                <p class="text-sm text-gray-500" x-text="item.period"></p>
                                                <p class="text-xs text-blue-600 font-medium" x-text="item.type"></p>
                                            </div>
                                        </div>
                                        <p class="text-gray-700" x-text="item.description"></p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Specializations & Medical Conditions -->
            <section class="py-16 bg-white">
                <div class="container mx-auto px-4">
                    <h2 class="text-3xl font-bold text-gray-900 mb-12 text-center">Spesialisasi & Layanan</h2>

                    <!-- Specializations -->
                    <div class="max-w-6xl mx-auto mb-12">
                        <h3 class="text-xl font-semibold text-gray-800 mb-6">Area Spesialisasi</h3>
                        <div class="flex flex-wrap gap-3">
                            <template x-for="spec in doctor?.specializations" :key="spec">
                                <span
                                    class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span x-text="spec"></span>
                                </span>
                            </template>
                        </div>
                    </div>

                    <!-- Medical Conditions -->
                    <div class="max-w-6xl mx-auto">
                        <h3 class="text-xl font-semibold text-gray-800 mb-6">Kondisi Medis yang Ditangani</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <template x-for="condition in doctor?.medicalConditions" :key="condition">
                                <div
                                    class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                    <svg class="w-5 h-5 text-green-600 mr-3 flex-shrink-0" fill="currentColor"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-gray-700" x-text="condition"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Practice Information -->
            <section class="py-16 bg-gray-50">
                <div class="container mx-auto px-4">
                    <h2 class="text-3xl font-bold text-gray-900 mb-12 text-center">Informasi Praktik</h2>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 max-w-6xl mx-auto">
                        <!-- Location & Map -->
                        <div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-6">Lokasi Praktik</h3>
                            <div class="bg-white rounded-lg shadow-md p-6">
                                <div class="mb-4">
                                    <h4 class="font-semibold text-gray-900" x-text="doctor?.poli.name"></h4>
                                    <p class="text-gray-600" x-text="doctor?.poli.room"></p>
                                    <p class="text-gray-700 mt-2" x-text="doctor?.poli.description"></p>
                                </div>

                                <!-- Interactive Map -->
                                <div class="relative h-64 bg-gray-200 rounded-lg overflow-hidden">
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <div class="text-center">
                                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                </path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            <p class="text-gray-600">Peta Interaktif</p>
                                            <p class="text-sm text-gray-500">RSUD Genteng, Banyuwangi</p>
                                        </div>
                                    </div>
                                    <button @click="openMap()"
                                        class="absolute bottom-4 right-4 bg-blue-600 text-white px-4 py-2 rounded-lg shadow-lg hover:bg-blue-700 transition-colors">
                                        Buka di Google Maps
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Schedule & Contact -->
                        <div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-6">Jadwal Praktik</h3>
                            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                                <template x-for="schedule in doctor?.schedules" :key="schedule.id">
                                    <div
                                        class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                                        <div class="flex items-center">
                                            <div
                                                class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                                                <span class="text-blue-600 font-semibold text-sm"
                                                    x-text="schedule.day.charAt(0)"></span>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900" x-text="schedule.day"></p>
                                                <p class="text-sm text-gray-600" x-text="schedule.poli"></p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-medium text-gray-900" x-text="schedule.time"></p>
                                            <p class="text-sm text-gray-500" x-text="schedule.room"></p>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <!-- Contact Information -->
                            <div class="bg-white rounded-lg shadow-md p-6">
                                <h4 class="font-semibold text-gray-900 mb-4">Informasi Kontak</h4>
                                <div class="space-y-3">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                            </path>
                                        </svg>
                                        <span class="text-gray-700" x-text="doctor?.kontak"></span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <span class="text-gray-700">info@rsudgenteng.go.id</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Insurance Accepted -->
            <section class="py-16 bg-white">
                <div class="container mx-auto px-4">
                    <h2 class="text-3xl font-bold text-gray-900 mb-12 text-center">Asuransi yang Diterima</h2>
                    <div class="max-w-6xl mx-auto">
                        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
                            <template x-for="insurance in doctor?.insurances" :key="insurance">
                                <div
                                    class="bg-gray-50 rounded-lg p-4 flex items-center justify-center h-24 hover:bg-gray-100 transition-colors">
                                    <span class="text-gray-700 font-medium text-center" x-text="insurance"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Patient Testimonials -->
            <section class="py-16 bg-gray-50">
                <div class="container mx-auto px-4">
                    <h2 class="text-3xl font-bold text-gray-900 mb-12 text-center">Testimoni Pasien</h2>

                    <!-- Rating Summary -->
                    <div class="max-w-4xl mx-auto mb-12">
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <div class="flex flex-col md:flex-row items-center justify-between">
                                <div class="text-center md:text-left mb-4 md:mb-0">
                                    <div class="flex items-center justify-center md:justify-start mb-2">
                                        <span class="text-4xl font-bold text-gray-900 mr-2"
                                            x-text="doctor?.rating"></span>
                                        <div class="flex">
                                            <template x-for="i in 5" :key="i">
                                                <svg class="w-6 h-6"
                                                    :class="i <= Math.floor(doctor?.rating) ? 'text-yellow-400' :
                                                        'text-gray-300'"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                    </path>
                                                </svg>
                                            </template>
                                        </div>
                                    </div>
                                    <p class="text-gray-600"><span x-text="doctor?.reviewCount"></span> ulasan</p>
                                </div>

                                <!-- Filter Buttons -->
                                <div class="flex flex-wrap gap-2">
                                    <template x-for="filter in reviewFilters" :key="filter">
                                        <button @click="filterReviews(filter)"
                                            :class="activeReviewFilter === filter ? 'bg-blue-600 text-white' :
                                                'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                                            class="px-4 py-2 rounded-full text-sm font-medium transition-colors"
                                            x-text="filter">
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonials Grid -->
                    <div class="max-w-6xl mx-auto">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <template x-for="review in filteredReviews" :key="review.id">
                                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                                    <div class="flex items-center mb-4">
                                        <img :src="review.avatar" :alt="review.name"
                                            class="w-12 h-12 rounded-full mr-3">
                                        <div>
                                            <h4 class="font-semibold text-gray-900" x-text="review.name"></h4>
                                            <div class="flex items-center">
                                                <div class="flex">
                                                    <template x-for="i in 5" :key="i">
                                                        <svg class="w-4 h-4"
                                                            :class="i <= review.rating ? 'text-yellow-400' : 'text-gray-300'"
                                                            fill="currentColor" viewBox="0 0 20 20">
                                                            <path
                                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                            </path>
                                                        </svg>
                                                    </template>
                                                </div>
                                                <span class="ml-2 text-sm text-gray-500" x-text="review.date"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-gray-700" x-text="review.comment"></p>
                                    <div class="mt-3">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800"
                                            x-text="review.category"></span>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Load More Button -->
                        <div class="text-center mt-8">
                            <button @click="loadMoreReviews()" x-show="hasMoreReviews"
                                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Muat Lebih Banyak
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Q&A Section -->
            <section class="py-16 bg-white">
                <div class="container mx-auto px-4">
                    <h2 class="text-3xl font-bold text-gray-900 mb-12 text-center">Tanya Jawab dengan Dokter</h2>

                    <div class="max-w-4xl mx-auto">
                        <!-- Ask Question Form -->
                        <div class="bg-blue-50 rounded-lg p-6 mb-8">
                            <h3 class="text-xl font-semibold text-gray-900 mb-4">Ajukan Pertanyaan</h3>
                            <form @submit.prevent="submitQuestion()">
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Pertanyaan Anda</label>
                                    <textarea x-model="newQuestion" rows="3"
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-gray-700 focus:border-blue-500 focus:ring focus:ring-blue-200"
                                        placeholder="Tulis pertanyaan Anda di sini..."></textarea>
                                </div>
                                <button type="submit" :disabled="!newQuestion.trim()"
                                    class="bg-blue-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                                    Kirim Pertanyaan
                                </button>
                            </form>
                        </div>

                        <!-- Q&A List -->
                        <div class="space-y-6">
                            <template x-for="qa in qaList" :key="qa.id">
                                <div class="bg-white rounded-lg shadow-md p-6">
                                    <div class="mb-4">
                                        <div class="flex items-center mb-2">
                                            <img :src="qa.patientAvatar" :alt="qa.patientName"
                                                class="w-8 h-8 rounded-full mr-2">
                                            <span class="font-medium text-gray-900" x-text="qa.patientName"></span>
                                            <span class="ml-auto text-sm text-gray-500" x-text="qa.date"></span>
                                        </div>
                                        <p class="text-gray-700" x-text="qa.question"></p>
                                    </div>

                                    <div class="border-l-4 border-blue-600 pl-4">
                                        <div class="flex items-center mb-2">
                                            <img :src="doctor?.image" :alt="doctor?.name"
                                                class="w-8 h-8 rounded-full mr-2">
                                            <span class="font-medium text-gray-900">dr. <span
                                                    x-text="doctor?.name"></span></span>
                                            <span class="ml-auto text-sm text-gray-500" x-text="qa.answerDate"></span>
                                        </div>
                                        <p class="text-gray-700" x-text="qa.answer"></p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Educational Content -->
            <section class="py-16 bg-gray-50">
                <div class="container mx-auto px-4">
                    <h2 class="text-3xl font-bold text-gray-900 mb-12 text-center">Artikel & Konten Edukatif</h2>

                    <div class="max-w-6xl mx-auto">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <template x-for="article in doctor?.articles" :key="article.id">
                                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow cursor-pointer"
                                    @click="openArticle(article)">
                                    <img :src="article.thumbnail" :alt="article.title"
                                        class="w-full h-48 object-cover">
                                    <div class="p-6">
                                        <div class="flex items-center mb-2">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800"
                                                x-text="article.category"></span>
                                            <span class="ml-auto text-sm text-gray-500"
                                                x-text="article.readTime"></span>
                                        </div>
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2" x-text="article.title">
                                        </h3>
                                        <p class="text-gray-600 text-sm line-clamp-3" x-text="article.excerpt"></p>
                                        <div class="mt-4 flex items-center text-sm text-gray-500">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            <span x-text="article.publishedAt"></span>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="text-center mt-8">
                            <a href="/artikel"
                                class="inline-flex items-center px-6 py-3 border border-blue-600 text-base font-medium rounded-md text-blue-600 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Lihat Semua Artikel
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Floating CTA Button -->
            <div class="fixed bottom-8 right-8 z-40">
                <button @click="bookAppointment()"
                    class="bg-blue-600 text-white p-4 rounded-full shadow-lg hover:bg-blue-700 transition-all duration-300 hover:scale-110 group">
                    <svg class="w-6 h-6 group-hover:rotate-12 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span
                        class="absolute right-full mr-3 top-1/2 transform -translate-y-1/2 bg-gray-900 text-white px-3 py-1 rounded-lg text-sm whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity">
                        Buat Janji Temu
                    </span>
                </button>
            </div>
        </div>
</x-layout>

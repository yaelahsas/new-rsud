<x-layout>
    <section x-data="layananPage" x-init="init()" class="min-h-screen bg-gradient-to-br from-blue-50 to-white">
        <!-- Hero Section -->
        <div class="relative bg-gradient-to-r from-blue-600 to-blue-800 text-white overflow-hidden">
            <div class="absolute inset-0 bg-black opacity-10"></div>
            <div class="relative container mx-auto px-4 py-20 md:py-32">
                <div class="text-center max-w-3xl mx-auto">
                    <h1 class="text-4xl md:text-5xl font-bold mb-6 animate-fade-in-up">
                        Layanan Kami
                    </h1>
                    <p class="text-xl md:text-2xl text-blue-100 mb-8 animate-fade-in-up animation-delay-200">
                        Pelayanan kesehatan terpadu dengan fasilitas modern dan tenaga medis profesional
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center animate-fade-in-up animation-delay-400">
                        <button @click="scrollToSection('gawat-darurat')" 
                                class="px-8 py-3 bg-white text-blue-600 rounded-full font-semibold hover:bg-blue-50 transition-all duration-300 transform hover:scale-105 shadow-lg">
                            Gawat Darurat
                        </button>
                        <button @click="scrollToSection('rawat-inap')" 
                                class="px-8 py-3 bg-blue-700 text-white rounded-full font-semibold hover:bg-blue-800 transition-all duration-300 transform hover:scale-105 shadow-lg">
                            Rawat Inap
                        </button>
                        <button @click="scrollToSection('rawat-jalan')" 
                                class="px-8 py-3 bg-blue-700 text-white rounded-full font-semibold hover:bg-blue-800 transition-all duration-300 transform hover:scale-105 shadow-lg">
                            Rawat Jalan
                        </button>
                    </div>
                </div>
            </div>
            <!-- Decorative Elements -->
            <div class="absolute bottom-0 left-0 right-0">
                <svg class="w-full h-20 text-white fill-current" viewBox="0 0 1440 100" preserveAspectRatio="none">
                    <path d="M0,50 C360,100 1080,0 1440,50 L1440,100 L0,100 Z"></path>
                </svg>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="container mx-auto px-4 -mt-10 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-16">
                <template x-for="stat in quickStats" :key="stat.id">
                    <div class="bg-white rounded-xl shadow-lg p-6 text-center transform hover:scale-105 transition-all duration-300">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center"
                             :class="stat.bgColor">
                            <i :class="stat.icon" class="text-2xl" :class="stat.iconColor"></i>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-800 mb-2" x-text="stat.value"></h3>
                        <p class="text-gray-600" x-text="stat.label"></p>
                    </div>
                </template>
            </div>
        </div>

        <!-- Gawat Darurat Section -->
        <section id="gawat-darurat" class="py-20 bg-white">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                        <i class="fas fa-ambulance text-red-500 mr-3"></i>
                        Gawat Darurat 24 Jam
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Unit gawat darurat siaga 24 jam dengan tenaga medis berpengalaman dan peralatan medis lengkap
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <div class="space-y-6">
                            <template x-for="feature in gawatDaruratFeatures" :key="feature.id">
                                <div class="flex items-start space-x-4 group">
                                    <div class="flex-shrink-0 w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center group-hover:bg-red-200 transition-colors">
                                        <i :class="feature.icon" class="text-red-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-800 mb-2" x-text="feature.title"></h3>
                                        <p class="text-gray-600" x-text="feature.description"></p>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="mt-8 p-6 bg-red-50 rounded-xl border border-red-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-lg font-semibold text-red-800 mb-2">Butuh Bantuan Darurat?</h4>
                                    <p class="text-red-600">Hubungi kami segera untuk bantuan medis darurat</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-3xl font-bold text-red-600">119</div>
                                    <div class="text-sm text-red-500">Emergency Hotline</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" 
                             alt="Gawat Darurat" 
                             class="rounded-2xl shadow-2xl w-full">
                        <div class="absolute -bottom-6 -right-6 bg-red-600 text-white rounded-xl p-4 shadow-xl">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center">
                                    <i class="fas fa-clock text-red-600 text-xl"></i>
                                </div>
                                <div>
                                    <div class="font-bold">24/7</div>
                                    <div class="text-sm">Siaga Setiap Saat</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Rawat Inap Section -->
        <section id="rawat-inap" class="py-20 bg-gray-50">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                        <i class="fas fa-hospital text-blue-500 mr-3"></i>
                        Rawat Inap
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Fasilitas rawat inap nyaman dengan berbagai kelas kamar dan perawatan profesional 24 jam
                    </p>
                </div>

                <!-- Room Types -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                    <template x-for="room in roomTypes" :key="room.id">
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition-all duration-300 group">
                            <div class="relative h-48 overflow-hidden">
                                <img :src="room.image" :alt="room.type" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute top-4 right-4 bg-white px-3 py-1 rounded-full text-sm font-semibold"
                                     :class="room.badgeColor" x-text="room.badge"></div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-800 mb-2" x-text="room.type"></h3>
                                <p class="text-gray-600 mb-4" x-text="room.description"></p>
                                <ul class="space-y-2 mb-6">
                                    <template x-for="facility in room.facilities" :key="facility">
                                        <li class="flex items-center text-sm text-gray-600">
                                            <i class="fas fa-check text-green-500 mr-2"></i>
                                            <span x-text="facility"></span>
                                        </li>
                                    </template>
                                </ul>
                                <button @click="showRoomDetails(room)" 
                                        class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                    Lihat Detail
                                </button>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Additional Services -->
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Fasilitas Tambahan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <template x-for="service in inapServices" :key="service.id">
                            <div class="text-center group">
                                <div class="w-20 h-20 mx-auto mb-4 bg-blue-100 rounded-full flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                                    <i :class="service.icon" class="text-blue-600 text-2xl"></i>
                                </div>
                                <h4 class="font-semibold text-gray-800 mb-2" x-text="service.name"></h4>
                                <p class="text-sm text-gray-600" x-text="service.description"></p>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </section>

        <!-- Rawat Jalan Section -->
        <section id="rawat-jalan" class="py-20 bg-white">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                        <i class="fas fa-user-md text-green-500 mr-3"></i>
                        Rawat Jalan
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Pelayanan medis tanpa perlu menginap dengan berbagai spesialisasi dokter terbaik
                    </p>
                </div>

                <!-- Poliklinik Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                    <template x-for="poli in poliklinik" :key="poli.id">
                        <div class="bg-white border border-gray-200 rounded-xl p-6 hover:shadow-xl transition-all duration-300 group">
                            <div class="flex items-center mb-4">
                                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center group-hover:bg-green-200 transition-colors">
                                    <i :class="poli.icon" class="text-green-600 text-2xl"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-bold text-gray-800" x-text="poli.name"></h3>
                                    <p class="text-sm text-gray-600" x-text="poli.schedule"></p>
                                </div>
                            </div>
                            <p class="text-gray-600 mb-4" x-text="poli.description"></p>
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-gray-500">
                                    <i class="fas fa-clock mr-1"></i>
                                    <span x-text="poli.hours"></span>
                                </div>
                                <button @click="showPoliDetails(poli)" 
                                        class="text-green-600 hover:text-green-700 font-medium text-sm">
                                    Detail →
                                </button>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Registration Process -->
                <div class="bg-gradient-to-r from-green-50 to-blue-50 rounded-2xl p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">Cara Pendaftaran</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <template x-for="(step, index) in registrationSteps" :key="step.id">
                            <div class="text-center">
                                <div class="w-16 h-16 mx-auto mb-4 bg-white rounded-full flex items-center justify-center shadow-lg relative">
                                    <span class="text-2xl font-bold text-blue-600" x-text="index + 1"></span>
                                    <div x-show="index < registrationSteps.length - 1" 
                                         class="hidden md:block absolute top-1/2 -right-8 w-8 h-0.5 bg-blue-300"></div>
                                </div>
                                <h4 class="font-semibold text-gray-800 mb-2" x-text="step.title"></h4>
                                <p class="text-sm text-gray-600" x-text="step.description"></p>
                            </div>
                        </template>
                    </div>
                    <div class="text-center mt-8">
                        <button @click="showRegistrationForm()" 
                                class="px-8 py-3 bg-green-600 text-white rounded-full font-semibold hover:bg-green-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                            Daftar Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Modal for Room Details -->
        <div x-show="showModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"
             @click.self="closeModal()">
            <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-95">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-2xl font-bold text-gray-800" x-text="modalTitle"></h3>
                        <button @click="closeModal()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="p-6" x-html="modalContent"></div>
            </div>
        </div>
    </section>

    <style>
        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-in-up {
            animation: fade-in-up 0.8s ease-out forwards;
        }
        
        .animation-delay-200 {
            animation-delay: 200ms;
        }
        
        .animation-delay-400 {
            animation-delay: 400ms;
        }
    </style>
</x-layout>
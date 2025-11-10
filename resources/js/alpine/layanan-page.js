document.addEventListener('alpine:init', () => {
    Alpine.data('layananPage', () => ({
        // Modal state
        showModal: false,
        modalTitle: '',
        modalContent: '',
        
        // Quick stats data
        quickStats: [
            {
                id: 1,
                value: '24/7',
                label: 'Layanan Darurat',
                icon: 'fas fa-ambulance',
                bgColor: 'bg-red-100',
                iconColor: 'text-red-600'
            },
            {
                id: 2,
                value: '150+',
                label: 'Dokter Spesialis',
                icon: 'fas fa-user-md',
                bgColor: 'bg-blue-100',
                iconColor: 'text-blue-600'
            },
            {
                id: 3,
                value: '300+',
                label: 'Tempat Tidur',
                icon: 'fas fa-bed',
                bgColor: 'bg-green-100',
                iconColor: 'text-green-600'
            },
            {
                id: 4,
                value: '50+',
                label: 'Poliklinik',
                icon: 'fas fa-hospital',
                bgColor: 'bg-purple-100',
                iconColor: 'text-purple-600'
            }
        ],
        
        // Gawat Darurat features
        gawatDaruratFeatures: [
            {
                id: 1,
                title: 'Tim Medis Siaga 24 Jam',
                description: 'Dokter dan perawat berpengalaman siap melayani pasien darurat setiap saat',
                icon: 'fas fa-user-nurse'
            },
            {
                id: 2,
                title: 'Peralatan Medis Lengkap',
                description: 'Peralatan canggih untuk penanganan kasus darurat yang komprehensif',
                icon: 'fas fa-heartbeat'
            },
            {
                id: 3,
                title: 'Ambulans Siaga',
                description: 'Fleet ambulans modern untuk evakuasi dan transport medis darurat',
                icon: 'fas fa-ambulance'
            },
            {
                id: 4,
                title: 'Unit Gawat Darurat Terpadu',
                description: 'UGD dengan triage system untuk prioritas penanganan pasien',
                icon: 'fas fa-clinic-medical'
            }
        ],
        
        // Room types for Rawat Inap
        roomTypes: [
            {
                id: 1,
                type: 'Kelas VIP',
                badge: 'Premium',
                badgeColor: 'bg-yellow-100 text-yellow-800',
                image: 'https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                description: 'Kamar premium dengan fasilitas lengkap dan privasi maksimal',
                facilities: [
                    'Tempat tidur premium',
                    'AC & TV LED',
                    'Kamar mandi dalam',
                    'Sofa untuk pengunjung',
                    'Lemari es & minibar',
                    'Wi-Fi gratis'
                ]
            },
            {
                id: 2,
                type: 'Kelas I',
                badge: 'Comfort',
                badgeColor: 'bg-blue-100 text-blue-800',
                image: 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                description: 'Kamar nyaman dengan fasilitas standar tinggi',
                facilities: [
                    'Tempat tidur nyaman',
                    'AC & TV',
                    'Kamar mandi dalam',
                    'Kursi pengunjung',
                    'Wi-Fi gratis'
                ]
            },
            {
                id: 3,
                type: 'Kelas III',
                badge: 'Ekonomis',
                badgeColor: 'bg-green-100 text-green-800',
                image: 'https://images.unsplash.com/photo-1587854692152-cbe640db2547?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80',
                description: 'Kamar ekonomis dengan fasilitas dasar yang memadai',
                facilities: [
                    'Tempat tidur standar',
                    'Kipas angin',
                    'Kamar mandi bersama',
                    'Loker pribadi'
                ]
            }
        ],
        
        // Additional services for Rawat Inap
        inapServices: [
            {
                id: 1,
                name: 'Layanan Makan',
                description: 'Menu nutrisi terpersonalisasi',
                icon: 'fas fa-utensils'
            },
            {
                id: 2,
                name: 'Laundry',
                description: 'Cuci dan setrika pakaian',
                icon: 'fas fa-tshirt'
            },
            {
                id: 3,
                name: 'Pharmacy 24/7',
                description: 'Apotek siaga setiap saat',
                icon: 'fas fa-pills'
            },
            {
                id: 4,
                name: 'WiFi Gratis',
                description: 'Internet cepat untuk pasien',
                icon: 'fas fa-wifi'
            }
        ],
        
        // Poliklinik data
        poliklinik: [
            {
                id: 1,
                name: 'Poliklinik Penyakit Dalam',
                schedule: 'Senin - Sabtu',
                hours: '08:00 - 14:00',
                description: 'Pelayanan kesehatan untuk penyakit dalam dan konsultasi medis umum',
                icon: 'fas fa-stethoscope'
            },
            {
                id: 2,
                name: 'Poliklinik Anak',
                schedule: 'Senin - Sabtu',
                hours: '08:00 - 14:00',
                description: 'Pelayanan kesehatan untuk anak dan vaksinasi',
                icon: 'fas fa-baby'
            },
            {
                id: 3,
                name: 'Poliklinik Kandungan',
                schedule: 'Senin - Sabtu',
                hours: '08:00 - 14:00',
                description: 'Pelayanan kesehatan untuk ibu hamil dan kandungan',
                icon: 'fas fa-female'
            },
            {
                id: 4,
                name: 'Poliklinik Bedah',
                schedule: 'Senin - Jumat',
                hours: '08:00 - 14:00',
                description: 'Konsultasi dan tindakan bedah minor dan mayor',
                icon: 'fas fa-procedures'
            },
            {
                id: 5,
                name: 'Poliklinik Jantung',
                schedule: 'Senin - Sabtu',
                hours: '08:00 - 14:00',
                description: 'Pemeriksaan dan pengobatan penyakit jantung',
                icon: 'fas fa-heartbeat'
            },
            {
                id: 6,
                name: 'Poliklinik Mata',
                schedule: 'Senin - Sabtu',
                hours: '08:00 - 14:00',
                description: 'Pemeriksaan mata dan pengobatan penyakit mata',
                icon: 'fas fa-eye'
            }
        ],
        
        // Registration steps
        registrationSteps: [
            {
                id: 1,
                title: 'Daftar Online',
                description: 'Isi formulir pendaftaran melalui website atau aplikasi'
            },
            {
                id: 2,
                title: 'Verifikasi Data',
                description: 'Konfirmasi data dan jadwal kunjungan Anda'
            },
            {
                id: 3,
                title: 'Datang ke Lokasi',
                description: 'Hadir 15 menit sebelum jadwal untuk registrasi ulang'
            },
            {
                id: 4,
                title: 'Periksa Dokter',
                description: 'Dapatkan pelayanan medis dari dokter spesialis'
            }
        ],
        
        // Initialize
        init() {
            // Add smooth scroll behavior
            document.documentElement.style.scrollBehavior = 'smooth';
        },
        
        // Scroll to section
        scrollToSection(sectionId) {
            const element = document.getElementById(sectionId);
            if (element) {
                element.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        },
        
        // Show room details modal
        showRoomDetails(room) {
            this.modalTitle = room.type;
            
            let facilitiesHtml = room.facilities.map(facility => 
                `<li class="flex items-center text-gray-600">
                    <i class="fas fa-check text-green-500 mr-2"></i>
                    ${facility}
                </li>`
            ).join('');
            
            this.modalContent = `
                <div class="space-y-4">
                    <img src="${room.image}" alt="${room.type}" class="w-full h-64 object-cover rounded-lg">
                    <div>
                        <h4 class="text-xl font-semibold text-gray-800 mb-2">${room.type}</h4>
                        <p class="text-gray-600 mb-4">${room.description}</p>
                        <h5 class="font-semibold text-gray-800 mb-2">Fasilitas:</h5>
                        <ul class="space-y-2">
                            ${facilitiesHtml}
                        </ul>
                    </div>
                    <div class="pt-4 border-t border-gray-200">
                        <button onclick="window.location.href='/booking?room=${room.type}'" 
                                class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition-colors">
                            Pesan Kamar ${room.type}
                        </button>
                    </div>
                </div>
            `;
            
            this.showModal = true;
        },
        
        // Show poli details modal
        showPoliDetails(poli) {
            this.modalTitle = poli.name;
            
            this.modalContent = `
                <div class="space-y-4">
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="${poli.icon} text-green-600 text-2xl"></i>
                        </div>
                        <div>
                            <h4 class="text-xl font-semibold text-gray-800">${poli.name}</h4>
                            <p class="text-gray-600">${poli.schedule}</p>
                        </div>
                    </div>
                    <div>
                        <h5 class="font-semibold text-gray-800 mb-2">Deskripsi:</h5>
                        <p class="text-gray-600">${poli.description}</p>
                    </div>
                    <div>
                        <h5 class="font-semibold text-gray-800 mb-2">Jadwal Layanan:</h5>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-gray-700"><i class="fas fa-calendar mr-2"></i>${poli.schedule}</p>
                            <p class="text-gray-700"><i class="fas fa-clock mr-2"></i>${poli.hours}</p>
                        </div>
                    </div>
                    <div class="pt-4 border-t border-gray-200">
                        <button onclick="window.location.href='/medis?poli=${encodeURIComponent(poli.name)}'" 
                                class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition-colors">
                            Daftar ke ${poli.name}
                        </button>
                    </div>
                </div>
            `;
            
            this.showModal = true;
        },
        
        // Show registration form
        showRegistrationForm() {
            this.modalTitle = 'Pendaftaran Online';
            
            this.modalContent = `
                <form class="space-y-4" onsubmit="handleRegistration(event)">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nomor HP</label>
                        <input type="tel" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Layanan</label>
                        <select required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Pilih Layanan --</option>
                            <option value="rawat-jalan">Rawat Jalan</option>
                            <option value="rawat-inap">Rawat Inap</option>
                            <option value="gawat-darurat">Gawat Darurat</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Keluhan</label>
                        <textarea rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                    <div class="pt-4 border-t border-gray-200">
                        <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition-colors">
                            Daftar Sekarang
                        </button>
                    </div>
                </form>
            `;
            
            this.showModal = true;
        },
        
        // Close modal
        closeModal() {
            this.showModal = false;
            this.modalTitle = '';
            this.modalContent = '';
        }
    }));
});

// Global function for form submission
window.handleRegistration = function(event) {
    event.preventDefault();
    alert('Pendaftaran berhasil! Kami akan menghubungi Anda segera.');
    Alpine.store('app').showNotification('Pendaftaran berhasil! Kami akan menghubungi Anda segera.', 'success');
    Alpine.data('layananPage').closeModal();
};
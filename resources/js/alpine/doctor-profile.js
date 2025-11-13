document.addEventListener("alpine:init", () => {
    Alpine.data("doctorProfile", () => ({
        doctor: null,
        loading: true,
        error: false,
        isFavorite: false,

        // Reviews
        reviews: [],
        filteredReviews: [],
        reviewFilters: [
            "Semua",
            "Profesionalisme",
            "Komunikasi",
            "Kepedulian",
            "Fasilitas",
        ],
        activeReviewFilter: "Semua",
        hasMoreReviews: true,

        // Q&A
        qaList: [],
        newQuestion: "",

        // SEO Data
        seoData: {
            title: "Profil Dokter - RSUD Genteng",
            description: "Profil lengkap dokter di RSUD Genteng",
            keywords: "dokter, profil, spesialis, RSUD Genteng",
            ogImage: "",
        },

        // Schema markup
        schemaMarkup: "",

        initPage(doctorSlug) {
            this.loadDoctorProfile(doctorSlug);
            this.checkFavoriteStatus(doctorSlug);
        },

        async loadDoctorProfile(doctorSlug) {
            this.loading = true;
            this.error = false;

            try {
                console.log("Doctor Slug:", doctorSlug);

                const response = await fetch(`/api/doctor/${doctorSlug}`);
                const data = await response.json();

                if (data.success) {
                    this.doctor = this.enrichDoctorData(data.doctor);
                    this.loadReviews(data.doctor.id);
                    this.loadQA(data.doctor.id);
                    this.loadArticles(data.doctor.id);
                    this.updateSEO();
                    this.generateSchemaMarkup();
                } else {
                    this.error = true;
                }
            } catch (error) {
                console.error("Error loading doctor profile:", error);
                this.error = true;
            } finally {
                this.loading = false;
            }
        },

        enrichDoctorData(doctor) {
            return {
                ...doctor,
                tagline: this.generateTagline(doctor.specialization),
                rating: 4.8,
                reviewCount: 127,
                experience: this.calculateExperience(doctor.created_at),
                patientCount: Math.floor(Math.random() * 2000) + 500,
                biography: this.generateBiography(doctor),
                credentials: this.generateCredentials(doctor),
                specializations: this.generateSpecializations(
                    doctor.specialization
                ),
                medicalConditions: this.generateMedicalConditions(
                    doctor.specialization
                ),
                insurances: [
                    "BPJS Kesehatan",
                    "Asuransi Jiwasraya",
                    "Asuransi Bumiputera",
                    "Asuransi Allianz",
                    "Asuransi Astra",
                    "Asuransi Prudential",
                ],
            };
        },

        generateTagline(specialization) {
            const taglines = {
                "Spesialis Penyakit Dalam":
                    "Melayani dengan hati, menyembuhkan dengan ilmu",
                "Spesialis Anak": "Anak sehat, orang tua bahagia",
                "Spesialis Jantung": "Jaga jantung Anda, jaga masa depan",
                "Spesialis Kulit": "Kulit sehat, percaya diri meningkat",
                "Spesialis Mata": "Lihat dunia dengan lebih jelas",
                "Spesialis Bedah": "Tangan terampil, kesembuhan pasti",
                "Spesialis Kandungan":
                    "Melayani ibu dan anak dengan kasih sayang",
                "Spesialis Saraf": "Mengatasi masalah saraf dengan tepat",
            };

            return taglines[specialization] || "Melayani dengan sepenuh hati";
        },

        generateBiography(doctor) {
            const biographies = {
                "Spesialis Penyakit Dalam": `
                    <p>Saya adalah seorang dokter spesialis penyakit dalam dengan pengalaman lebih dari 10 tahun dalam melayani pasien dengan berbagai kondisi medis kompleks. Saya berkomitmen untuk memberikan pelayanan terbaik dengan pendekatan holistik yang memperhatikan aspek fisik, mental, dan emosional pasien.</p>
                    <p class="mt-4">Selama karir saya, saya telah menangani ribuan kasus mulai dari penyakit umum hingga kondisi medis yang jarang terjadi. Saya percaya bahwa komunikasi yang baik dengan pasien adalah kunci keberhasilan pengobatan, dan saya selalu berusaha menjelaskan kondisi medis dengan bahasa yang mudah dipahami.</p>
                    <p class="mt-4">Saya terus mengikuti perkembangan medis terkini melalui berbagai seminar dan pelatihan untuk memastikan pasien mendapatkan perawatan yang paling update dan efektif.</p>
                `,
                "Spesialis Anak": `
                    <p>Sebagai dokter spesialis anak, saya memiliki passion besar dalam melayani kesehatan anak-anak dari usia bayi hingga remaja. Saya memahami bahwa setiap anak adalah unik dan membutuhkan pendekatan yang berbeda dalam perawatan medis.</p>
                    <p class="mt-4">Dengan pengalaman lebih dari 8 tahun, saya telah membantu ribuan orang tua dalam menjaga kesehatan anak-anak mereka. Saya percaya bahwa pendidikan kesehatan untuk orang tua sama pentingnya dengan pengobatan itu sendiri.</p>
                    <p class="mt-4">Saya selalu berusaha menciptakan lingkungan yang ramah dan tidak menakutkan bagi anak-anak saat mereka berkunjung untuk pemeriksaan, karena saya tahu bahwa pengalaman medis yang positif di masa kecil akan membentuk sikap mereka terhadap kesehatan di masa depan.</p>
                `,
                default: `
                    <p>Saya adalah seorang dokter profesional yang berdedikasi untuk memberikan pelayanan kesehatan terbaik bagi pasien. Dengan pengalaman bertahun-tahun di bidang medis, saya telah mengembangkan keahlian dalam mendiagnosis dan mengobati berbagai kondisi medis.</p>
                    <p class="mt-4">Saya percaya pada pendekatan pasien-sentris di mana setiap pasien mendapat perhatian penuh dan perawatan yang dipersonalisasi. Komunikasi yang jelas dan empati adalah fondasi dari praktik medis saya.</p>
                    <p class="mt-4">Saya terus memperbarui pengetahuan medis saya melalui pendidikan berkelanjutan dan pelatihan untuk memastikan pasien mendapatkan perawatan yang paling modern dan efektif.</p>
                `,
            };

            return biographies[doctor.specialization] || biographies.default;
        },

        generateCredentials(doctor) {
            const currentYear = new Date().getFullYear();
            const baseYear = currentYear - 15;

            return [
                {
                    id: 1,
                    title: "Dokter Spesialis",
                    institution: "Universitas Airlangga",
                    period: `${baseYear - 4} - ${baseYear}`,
                    type: "Pendidikan Spesialis",
                    description:
                        "Menyelesaikan pendidikan spesialis dengan predikat cum laude",
                },
                {
                    id: 2,
                    title: "Dokter Umum",
                    institution: "Universitas Brawijaya",
                    period: `${baseYear - 9} - ${baseYear - 4}`,
                    type: "Pendidikan Sarjana",
                    description: "Lulus dengan predikat sangat memuaskan",
                },
                {
                    id: 3,
                    title: "Sertifikasi Kompetensi",
                    institution: "Kolegium Dokter Spesialis Indonesia",
                    period: `${baseYear}`,
                    type: "Sertifikasi",
                    description:
                        "Tersertifikasi sebagai dokter spesialis yang kompeten",
                },
                {
                    id: 4,
                    title: "Pelatihan Lanjutan",
                    institution: "Mayo Clinic, USA",
                    period: `${baseYear + 1}`,
                    type: "Pelatihan",
                    description:
                        "Mengikuti pelatihan lanjutan dalam teknologi medis terkini",
                },
            ];
        },

        generateSpecializations(specialization) {
            const specs = {
                "Spesialis Penyakit Dalam": [
                    "Diabetes Mellitus",
                    "Hipertensi",
                    "Penyakit Jantung",
                    "Penyakit Paru",
                    "Gangguan Pencernaan",
                    "Penyakit Ginjal",
                    "Penyakit Autoimun",
                ],
                "Spesialis Anak": [
                    "Kesehatan Bayi",
                    "Tumbuh Kembang Anak",
                    "Imunisasi Anak",
                    "Penyakit Infeksi Anak",
                    "Alergi Anak",
                    "Gizi Anak",
                    "Penyakit Kronis Anak",
                ],
                "Spesialis Jantung": [
                    "Penyakit Jantung Koroner",
                    "Gagal Jantung",
                    "Aritmia",
                    "Penyakit Katup Jantung",
                    "Hipertensi",
                    "Pemeriksaan Jantung",
                    "Rehabilitasi Jantung",
                ],
                default: [
                    "Konsultasi Umum",
                    "Pemeriksaan Fisik",
                    "Diagnosis Penyakit",
                    "Pengobatan Medis",
                    "Pencegahan Penyakit",
                    "Edukasi Kesehatan",
                    "Follow-up Pasien",
                ],
            };

            return specs[specialization] || specs.default;
        },

        generateMedicalConditions(specialization) {
            const conditions = {
                "Spesialis Penyakit Dalam": [
                    "Diabetes Tipe 1 dan 2",
                    "Hipertensi Esensial",
                    "Stroke Iskemik",
                    "COPD",
                    "Maag dan GERD",
                    "Hepatitis Kronis",
                    "Lupus dan Penyakit Autoimun Lainnya",
                ],
                "Spesialis Anak": [
                    "Demam pada Anak",
                    "Batuk dan Pilek",
                    "Diare Akut",
                    "Alergi Makanan",
                    "Asma Anak",
                    "Infeksi Telinga",
                    "Eksim pada Anak",
                ],
                "Spesialis Jantung": [
                    "Serangan Jantung",
                    "Angina Pectoris",
                    "Fibrilasi Atrium",
                    "Stenosis Aorta",
                    "Kardiomiopati",
                    "Penyakit Arteri Koroner",
                    "Hipertrofi Ventrikel",
                ],
                default: [
                    "Infeksi Saluran Pernapasan",
                    "Sakit Kepala",
                    "Nyeri Otot",
                    "Masalah Pencernaan",
                    "Kelelahan Kronis",
                    "Gangguan Tidur",
                    "Stres dan Kecemasan",
                ],
            };

            return conditions[specialization] || conditions.default;
        },

        calculateExperience(createdAt) {
            const startYear = new Date(createdAt).getFullYear();
            const currentYear = new Date().getFullYear();
            const years = currentYear - startYear;
            return `${years} tahun`;
        },

        async loadReviews(doctorId) {
            // Mock data for reviews
            this.reviews = [
                {
                    id: 1,
                    name: "Ahmad Susanto",
                    avatar: "https://ui-avatars.com/api/?name=Ahmad+Susanto&background=0D8ABC&color=fff",
                    rating: 5,
                    date: "2 minggu yang lalu",
                    comment:
                        "Dokter sangat profesional dan ramah. Penjelasannya detail dan mudah dipahami. Pelayanan sangat memuaskan!",
                    category: "Profesionalisme",
                },
                {
                    id: 2,
                    name: "Siti Nurhaliza",
                    avatar: "https://ui-avatars.com/api/?name=Siti+Nurhaliza&background=0D8ABC&color=fff",
                    rating: 4,
                    date: "1 bulan yang lalu",
                    comment:
                        "Komunikasi dengan pasien sangat baik. Dokter sabar dalam menjawab semua pertanyaan saya.",
                    category: "Komunikasi",
                },
                {
                    id: 3,
                    name: "Budi Santoso",
                    avatar: "https://ui-avatars.com/api/?name=Budi+Santoso&background=0D8ABC&color=fff",
                    rating: 5,
                    date: "1 bulan yang lalu",
                    comment:
                        "Dokter sangat peduli dengan kondisi pasien. Memberikan perhatian khusus dan solusi yang tepat.",
                    category: "Kepedulian",
                },
                {
                    id: 4,
                    name: "Dewi Lestari",
                    avatar: "https://ui-avatars.com/api/?name=Dewi+Lestari&background=0D8ABC&color=fff",
                    rating: 4,
                    date: "2 bulan yang lalu",
                    comment:
                        "Fasilitas rumah sakit baik dan dokter sangat kompeten. Pelayanan cepat dan efisien.",
                    category: "Fasilitas",
                },
                {
                    id: 5,
                    name: "Rudi Hermawan",
                    avatar: "https://ui-avatars.com/api/?name=Rudi+Hermawan&background=0D8ABC&color=fff",
                    rating: 5,
                    date: "3 bulan yang lalu",
                    comment:
                        "Pengalaman berobat yang sangat menyenangkan. Dokter ramah dan memberikan solusi yang efektif.",
                    category: "Profesionalisme",
                },
                {
                    id: 6,
                    name: "Maya Sari",
                    avatar: "https://ui-avatars.com/api/?name=Maya+Sari&background=0D8ABC&color=fff",
                    rating: 4,
                    date: "3 bulan yang lalu",
                    comment:
                        "Dokter sangat teliti dalam pemeriksaan. Memberikan penjelasan yang jelas tentang kondisi saya.",
                    category: "Profesionalisme",
                },
            ];

            this.filteredReviews = this.reviews;
        },

        filterReviews(filter) {
            this.activeReviewFilter = filter;

            if (filter === "Semua") {
                this.filteredReviews = this.reviews;
            } else {
                this.filteredReviews = this.reviews.filter(
                    (review) => review.category === filter
                );
            }
        },

        loadMoreReviews() {
            // Simulate loading more reviews
            setTimeout(() => {
                this.hasMoreReviews = false;
            }, 1000);
        },

        async loadQA(doctorId) {
            // Mock data for Q&A
            this.qaList = [
                {
                    id: 1,
                    patientName: "Andi Wijaya",
                    patientAvatar:
                        "https://ui-avatars.com/api/?name=Andi+Wijaya&background=28a745&color=fff",
                    question:
                        "Apakah saya perlu puasa sebelum pemeriksaan darah rutin?",
                    date: "1 minggu yang lalu",
                    answer: "Untuk pemeriksaan darah rutin, sebaiknya Anda puasa 8-12 jam sebelum pengambilan sampel darah. Ini terutama penting untuk pemeriksaan gula darah dan kolesterol. Namun, Anda tetap diperbolehkan minum air putih.",
                    answerDate: "6 hari yang lalu",
                },
                {
                    id: 2,
                    patientName: "Ratna Sari",
                    patientAvatar:
                        "https://ui-avatars.com/api/?name=Ratna+Sari&background=28a745&color=fff",
                    question:
                        "Berapa sering saya harus melakukan pemeriksaan kesehatan rutin?",
                    date: "2 minggu yang lalu",
                    answer: "Untuk orang dewasa sehat, disarankan melakukan pemeriksaan kesehatan rutin setahun sekali. Namun, jika Anda memiliki kondisi medis tertentu atau faktor risiko, pemeriksaan mungkin perlu dilakukan lebih sering sesuai anjuran dokter.",
                    answerDate: "1 minggu yang lalu",
                },
                {
                    id: 3,
                    patientName: "Hendra Kusuma",
                    patientAvatar:
                        "https://ui-avatars.com/api/?name=Hendra+Kusuma&background=28a745&color=fff",
                    question:
                        "Apakah gejala-gejala yang perlu diwaspadai untuk penyakit jantung?",
                    date: "3 minggu yang lalu",
                    answer: "Gejala penyakit jantung yang perlu diwaspadai meliputi nyeri dada yang bisa menyebar ke lengan atau leher, sesak napas, jantung berdebar, kelelahan yang tidak biasa, dan pusing. Jika mengalami gejala ini, segera konsultasikan dengan dokter.",
                    answerDate: "2 minggu yang lalu",
                },
            ];
        },

        async loadArticles(doctorId) {
            // Mock data for articles
            this.doctor.articles = [
                {
                    id: 1,
                    title: "Pentingnya Deteksi Dini Diabetes",
                    excerpt:
                        "Diabetes adalah penyakit kronis yang dapat menyebabkan komplikasi serius jika tidak ditangani dengan baik. Deteksi dini sangat penting untuk mencegah perkembangan penyakit.",
                    thumbnail: "https://placehold.co/400x300",
                    category: "Kesehatan",
                    readTime: "5 min",
                    publishedAt: "2 minggu yang lalu",
                    url: "/artikel/deteksi-dini-diabetes",
                },
                {
                    id: 2,
                    title: "Tips Menjaga Kesehatan Jantung",
                    excerpt:
                        "Jantung adalah organ vital yang perlu dijaga kesehatannya. Ada beberapa cara sederhana yang dapat dilakukan untuk menjaga kesehatan jantung.",
                    thumbnail: "https://placehold.co/400x300",
                    category: "Kesehatan",
                    readTime: "7 min",
                    publishedAt: "1 bulan yang lalu",
                    url: "/artikel/kesehatan-jantung",
                },
                {
                    id: 3,
                    title: "Mengenal Lebih Dekat Hipertensi",
                    excerpt:
                        'Hipertensi atau tekanan darah tinggi sering disebut sebagai "silent killer" karena tidak menunjukkan gejala yang jelas namun dapat menyebabkan komplikasi serius.',
                    thumbnail: "https://placehold.co/400x300",
                    category: "Penyakit",
                    readTime: "6 min",
                    publishedAt: "1 bulan yang lalu",
                    url: "/artikel/hipertensi",
                },
            ];
        },

        checkFavoriteStatus(doctorSlug) {
            const favorites = JSON.parse(
                localStorage.getItem("favoriteDoctors") || "[]"
            );
            this.isFavorite = favorites.includes(doctorSlug);
        },

        toggleFavorite() {
            const favorites = JSON.parse(
                localStorage.getItem("favoriteDoctors") || "[]"
            );
            const index = favorites.indexOf(this.doctor.slug);

            if (index > -1) {
                favorites.splice(index, 1);
                this.isFavorite = false;
            } else {
                favorites.push(this.doctor.slug);
                this.isFavorite = true;
            }

            localStorage.setItem("favoriteDoctors", JSON.stringify(favorites));
        },

        bookAppointment() {
            // Store selected doctor for booking
            localStorage.setItem("selectedDoctor", JSON.stringify(this.doctor));

            // Navigate to booking page
            window.location.href = "/booking";
        },

        sendMessage() {
            // Store selected doctor for messaging
            localStorage.setItem("selectedDoctor", JSON.stringify(this.doctor));

            // Navigate to messaging page
            window.location.href = "/message";
        },

        openMap() {
            // Open Google Maps with RSUD Genteng location
            window.open(
                "https://maps.google.com/?q=RSUD+Genteng+Banyuwangi",
                "_blank"
            );
        },

        openArticle(article) {
            window.open(article.url, "_blank");
        },

        async submitQuestion() {
            if (!this.newQuestion.trim()) return;

            // Add new question to the list
            const newQA = {
                id: this.qaList.length + 1,
                patientName: "Anda",
                patientAvatar:
                    "https://ui-avatars.com/api/?name=Anda&background=28a745&color=fff",
                question: this.newQuestion,
                date: "Baru saja",
                answer: "Terima kasih atas pertanyaan Anda. Dokter akan segera memberikan jawaban melalui sistem pesan atau Anda dapat langsung konsultasi saat janji temu.",
                answerDate: "Menunggu jawaban",
            };

            this.qaList.unshift(newQA);
            this.newQuestion = "";

            // Show success message
            this.showNotification("Pertanyaan Anda telah terkirim!");
        },

        showNotification(message) {
            // Create notification element
            const notification = document.createElement("div");
            notification.className =
                "fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50";
            notification.textContent = message;

            document.body.appendChild(notification);

            // Remove after 3 seconds
            setTimeout(() => {
                notification.remove();
            }, 3000);
        },

        updateSEO() {
            if (!this.doctor) return;

            this.seoData = {
                title: `dr. ${this.doctor.name} - ${this.doctor.specialization} | RSUD Genteng`,
                description: `Profil dr. ${this.doctor.name}, spesialis ${this.doctor.specialization} di RSUD Genteng. ${this.doctor.tagline}`,
                keywords: `${this.doctor.name}, ${this.doctor.specialization}, dokter, RSUD Genteng, Banyuwangi`,
                ogImage: this.doctor.image,
            };

            // Update page title
            document.title = this.seoData.title;

            // Update meta description
            const metaDescription = document.querySelector(
                'meta[name="description"]'
            );
            if (metaDescription) {
                metaDescription.setAttribute(
                    "content",
                    this.seoData.description
                );
            }

            // Update meta keywords
            const metaKeywords = document.querySelector(
                'meta[name="keywords"]'
            );
            if (metaKeywords) {
                metaKeywords.setAttribute("content", this.seoData.keywords);
            }

            // Update Open Graph tags
            const ogTitle = document.querySelector('meta[property="og:title"]');
            if (ogTitle) {
                ogTitle.setAttribute("content", this.seoData.title);
            }

            const ogDescription = document.querySelector(
                'meta[property="og:description"]'
            );
            if (ogDescription) {
                ogDescription.setAttribute("content", this.seoData.description);
            }

            const ogImage = document.querySelector('meta[property="og:image"]');
            if (ogImage) {
                ogImage.setAttribute("content", this.seoData.ogImage);
            }

            // Update canonical URL
            const canonical = document.querySelector('link[rel="canonical"]');
            if (canonical) {
                canonical.setAttribute("href", window.location.href);
            } else {
                const link = document.createElement("link");
                link.rel = "canonical";
                link.href = window.location.href;
                document.head.appendChild(link);
            }
        },

        generateSchemaMarkup() {
            if (!this.doctor) return;

            const schema = {
                "@context": "https://schema.org",
                "@type": "Physician",
                name: this.doctor.name,
                medicalSpecialty: this.doctor.specialization,
                description: this.doctor.tagline,
                image: this.doctor.image,
                telephone: this.doctor.kontak,
                address: {
                    "@type": "PostalAddress",
                    streetAddress: "Jl. Dr. Soetomo No. 1",
                    addressLocality: "Banyuwangi",
                    addressRegion: "Jawa Timur",
                    postalCode: "68416",
                    addressCountry: "ID",
                },
                hospital: {
                    "@type": "Hospital",
                    name: "RSUD Genteng",
                    address: {
                        "@type": "PostalAddress",
                        streetAddress: "Jl. Dr. Soetomo No. 1",
                        addressLocality: "Banyuwangi",
                        addressRegion: "Jawa Timur",
                        postalCode: "68416",
                        addressCountry: "ID",
                    },
                },
                aggregateRating: {
                    "@type": "AggregateRating",
                    ratingValue: this.doctor.rating,
                    reviewCount: this.doctor.reviewCount,
                    bestRating: "5",
                    worstRating: "1",
                },
                availableService: this.doctor.specializations.map((spec) => ({
                    "@type": "MedicalProcedure",
                    name: spec,
                })),
                workHours:
                    this.doctor.schedules?.map((schedule) => ({
                        "@type": "OpeningHoursSpecification",
                        dayOfWeek: schedule.day,
                        opens: schedule.time.split(" - ")[0],
                        closes: schedule.time.split(" - ")[1],
                    })) || [],
            };

            this.schemaMarkup = JSON.stringify(schema, null, 2);
        },
    }));
});

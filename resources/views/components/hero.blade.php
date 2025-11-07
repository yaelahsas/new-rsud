<section class="text-gray-700 body-font bg-blue-50 pt-20 lg:pt-0">
    <div class="container mx-auto flex flex-col md:flex-row items-center px-5 py-16 md:py-24">

        <!-- Bagian kiri: teks hero -->
        <div
            class="flex flex-col md:items-start md:text-left mb-10 md:mb-0 items-center text-center md:w-1/2 lg:pr-24 md:pr-16">

            <!-- Judul -->
            <h1 class="title-font font-bold text-blue-900 text-3xl sm:text-4xl md:text-5xl leading-tight mb-4">
                Selamat Datang di RSUD Genteng Banyuwangi
            </h1>

            <!-- Paragraf (sembunyi di layar kecil) -->
            <p class="mb-8 leading-relaxed text-gray-600 hidden sm:block">
                Rumah Sakit Umum Daerah Genteng Banyuwangi berkomitmen memberikan pelayanan kesehatan terbaik bagi
                masyarakat dengan mengedepankan profesionalisme, empati, dan teknologi terkini.
                Temukan berbagai layanan dan informasi rumah sakit kami secara online.
            </p>

            <!-- 🔍 Pencarian -->
            <div class="w-full md:w-4/5 mb-8">
                <form
                    class="flex items-center bg-white rounded-full shadow-md overflow-hidden focus-within:ring-2 focus-within:ring-blue-300 transition">
                    <input type="text" id="hero-search" name="hero-search"
                        placeholder="Cari layanan, dokter, atau informasi..."
                        class="flex-grow px-4 py-2 sm:px-5 sm:py-3 text-gray-700 placeholder-gray-400 text-sm sm:text-base focus:outline-none" />
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 sm:px-6 py-2 sm:py-3 rounded-r-full text-sm sm:text-base transition">
                        Cari
                    </button>
                </form>
            </div>

            <!-- Tombol aksi -->
            <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto justify-center md:justify-start">
                <a href="https://rsudgenteng.banyuwangikab.go.id/pendaftaran" target="_blank"
                    class="inline-flex justify-center text-white bg-blue-600 border-0 py-2 sm:py-3 px-6 sm:px-8 focus:outline-none hover:bg-blue-700 rounded-full text-sm sm:text-lg transition w-full sm:w-auto">
                    Daftar Online
                </a>
                <a href="https://www.youtube.com/watch?v=pMBiQ3Pt8p0" target="_blank"
                    class="inline-flex justify-center text-blue-700 bg-blue-100 border-0 py-2 sm:py-3 px-6 sm:px-8 focus:outline-none hover:bg-blue-200 rounded-full text-sm sm:text-lg transition w-full sm:w-auto">
                    Panduan Pendaftaran
                </a>
            </div>
        </div>

        <!-- Bagian kanan: gambar direktur -->
        <div class="md:w-1/2 w-full flex justify-center">
            <img class="object-contain object-center rounded-lg  w-4/5 sm:w-3/4 md:w-full max-w-md h-120"
                alt="Direktur RSUD Genteng" src="{{ asset('img/dr.sugiyo.png') }}">
        </div>

    </div>
</section>

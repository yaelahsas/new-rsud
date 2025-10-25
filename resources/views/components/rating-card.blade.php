<!-- ✅ RATING CARD COMPONENT - Modern, Clean, Responsive -->
<section class="max-w-3xl mx-auto px-4 py-12">
    <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 transition-transform hover:scale-[1.01] duration-300">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Penilaian Pasien</h2>
            <span class="text-sm text-gray-500">BENEFIT RSUD Genteng</span>
        </div>

        <!-- Rating Overview -->
        <div class="flex flex-col md:flex-row items-center md:items-start md:space-x-6">
            <!-- Left: Overall rating -->
            <div class="flex flex-col items-center md:items-start text-center md:text-left">
                <span class="text-5xl font-extrabold text-yellow-400">4.9</span>
                <div class="flex text-yellow-400 text-2xl mt-1">
                    ★★★★★
                </div>
                <p class="text-gray-500 text-sm mt-1">(298 ulasan)</p>
            </div>

            <!-- Right: Rating bars -->
            <div class="w-full md:w-2/3 mt-6 md:mt-0 space-y-2">
                <div class="flex items-center">
                    <span class="w-10 text-sm text-gray-600">5★</span>
                    <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-2 bg-yellow-400 w-[95%]"></div>
                    </div>
                    <span class="w-8 text-right text-sm text-gray-500">282</span>
                </div>
                <div class="flex items-center">
                    <span class="w-10 text-sm text-gray-600">4★</span>
                    <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-2 bg-yellow-400 w-[4%]"></div>
                    </div>
                    <span class="w-8 text-right text-sm text-gray-500">12</span>
                </div>
                <div class="flex items-center">
                    <span class="w-10 text-sm text-gray-600">3★</span>
                    <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-2 bg-yellow-400 w-[0.3%]"></div>
                    </div>
                    <span class="w-8 text-right text-sm text-gray-500">1</span>
                </div>
                <div class="flex items-center">
                    <span class="w-10 text-sm text-gray-600">2★</span>
                    <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-2 bg-yellow-400 w-[0%]"></div>
                    </div>
                    <span class="w-8 text-right text-sm text-gray-500">0</span>
                </div>
                <div class="flex items-center">
                    <span class="w-10 text-sm text-gray-600">1★</span>
                    <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-2 bg-yellow-400 w-[1%]"></div>
                    </div>
                    <span class="w-8 text-right text-sm text-gray-500">3</span>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <div class="my-8 border-t border-gray-100"></div>

        <!-- Review Form -->
        <div class="text-center md:text-left">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">Berikan Penilaian Anda</h3>

            <div class="flex justify-center md:justify-start text-2xl text-yellow-400 mb-3" id="ratingStars">
                <span class="cursor-pointer" data-value="1">★</span>
                <span class="cursor-pointer" data-value="2">★</span>
                <span class="cursor-pointer" data-value="3">★</span>
                <span class="cursor-pointer" data-value="4">★</span>
                <span class="cursor-pointer" data-value="5">★</span>
            </div>

            <textarea id="reviewText"
                class="w-full md:w-3/4 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:border-green-400 outline-none transition"
                rows="3" placeholder="Tulis ulasan Anda di sini..."></textarea>

            <button id="submitReview"
                class="mt-4 px-6 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition duration-300 shadow-sm hover:shadow-md">
                Kirim Ulasan
            </button>
        </div>

        <!-- Divider -->
        <div class="my-8 border-t border-gray-100"></div>

        <!-- Recent Reviews -->
        <div>
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Ulasan Pasien Terbaru</h3>
            <div class="space-y-4">
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm hover:bg-gray-100 transition">
                    <div class="flex justify-between items-center mb-1">
                        <p class="font-medium text-gray-800">Rina</p>
                        <div class="text-yellow-400 text-lg">★★★★★</div>
                    </div>
                    <p class="text-gray-700 text-sm italic">“Pelayanan cepat dan ramah.”</p>
                    <p class="text-xs text-gray-400 mt-1">12 Agustus 2025</p>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg shadow-sm hover:bg-gray-100 transition">
                    <div class="flex justify-between items-center mb-1">
                        <p class="font-medium text-gray-800">Andi</p>
                        <div class="text-yellow-400 text-lg">★★★★★</div>
                    </div>
                    <p class="text-gray-700 text-sm italic">“Sangat membantu, terima kasih!”</p>
                    <p class="text-xs text-gray-400 mt-1">5 Juli 2025</p>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg shadow-sm hover:bg-gray-100 transition">
                    <div class="flex justify-between items-center mb-1">
                        <p class="font-medium text-gray-800">Bagus</p>
                        <div class="text-yellow-400 text-lg">★★★★☆</div>
                    </div>
                    <p class="text-gray-700 text-sm italic">“Perlu ditambah loket informasi.”</p>
                    <p class="text-xs text-gray-400 mt-1">20 Juni 2025</p>
                </div>
            </div>
        </div>
    </div>
</section>

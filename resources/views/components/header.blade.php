<!-- SECTION: Sticky Banner + Header -->
<section class="fixed top-0 left-0 w-full z-50">
    <!-- Sticky Banner -->
    <div id="sticky-banner"
        class="flex justify-between w-full py-2 px-4 border-b border-gray-200 bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
        <div class="flex items-center mx-auto">
            <p class="flex items-center text-sm font-normal text-gray-500 dark:text-gray-400">
                <span
                    class="inline-flex p-1 me-3 bg-gray-200 rounded-full dark:bg-gray-600 w-6 h-6 items-center justify-center shrink-0">
                    <svg class="w-3 h-3 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 19">
                        <path
                            d="M15 1.943v12.114a1 1 0 0 1-1.581.814L8 11V5l5.419-3.871A1 1 0 0 1 15 1.943ZM7 4H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2v5a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2V4ZM4 17v-5h1v5H4ZM16 5.183v5.634a2.984 2.984 0 0 0 0-5.634Z" />
                    </svg>
                </span>
                <span>
                    🚀 <strong>Informasi:</strong> Pelayanan online RSUD Genteng kini bisa diakses lewat
                    <a href="#" class="font-medium text-blue-600 underline dark:text-blue-400 hover:no-underline">
                        aplikasi Genpas
                    </a>.
                </span>
            </p>
        </div>
        <div class="flex items-center">
            <button data-dismiss-target="#sticky-banner" type="button"
                class="shrink-0 inline-flex justify-center w-7 h-7 items-center text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 dark:hover:bg-gray-600 dark:hover:text-white">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close banner</span>
            </button>
        </div>
    </div>

    <!-- Header / Navbar -->
    <header>
        <nav class="bg-white border-gray-200 px-4 lg:px-6 py-2.5 shadow-md dark:bg-gray-800">
            <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
                <a href="#" class="flex items-center">
                    <img src="https://flowbite.com/docs/images/logo.svg" class="mr-3 h-6 sm:h-9" alt="Logo RS" />
                    <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">RSUD Genteng</span>
                </a>
                <div class="flex items-center lg:order-1">
                    <button data-collapse-toggle="mobile-menu-2" type="button"
                        class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                        aria-controls="mobile-menu-2" aria-expanded="false">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <div class="hidden justify-between items-center w-full lg:flex lg:w-auto lg:order-2" id="mobile-menu-2">
                    <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                        <li><a href="#"
                                class="text-blue-700 lg:p-0 dark:text-white">Beranda</a></li>
                        <li><a href="#"
                                class="text-gray-700 hover:text-blue-700 lg:p-0 dark:text-gray-400 dark:hover:text-white">Layanan</a></li>
                        <li><a href="/medis"
                                class="text-gray-700 hover:text-blue-700 lg:p-0 dark:text-gray-400 dark:hover:text-white">Dokter</a></li>
                        <li><a href="/inovasi"
                                class="text-gray-700 hover:text-blue-700 lg:p-0 dark:text-gray-400 dark:hover:text-white">Inovasi</a></li>
                        <li><a href="/artikel"
                                class="text-gray-700 hover:text-blue-700 lg:p-0 dark:text-gray-400 dark:hover:text-white">Artikel</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
</section>

<!-- Spacer (tinggi total banner + navbar) -->
<div class="h-10 md:h-18"></div>

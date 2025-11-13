<!DOCTYPE html>
<html lang="en" class="h-full bg-blue-50 text-gray-800">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'RSUD Genteng' }}</title>

    {{-- <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}

    <!-- TailwindCSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])


    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" /> --}}

    <!-- Favicon (opsional) -->
  <link rel="stylesheet" href="{{ asset('css/fontawesome-free/css/all.css'  ) }}" />
</head>

<body class="min-h-screen w-full bg-blue-50 text-gray-700 font-sans antialiased flex flex-col">



    <!-- Header -->
    <x-header></x-header>
    
    <!-- Hero Section (only on home page) -->
    @if(request()->is('/') || request()->is('home'))
        <x-hero-full></x-hero-full>
    @endif
 
    <!-- Main Content -->
    <main class="flex-grow bg-white shadow-inner">
        <div class="mx-auto max-w-8md px-4 py-10 sm:px-6 lg:px-8">
            {{ $slot }}
        </div>
    </main>

 <x-footer></x-footer>

</body>

</html>

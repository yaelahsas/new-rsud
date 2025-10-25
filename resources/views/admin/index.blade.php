<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - RSUD Genteng')</title>
       @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800">

    {{-- Sidebar --}}
    <x-admin.sidebar />

    {{-- Main content --}}
    <div class="ml-64 min-h-screen flex flex-col">
        <header class="h-16 bg-white border-b flex items-center justify-between px-6 shadow-sm">
            <h1 class="text-lg font-semibold">@yield('page_title', 'Dashboard')</h1>
            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-600">Admin RSUD</span>
                <button class="px-3 py-1 text-sm bg-green-600 text-white rounded-md hover:bg-green-700">
                    Logout
                </button>
            </div>
        </header>

        <main class="flex-1 p-6">

        </main>
    </div>

</body>
</html>

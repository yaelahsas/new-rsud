<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Admin - RSUD Genteng</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="https://rsudgenteng.banyuwangikab.go.id/gambar/logo.png">

    <style>
        /* Animasi halus */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes popIn {
            0% {
                opacity: 0;
                transform: scale(0.95);
            }

            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.8s ease-out both;
        }

        .animate-popIn {
            animation: popIn 0.6s ease-out both;
        }

        /* Background wave baru */
        .wave-bg {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 280px;
            background: linear-gradient(to top, #b7f0c5 0%, #d8fbe1 60%, transparent 100%),
                url('data:image/svg+xml;utf8,<svg viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg"><path fill="%2391e5a1" fill-opacity="1" d="M0,256L60,250.7C120,245,240,235,360,213.3C480,192,600,160,720,160C840,160,960,192,1080,197.3C1200,203,1320,181,1380,170.7L1440,160L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path></svg>');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: bottom;
            opacity: 0.6;
            z-index: 0;
        }

        /* Responsif untuk layar besar */
        @media (min-width: 1024px) {
            .wave-bg {
                height: 380px;
                opacity: 0.5;
            }
        }
    </style>
</head>

<body
    class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-50 to-white relative overflow-hidden">

    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/white-wall-3.png')] opacity-10">
    </div>

    <div
        class="w-full max-w-md p-8 bg-white rounded-2xl shadow-2xl border border-gray-100 animate-fadeInUp relative z-10">
        <div class="text-center mb-6">
            <img src="https://rsudgenteng.banyuwangikab.go.id/assets/front/img/logo-dark.png" alt="RSUD Genteng Logo"
                class="mx-auto h-16 w-auto animate-popIn ">
            <h1 class="mt-4 text-2xl font-bold text-gray-800">Login Admin</h1>
        </div>

        <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" required
                    class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none"
                    placeholder="contoh@email.com" value="{{ old('email') }}">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                <input type="password" id="password" name="password" required
                    class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-400 focus:outline-none"
                    placeholder="********">
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-ban"></i> Error!</h5>
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center">
                    <input type="checkbox" class="text-green-600 focus:ring-green-500 border-gray-300 rounded">
                    <span class="ml-2 text-gray-600">Ingat saya</span>
                </label>
                <a href="#" class="text-green-600 hover:underline">Lupa kata sandi?</a>
            </div>

            <button type="submit"
                class="w-full py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-md transition duration-300 transform hover:-translate-y-1">
                Masuk
            </button>
        </form>

        <p class="mt-6 text-center text-gray-400 text-sm">
            © 2025 RSUD Genteng. Semua hak dilindungi.
        </p>
    </div>

    <div class="wave-bg"></div>
</body>

</html>

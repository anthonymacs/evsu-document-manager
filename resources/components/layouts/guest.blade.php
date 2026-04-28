<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'EVSU Reader' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        @keyframes float-delayed {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
        }

        @keyframes slide-up {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-float-delayed {
            animation: float-delayed 7s ease-in-out infinite;
            animation-delay: 1s;
        }

        .animate-slide-up {
            animation: slide-up 0.8s ease-out;
        }

        .bg-university-gradient {
            background: linear-gradient(135deg, var(--color-university-red) 0%, #A52A2A 50%, var(--color-university-red) 100%);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
    </style>

    @livewireStyles()
    @stack('styles')
</head>

<body class="bg-gray-50 font-sans antialiased flex flex-col min-h-screen">

    <x-guest.navbar />

    <main class="flex-grow flex items-center justify-center relative overflow-hidden">
        {{ $slot }}
    </main>

    <x-guest.footer />

    @stack('scripts')
    @livewireScripts()

    <script>
        window.addEventListener('popstate', function () {
            window.location.reload();
        });
    </script>

</body>

</html>
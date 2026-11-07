<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title . ' - ' : '' }}{{ config('app.name', 'Mutiara Kesehatan') }}</title>

    <!-- Favicon -->
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <!-- Google Fonts (Plus Jakarta Sans & Inter) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- CSS AOS (Animate On Scroll) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Laravel Vite (CSS & JS) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Livewire Styles -->
    @livewireStyles

    @stack('styles')
</head>
<body class="h-full bg-slate-50 text-slate-800 font-['Plus_Jakarta_Sans',sans-serif] antialiased selection:bg-teal-500 selection:text-white">

    <!-- Wrapper Utama Portal -->
    <main class="min-h-screen flex flex-col justify-between">
        <div class="flex-grow">
            @yield('content')
            {{ $slot ?? '' }}
        </div>

        <!-- Subtle Footer Klinik / RS -->
        <footer class="py-6 text-center text-xs text-slate-400 border-t border-slate-200/60">
            <p>© {{ date('Y') }} {{ config('app.name', 'Mutiara Kesehatan') }}. Seluruh hak cipta dilindungi.</p>
        </footer>
    </main>

    <!-- Livewire Scripts -->
    @livewireScripts

    <!-- JS AOS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof AOS !== 'undefined') {
                AOS.init({
                    once: true,
                    duration: 600,
                    easing: 'ease-out-cubic',
                });
            }
        });
    </script>

    @stack('scripts')
</body>
</html>

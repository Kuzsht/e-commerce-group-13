<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KICKSup - Your Ultimate Sneaker Destination')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    @stack('styles')
</head>
<body>
    @include('components.header')

    <main>
        @if(session('success'))
            <div class="container">
                <div class="alert alert-success">{{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="container">
                <div class="alert alert-error">{{ session('error') }}</div>
            </div>
        @endif

        @if(session('info'))
            <div class="container">
                <div class="alert alert-info">{{ session('info') }}</div>
            </div>
        @endif

        @yield('content')
    </main>

    @include('components.footer')

    <script>
        function toggleMobileMenu() {
            const navLinks = document.querySelector('.nav-links');
            navLinks.style.display = navLinks.style.display === 'flex' ? 'none' : 'flex';
        }
    </script>
    @stack('scripts')
</body>
</html>
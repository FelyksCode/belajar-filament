<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title', 'Recipe Collection')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="container mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <!-- Logo -->
                    <a href="{{ route('home') }}" class="flex items-center">
                        <span class="text-2xl font-bold text-gray-900">🍳 Recipes</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}"
                        class="text-gray-900 hover:text-blue-600 px-3 py-2 text-sm font-medium">
                        Home
                    </a>
                    <a href="#" class="text-gray-500 hover:text-blue-600 px-3 py-2 text-sm font-medium">
                        Categories
                    </a>
                    <a href="#" class="text-gray-500 hover:text-blue-600 px-3 py-2 text-sm font-medium">
                        Search
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="container mx-auto px-4 py-8">
            <div class="text-center text-gray-500 text-sm">
                <p>&copy; {{ date('Y') }} Recipe Collection. Built with Laravel & Tailwind CSS.</p>
            </div>
        </div>
    </footer>
</body>

</html>

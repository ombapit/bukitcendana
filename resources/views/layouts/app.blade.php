<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">    
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ config('app.name') }}</title>
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex flex-col min-h-screen bg-gradient-to-b from-gray-800 via-gray-700 to-gray-600 text-gray-100">

  <!-- Navbar -->
  <header class="bg-gray-900 shadow">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
      <div class="flex items-center">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10">
        <h1 class="text-xl font-semibold text-white">{{ config('app.name') }}</h1>
      </div>
      <nav class="hidden md:flex gap-6 text-gray-300">
        <a href="{{ url('/') }}" class="hover:text-white">Beranda</a>
        <a href="{{ url('/admin') }}" class="hover:text-white">Admin</a>
      </nav>
      <button class="md:hidden text-gray-300" id="menu-toggle">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
      </button>
    </div>
    <div class="md:hidden px-4 pb-4 hidden bg-gray-900 text-gray-300" id="mobile-menu">
      <a href="{{ url('/') }}" class="block py-2">Beranda</a>
      <a href="{{ url('/admin') }}" class="hover:text-white">Admin</a>
    </div>
  </header>

  <!-- Content -->
  <main class="flex-1">
    @yield('content')
  </main>

  <!-- Footer -->
  <footer class="bg-gray-900 text-gray-400 py-4 mt-auto shadow-inner">
    <div class="container mx-auto px-4 text-center">
      &copy; {{ date('Y') }} {{ config('app.name') }}. Semua hak dilindungi.
    </div>
  </footer>

  <!-- JS -->
  <script>
    document.getElementById('menu-toggle').addEventListener('click', function () {
      const menu = document.getElementById('mobile-menu');
      menu.classList.toggle('hidden');
    });
  </script>
</body>
</html>

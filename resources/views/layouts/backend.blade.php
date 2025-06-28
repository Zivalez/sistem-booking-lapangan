<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        /* Custom scrollbar style */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #555; }
        ::-webkit-scrollbar-thumb { background: #888; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #a7a7a7; }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-800 via-slate-900 to-black font-sans text-gray-200">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-black/30 backdrop-blur-xl border-r border-white/10 flex-shrink-0">
            <div class="p-4 text-2xl font-bold text-white">
                <a href="{{ route('backend.dashboard') }}">🏟️ Booking App</a>
            </div>
            <nav class="mt-4">
                <a href="{{ route('backend.dashboard') }}" class="flex items-center px-4 py-3 {{ request()->routeIs('backend.dashboard') ? 'bg-white/10' : '' }} hover:bg-white/10 transition-colors duration-200">
                    <i class="fas fa-tachometer-alt w-6"></i><span class="ml-3">Dashboard</span>
                </a>
                <a href="{{ route('backend.lapangan.index') }}" class="flex items-center px-4 py-3 mt-2 {{ request()->routeIs('backend.lapangan.*') ? 'bg-white/10' : '' }} hover:bg-white/10 transition-colors duration-200">
                    <i class="fas fa-futbol w-6"></i><span class="ml-3">Manajemen Lapangan</span>
                </a>
                <a href="{{ route('backend.booking.index') }}" class="flex items-center px-4 py-3 mt-2 {{ request()->routeIs('backend.booking.*') ? 'bg-white/10' : '' }} hover:bg-white/10 transition-colors duration-200">
                    <i class="fas fa-calendar-check w-6"></i><span class="ml-3">Manajemen Booking</span>
                </a>
                <a href="{{ route('backend.laporan') }}" class="flex items-center px-4 py-3 mt-2 {{ request()->routeIs('backend.laporan.*') ? 'bg-white/10' : '' }} hover:bg-white/10 transition-colors duration-200">
                    <i class="fas fa-chart-bar w-6"></i><span class="ml-3">Laporan</span>
                </a>
            </nav>
            <div class="absolute bottom-0 w-full p-2">
                 <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-4 py-3 text-red-400 hover:bg-white/10 hover:text-red-300 transition-colors duration-200 rounded-lg">
                       <i class="fas fa-sign-out-alt w-6"></i><span class="ml-3">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-black/20 backdrop-blur-lg p-4 flex justify-between items-center border-b border-white/10">
                <h1 class="text-2xl font-bold text-white">@yield('page-title', 'Dashboard')</h1>
                <div class="text-white">@yield('page-actions')</div>
            </header>
            <main class="flex-1 overflow-x-hidden overflow-y-auto p-6">
                @if(session('success'))
                    <div class="bg-green-500/20 border border-green-500 text-green-300 px-4 py-3 rounded relative mb-4" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                     <div class="bg-red-500/20 border border-red-500 text-red-300 px-4 py-3 rounded relative mb-4" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    {{-- Memanggil JS Flatpickr --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    {{-- Memanggil JS SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- INI DIA "COLOKAN" YANG HILANG --}}
    @yield('scripts')

    {{-- Script untuk konfirmasi delete (yang sudah ada) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.show_confirm');
            deleteButtons.forEach((button) => { /* ... isi script ... */ });
        });
    </script>
</body>
</html>
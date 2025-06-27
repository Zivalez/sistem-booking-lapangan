<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Booking Lapangan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        body {
            background-attachment: fixed;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-900 via-indigo-900 to-slate-800 text-gray-200">
    
    {{-- Navbar dengan efek kaca --}}
    <nav class="bg-black/20 backdrop-blur-lg sticky top-0 z-10 border-b border-white/10">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between py-4">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-white">🏟️ Booking Lapangan</a>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('backend.dashboard') }}" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded-lg transition-colors">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="bg-gray-700 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition-colors">Login Admin</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="container mx-auto my-8 p-4">
        <h1 class="text-4xl font-bold text-center text-white mb-2">Jadwal Ketersediaan Lapangan</h1>
        <p class="text-center text-gray-400 mb-8">Lihat jadwal secara langsung dan booking lapangan favoritmu!</p>

        {{-- Kartu "Kaca" untuk Jadwal --}}
        <div class="bg-white/5 backdrop-blur-xl shadow-2xl rounded-2xl border border-white/10 overflow-hidden">
            <div class="p-6 flex justify-between items-center border-b border-white/10">
                <h3 class="text-xl font-semibold">Jadwal untuk: {{ \Carbon\Carbon::parse($selectedDate)->format('d F Y') }}</h3>
                <input type="date" id="dateFilter" class="bg-white/10 border-white/20 rounded-md shadow-sm text-white" value="{{ $selectedDate }}" onchange="filterByDate(this.value)">
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-white/10 border-b border-t border-white/10">
                        <tr>
                            <th class="w-28 text-left py-3 px-4 uppercase font-semibold text-sm">Jam</th>
                            @foreach($lapangans as $lapangan)
                                <th class="text-left py-3 px-4 uppercase font-semibold text-sm">{{ $lapangan->nama_lapangan }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="text-gray-300">
                        @foreach($timeSlots as $time)
                        <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                            <td class="text-left py-3 px-4 font-bold">{{ $time }}</td>
                            @foreach($lapangans as $lapangan)
                                @php
                                    $booking = $bookingMatrix[$time][$lapangan->id] ?? null;
                                @endphp
                                <td class="text-center p-2">
                                    @if($booking)
                                        <div class="bg-red-500/30 text-red-100 p-2 rounded-md text-center h-full text-xs">
                                            <strong>BOOKED</strong>
                                        </div>
                                    @else
                                        <div class="bg-green-500/20 text-green-200 p-2 rounded-md h-full text-xs">
                                            Tersedia
                                        </div>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    
    <script>
        function filterByDate(date) {
            window.location.href = '{{ route("home") }}?date=' + date;
        }
    </script>
</body>
</html>
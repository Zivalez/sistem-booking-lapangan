<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Booking Lapangan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style> body { background-attachment: fixed; } </style>
</head>
<body class="bg-gradient-to-br from-gray-900 via-indigo-900 to-slate-800 text-gray-200">
    <nav class="bg-black/20 backdrop-blur-lg sticky top-0 z-10 border-b border-white/10">
        {{-- KODE NAVBAR YANG HILANG --}}
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

        <div class="bg-white/5 backdrop-blur-xl shadow-2xl rounded-2xl border border-white/10 overflow-hidden">
            <div class="p-6 flex justify-between items-center border-b border-white/10">
                <h3 class="text-xl font-semibold">Jadwal untuk: {{ \Carbon\Carbon::parse($selectedDate)->format('d F Y') }}</h3>
                <form action="{{ route('home') }}" method="GET">
                    <input type="date" name="date" class="bg-white/10 border-white/20 rounded-md shadow-sm text-white" value="{{ $selectedDate }}" onchange="this.form.submit()">
                </form>
            </div>

            <div class="overflow-x-auto">
                @php $skipMatrix = []; @endphp 
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
                            <td class="text-left py-3 px-4 font-bold align-middle">{{ $time }}</td>
                            @foreach($lapangans as $lapangan)
                                @if(isset($skipMatrix[$time][$lapangan->id]))
                                    @continue
                                @endif

                                @php
                                    $cellData = $bookingMatrix[$time][$lapangan->id];
                                    $booking = $cellData['booking'];
                                    $duration = $cellData['duration'];
                                @endphp

                                <td class="p-1 align-middle text-center" rowspan="{{ $duration > 0 ? $duration : 1 }}">
                                    @if($booking)
                                        @for ($i = 1; $i < $duration; $i++)
                                            @php
                                                $nextTime = \Carbon\Carbon::parse($time)->addHours($i)->format('H:i');
                                                $skipMatrix[$nextTime][$lapangan->id] = true;
                                            @endphp
                                        @endfor
                                        <div class="bg-red-500/40 text-red-100 p-2 rounded-lg h-full flex flex-col justify-center border border-red-500/50">
                                            <strong class="text-sm">BOOKED</strong>
                                        </div>
                                    @else
                                        <div class="bg-green-500/20 text-green-200 p-2 rounded-lg h-full text-xs flex items-center justify-center">
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
</body>
</html>
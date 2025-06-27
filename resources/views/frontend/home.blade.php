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
    <nav class="bg-black/20 backdrop-blur-lg sticky top-0 z-10 border-b border-white/10">
        {{-- KODE NAVBAR YANG HILANG --}}
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between py-4">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-white">🏟️ Booking Lapangan</a>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('backend.dashboard') }}"
                            class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded-lg transition-colors">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="bg-gray-700 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition-colors">Login
                            Admin</a>
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
                <h3 class="text-xl font-semibold">Jadwal untuk:
                    {{ \Carbon\Carbon::parse($selectedDate)->format('d F Y') }}</h3>
                <form action="{{ route('home') }}" method="GET">
                    <input type="date" name="date"
                        class="bg-white/10 border-white/20 rounded-md shadow-sm text-white" value="{{ $selectedDate }}"
                        onchange="this.form.submit()">
                </form>
            </div>

            @php $bookingRendered = []; @endphp
            <div class="overflow-x-auto">
                <div
                    class="grid grid-cols-[100px_repeat({{ count($lapangans) }},1fr)] auto-rows-[48px] gap-x-2 gap-y-2 text-sm text-white">
                    {{-- HEADER --}}
                    <div class="bg-white/5 font-bold flex items-center justify-center">Jam</div>
                    @foreach ($lapangans as $lapangan)
                        <div class="bg-white/5 font-bold flex items-center justify-center">
                            {{ $lapangan->nama_lapangan }}</div>
                    @endforeach

                    {{-- BODY --}}
                    @foreach ($timeSlots as $timeIndex => $time)
                        {{-- Jam --}}
                        <div class="bg-white/5 flex items-center justify-center">{{ $time }}</div>

                        {{-- Lapangan --}}
                        @foreach ($lapangans as $lapIndex => $lapangan)
                            @php
                                $cellData = $bookingMatrix[$time][$lapangan->id];
                                $booking = $cellData['booking'];
                                $duration = $cellData['duration'];
                            @endphp

                            @if (isset($bookingRendered[$lapangan->id][$time]))
                                @continue
                            @endif

                            @if ($booking)
                                <div class="bg-red-500/40 border border-red-400 text-red-100 text-xs rounded-lg p-2 flex flex-col items-center justify-center"
                                    style="grid-column: {{ $lapIndex + 2 }}; grid-row: {{ $timeIndex + 2 }} / span {{ $duration }};">
                                    <strong class="text-sm">BOOKED</strong>
                                </div>

                                @for ($i = 0; $i < $duration; $i++)
                                    @php
                                        $skipTime = \Carbon\Carbon::parse($time)->addHours($i)->format('H:i');
                                        $bookingRendered[$lapangan->id][$skipTime] = true;
                                    @endphp
                                @endfor
                            @else
                                <div class="bg-green-500/20 text-green-200 text-xs rounded-lg p-2 flex items-center justify-center"
                                    style="grid-column: {{ $lapIndex + 2 }}; grid-row: {{ $timeIndex + 2 }};">
                                    Tersedia
                                </div>
                            @endif
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</body>

</html>

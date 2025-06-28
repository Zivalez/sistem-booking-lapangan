@extends('layouts.backend')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('page-actions')
    <div class="flex items-center space-x-2">
        <form action="{{ route('backend.dashboard') }}" method="GET">
            <input type="date" name="date" class="bg-white/10 border-white/20 rounded-md shadow-sm text-white" value="{{ $selectedDate }}" onchange="this.form.submit()">
        </form>
        <a href="{{ route('backend.booking.create') }}" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded inline-flex items-center transition-colors duration-200">
            <i class="fas fa-plus mr-2"></i> Tambah Booking
        </a>
    </div>
@endsection

@section('content')
<div class="bg-white/10 backdrop-blur-lg shadow-lg rounded-xl p-6 border border-white/10">
    <h3 class="text-xl font-semibold mb-4 text-white">Jadwal Lapangan - {{ \Carbon\Carbon::parse($selectedDate)->format('d F Y') }}</h3>

    @php $bookingRendered = []; @endphp

    <div class="grid grid-cols-[100px_repeat({{ count($lapangans) }},1fr)] auto-rows-[48px] gap-2 bg-white/10 rounded-md overflow-hidden border border-white/10 text-sm text-white">
        {{-- HEADER --}}
        <div class="bg-white/5 flex items-center justify-center font-bold">Jam</div>
        @foreach($lapangans as $lapangan)
            <div class="bg-white/5 flex items-center justify-center font-bold">{{ $lapangan->nama_lapangan }}</div>
        @endforeach

        {{-- BODY --}}
        @foreach($timeSlots as $timeIndex => $time)
            {{-- Kolom JAM --}}
            <div class="bg-white/5 flex items-center justify-center">{{ $time }}</div>

            {{-- Kolom per Lapangan --}}
            @foreach($lapangans as $lapIndex => $lapangan)
                @php
                    $cellData = $bookingMatrix[$time][$lapangan->id];
                    $booking = $cellData['booking'];
                    $duration = $cellData['duration'];
                @endphp

                @if(isset($bookingRendered[$lapangan->id][$time]))
                    @continue
                @endif

                @if($booking)
                    <div
                        class="bg-red-500/40 border border-red-400 rounded-md flex flex-col items-center justify-center text-center p-2"
                        style="grid-column: {{ $lapIndex + 2 }}; grid-row: {{ $timeIndex + 2 }} / span {{ $duration }};"
                    >
                        <p class="font-bold text-sm">{{ $booking->nama_penyewa }}</p>
                        <p class="text-xs opacity-75">
                            ({{ \Carbon\Carbon::parse($booking->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->jam_selesai)->format('H:i') }})
                        </p>
                    </div>

                    @for($i = 0; $i < $duration; $i++)
                        @php
                            $skipTime = \Carbon\Carbon::parse($time)->addHours($i)->format('H:i');
                            $bookingRendered[$lapangan->id][$skipTime] = true;
                        @endphp
                    @endfor
                @else
                    <a href="{{ route('backend.booking.create', ['lapangan_id' => $lapangan->id, 'tanggal_booking' => $selectedDate, 'jam_mulai' => $time]) }}"
                       class="bg-green-500/10 hover:bg-green-500/30 text-green-300 border border-green-400 rounded-md flex items-center justify-center transition-colors duration-200 opacity-60 hover:opacity-100"
                       style="grid-column: {{ $lapIndex + 2 }}; grid-row: {{ $timeIndex + 2 }};"
                    >
                        <i class="fas fa-plus"></i>
                    </a>
                @endif
            @endforeach
        @endforeach
    </div>
</div>
@endsection

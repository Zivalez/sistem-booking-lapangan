@extends('layouts.backend')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('page-actions')
    <div class="flex items-center space-x-2">
        <input type="date" id="dateFilter" class="bg-white/10 border-white/20 rounded-md shadow-sm text-white" value="{{ $selectedDate }}" onchange="filterByDate(this.value)">
        <a href="{{ route('backend.booking.create') }}" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded inline-flex items-center transition-colors duration-200">
            <i class="fas fa-plus mr-2"></i> Tambah Booking
        </a>
    </div>
@endsection

@section('content')
<div class="bg-white/10 backdrop-blur-lg shadow-lg rounded-xl p-6 border border-white/10">
    <h3 class="text-xl font-semibold mb-4 text-white">Jadwal Lapangan - {{ \Carbon\Carbon::parse($selectedDate)->format('d F Y') }}</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="border-b border-white/20">
                <tr>
                    <th class="w-24 text-left py-3 px-4 uppercase font-semibold text-sm">Jam</th>
                    @foreach($lapangans as $lapangan)
                        <th class="text-left py-3 px-4 uppercase font-semibold text-sm">{{ $lapangan->nama_lapangan }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="text-gray-300">
                @foreach($timeSlots as $time)
                <tr class="border-b border-white/10">
                    <td class="text-left py-2 px-4 font-bold">{{ $time }}</td>
                    @foreach($lapangans as $lapangan)
                        @php
                            $booking = $bookingMatrix[$time][$lapangan->id] ?? null;
                        @endphp
                        <td class="p-1">
                            @if($booking)
                                <div class="bg-red-500/30 text-red-100 p-2 rounded-md text-center h-full">
                                    <p class="font-bold text-sm">{{ $booking->nama_penyewa }}</p>
                                </div>
                            @else
                                <a href="{{ route('backend.booking.create', ['lapangan_id' => $lapangan->id, 'tanggal_booking' => $selectedDate, 'jam_mulai' => $time]) }}" class="bg-green-500/20 hover:bg-green-500/40 text-green-200 p-2 rounded-md h-full flex items-center justify-center transition-colors duration-200">
                                    Tersedia
                                </a>
                            @endif
                        </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function filterByDate(date) {
        window.location.href = '{{ route("backend.dashboard") }}?date=' + date;
    }
</script>
@endsection
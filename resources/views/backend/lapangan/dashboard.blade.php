@extends('layouts.backend')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('page-actions')
    <div class="d-flex gap-2">
        <input type="date" id="dateFilter" class="form-control" value="{{ $selectedDate }}" 
               onchange="filterByDate(this.value)">
        <a href="{{ route('backend.booking.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah Booking
        </a>
    </div>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        Jadwal Lapangan - {{ \Carbon\Carbon::parse($selectedDate)->format('d F Y') }}
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 100px;">Jam</th>
                        @foreach($lapangans as $lapangan)
                            <th>
                                {{ $lapangan->nama_lapangan }}
                                <br>
                                <small class="text-white-50">{{ $lapangan->jenis }}</small>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($timeSlots as $time)
                    <tr>
                        <td class="fw-bold">{{ $time }}</td>
                        @foreach($lapangans as $lapangan)
                            @php
                                $booking = $bookingMatrix[$time][$lapangan->id] ?? null;
                            @endphp
                            <td class="p-1">
                                @if($booking)
                                    <div class="alert alert-danger p-2 h-100" 
                                         data-bs-toggle="tooltip" 
                                         title="Status: {{ $booking->status }}">
                                        <strong>{{ $booking->nama_penyewa }}</strong><br>
                                        <small>{{ \Carbon\Carbon::parse($booking->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->jam_selesai)->format('H:i') }}</small>
                                    </div>
                                @else
                                    <a href="{{ route('backend.booking.create', ['lapangan_id' => $lapangan->id, 'tanggal_booking' => $selectedDate, 'jam_mulai' => $time]) }}" 
                                       class="btn btn-success w-100 h-100 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-plus"></i>&nbsp;Tersedia
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
</div>
@endsection

@section('scripts')
<script>
    // Inisialisasi tooltip dari Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Fungsi buat filter tanggal
    function filterByDate(date) {
        window.location.href = '{{ route("backend.dashboard") }}?date=' + date;
    }
</script>
@endsection
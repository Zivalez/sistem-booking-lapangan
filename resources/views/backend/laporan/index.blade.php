@extends('layouts.backend')
@section('title', 'Laporan Pendapatan')
@section('page-title', 'Laporan Pendapatan')
@section('content')
<div class="bg-white/10 backdrop-blur-lg shadow-lg rounded-xl p-6 mb-6 border border-white/10">
    <form method="GET" action="{{ route('backend.laporan') }}">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            <div>
                <label for="start_date_report" class="block mb-2 text-sm font-medium">Tanggal Mulai</label>
                {{-- INPUT TANGGAL AWAL YANG DIUBAH --}}
                <input type="text" id="start_date_report" name="start_date" value="{{ request('start_date') }}" required class="bg-white/5 border-white/20 rounded-md shadow-sm text-white form-input w-full" placeholder="Pilih Tanggal...">
            </div>
            <div>
                <label for="end_date_report" class="block mb-2 text-sm font-medium">Tanggal Selesai</label>
                {{-- INPUT TANGGAL AKHIR YANG DIUBAH --}}
                <input type="text" id="end_date_report" name="end_date" value="{{ request('end_date') }}" required class="bg-white/5 border-white/20 rounded-md shadow-sm text-white form-input w-full" placeholder="Pilih Tanggal...">
            </div>
            <div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded w-full">Tampilkan Laporan</button>
            </div>
        </div>
    </form>
</div>

@if($bookings)
<div class="bg-white/10 backdrop-blur-lg shadow-lg rounded-xl border border-white/10">
    <div class="p-6">
        <h3 class="text-xl font-semibold mb-2">Total Pendapatan: <span class="text-green-400">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span></h3>
        <div class="overflow-x-auto mt-4">
            <table class="min-w-full">
                <thead class="border-b border-white/20">
                    <tr>
                        <th class="py-3 px-4 text-left">ID</th>
                        <th class="py-3 px-4 text-left">Lapangan</th>
                        <th class="py-3 px-4 text-left">Penyewa</th>
                        <th class="py-3 px-4 text-left">Tanggal</th>
                        <th class="py-3 px-4 text-right">Total Bayar</th>
                    </tr>
                </thead>
                <tbody class="text-gray-300">
                @forelse($bookings as $booking)
                    <tr class="border-b border-white/10">
                        <td class="py-3 px-4">{{$booking->id}}</td>
                        <td class="py-3 px-4">{{$booking->lapangan->nama_lapangan}}</td>
                        <td class="py-3 px-4">{{$booking->nama_penyewa}}</td>
                        <td class="py-3 px-4">{{$booking->tanggal_booking->format('d/m/Y')}}</td>
                        <td class="py-3 px-4 text-right">{{$booking->formatted_total_harga}}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center py-4">Tidak ada data untuk periode ini.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script>
    flatpickr("#start_date_report", { 
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "j F Y",
    });
    flatpickr("#end_date_report", { 
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "j F Y",
    });
</script>
@endsection
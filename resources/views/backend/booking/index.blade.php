@extends('layouts.backend')

@section('title', 'Manajemen Booking')
@section('page-title', 'Manajemen Booking')

@section('page-actions')
    <a href="{{ route('backend.booking.create') }}" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded inline-flex items-center transition-colors duration-200">
        <i class="fas fa-plus mr-2"></i> Tambah Booking
    </a>
@endsection

@section('content')
<div class="bg-white/10 backdrop-blur-lg shadow-lg rounded-xl p-6 mb-6 border border-white/10">
    <form method="GET" action="{{ route('backend.booking.index') }}">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-center">
            {{-- INPUT TANGGAL AWAL YANG DIUBAH --}}
            <input type="text" id="start_date_filter" name="start_date" value="{{ request('start_date') }}" class="bg-white/5 border-white/20 rounded-md shadow-sm text-white form-input w-full" placeholder="Tanggal Mulai">

            {{-- INPUT TANGGAL AKHIR YANG DIUBAH --}}
            <input type="text" id="end_date_filter" name="end_date" value="{{ request('end_date') }}" class="bg-white/5 border-white/20 rounded-md shadow-sm text-white form-input w-full" placeholder="Tanggal Selesai">

            <select class="bg-white/5 border-white/20 rounded-md shadow-sm text-white form-select w-full" name="lapangan_id">
                <option value="" class="text-black">Semua Lapangan</option>
                @foreach($lapangans as $lapangan)
                    <option value="{{ $lapangan->id }}" {{ request('lapangan_id') == $lapangan->id ? 'selected' : '' }} class="text-black">{{ $lapangan->nama_lapangan }}</option>
                @endforeach
            </select>
            <select class="bg-white/5 border-white/20 rounded-md shadow-sm text-white form-select w-full" name="status">
                <option value="" class="text-black">Semua Status</option>
                <option value="Booked" {{ request('status') == 'Booked' ? 'selected' : '' }} class="text-black">Booked</option>
                <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }} class="text-black">Selesai</option>
                <option value="Batal" {{ request('status') == 'Batal' ? 'selected' : '' }} class="text-black">Batal</option>
            </select>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition-colors duration-200 w-full h-full">Filter</button>
        </div>
    </form>
</div>

<div class="bg-white/10 backdrop-blur-lg shadow-lg rounded-xl border border-white/10">
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="border-b border-white/20">
                    <tr>
                        <th class="py-3 px-4 text-left">Penyewa</th>
                        <th class="py-3 px-4 text-left">Lapangan</th>
                        <th class="py-3 px-4 text-left">Tanggal & Waktu</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-300">
                    @forelse($bookings as $booking)
                    <tr class="border-b border-white/10 hover:bg-white/5">
                        <td class="py-3 px-4">{{ $booking->nama_penyewa }}</td>
                        <td class="py-3 px-4">{{ $booking->lapangan->nama_lapangan }}</td>
                        <td class="py-3 px-4">{{ $booking->tanggal_booking->format('d/m/Y') }} ({{ \Carbon\Carbon::parse($booking->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->jam_selesai)->format('H:i') }})</td>
                        <td class="py-3 px-4 text-center">
                            <span class="px-2 py-1 text-xs font-bold rounded-full
                                {{ $booking->status == 'Booked' ? 'bg-yellow-500/30 text-yellow-200' : ($booking->status == 'Selesai' ? 'bg-green-500/30 text-green-200' : 'bg-red-500/30 text-red-200') }}">
                                {{ $booking->status }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right">
                            <div class="flex justify-end space-x-4">
                                <a href="{{ route('backend.booking.edit', $booking) }}" class="text-yellow-400 hover:text-yellow-300" title="Edit"><i class="fas fa-edit"></i></a>

                                {{-- INI ADALAH BAGIAN TOMBOL HAPUS --}}
                                <form action="{{ route('backend.booking.destroy', $booking) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus booking untuk {{ $booking->nama_penyewa }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-400" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                {{-- AKHIR DARI BAGIAN TOMBOL HAPUS --}}
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-4">Tidak ada data booking yang cocok.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="p-6 border-t border-white/10">
        {{ $bookings->appends(request()->query())->links() }}
    </div>
</div>
@endsection

@section('scripts')
{{-- SCRIPT UNTUK MENGAKTIFKAN FLATPICKR DI FILTER INI --}}
<script>
    flatpickr("#start_date_filter", {
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "j F Y",
    });
    flatpickr("#end_date_filter", {
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "j F Y",
    });
</script>
@endsection

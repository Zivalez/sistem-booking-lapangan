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
            <input type="text" id="start_date_filter" name="start_date" value="{{ request('start_date') }}" class="bg-white/5 border-white/20 rounded-md shadow-sm text-white form-input w-full" placeholder="Tanggal Mulai">
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
                            {{-- BAGIAN AKSI YANG DIPERBARUI --}}
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('backend.booking.edit', $booking) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 px-3 rounded inline-flex items-center transition-colors duration-200" title="Edit">
                                    <i class="fas fa-edit mr-2"></i>Edit
                                </a>
                                <form id="delete-form-{{ $booking->id }}" action="{{ route('backend.booking.destroy', $booking) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete('{{ $booking->id }}', '{{ $booking->nama_penyewa }}')" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded inline-flex items-center transition-colors duration-200" title="Hapus">
                                        <i class="fas fa-trash mr-2"></i>Hapus
                                    </button>
                                </form>
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
{{-- Flatpickr untuk filter tanggal --}}
<script>
    flatpickr("#start_date_filter", { dateFormat: "Y-m-d", altInput: true, altFormat: "j F Y" });
    flatpickr("#end_date_filter", { dateFormat: "Y-m-d", altInput: true, altFormat: "j F Y" });

    // FUNGSI BARU UNTUK KONFIRMASI HAPUS DENGAN SWEETALERT
    function confirmDelete(id, namaPenyewa) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: `Anda akan menghapus booking atas nama "${namaPenyewa}".`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
            background: '#1f2937', // Tema gelap
            color: '#ffffff'      // Tema gelap
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika dikonfirmasi, kirim form penghapusan
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
@endsection
@extends('layouts.backend')
@section('title', 'Edit Booking')
@section('page-title', 'Edit Booking ID: ' . $booking->id)

@section('content')
<div class="flex justify-center">
    <div class="w-full lg:w-2/3">
        <div class="bg-white/10 backdrop-blur-lg shadow-lg rounded-xl p-8 border border-white/10">
            <form action="{{ route('backend.booking.update', $booking) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="lapangan_id" class="block mb-2 text-sm font-medium">Lapangan</label>
                    <select id="lapangan_id" name="lapangan_id" class="bg-white/5 border border-white/20 text-white text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5" required>
                        @foreach($lapangans as $lapangan)
                            <option value="{{ $lapangan->id }}" {{ old('lapangan_id', $booking->lapangan_id) == $lapangan->id ? 'selected' : '' }} class="text-black">
                                {{ $lapangan->nama_lapangan }}
                            </option>
                        @endforeach
                    </select>
                    @error('lapangan_id') <div class="text-red-400 text-sm mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-5 group">
                        <label for="nama_penyewa" class="block mb-2 text-sm font-medium">Nama Penyewa</label>
                        <input type="text" id="nama_penyewa" name="nama_penyewa" value="{{ old('nama_penyewa', $booking->nama_penyewa) }}" required class="bg-white/5 border border-white/20 text-white text-sm rounded-lg block w-full p-2.5" onkeypress="return hanyaHuruf(event)">
                        @error('nama_penyewa') <div class="text-red-400 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <label for="no_hp_penyewa" class="block mb-2 text-sm font-medium">No. HP Penyewa</label>
                        <input type="text" id="no_hp_penyewa" name="no_hp_penyewa" value="{{ old('no_hp_penyewa', $booking->no_hp_penyewa) }}" required class="bg-white/5 border border-white/20 text-white text-sm rounded-lg block w-full p-2.5" onkeypress="return hanyaAngka(event)">
                        @error('no_hp_penyewa') <div class="text-red-400 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="tanggal_booking" class="block mb-2 text-sm font-medium">Tanggal Booking</label>
                    <input type="text" id="tanggal_booking" name="tanggal_booking" value="{{ old('tanggal_booking', $booking->tanggal_booking->format('Y-m-d')) }}" required class="bg-white/5 border border-white/20 text-white text-sm rounded-lg block w-full p-2.5" placeholder="YYYY-MM-DD">
                    @error('tanggal_booking') <div class="text-red-400 text-sm mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-5 group">
                        <label for="jam_mulai" class="block mb-2 text-sm font-medium">Jam Mulai</label>
                        <input type="text" id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai', \Carbon\Carbon::parse($booking->jam_mulai)->format('H:i')) }}" required class="bg-white/5 border border-white/20 text-white text-sm rounded-lg block w-full p-2.5" placeholder="HH:MM">
                        @error('jam_mulai') <div class="text-red-400 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <label for="jam_selesai" class="block mb-2 text-sm font-medium">Jam Selesai</label>
                        <input type="text" id="jam_selesai" name="jam_selesai" value="{{ old('jam_selesai', \Carbon\Carbon::parse($booking->jam_selesai)->format('H:i')) }}" required class="bg-white/5 border border-white/20 text-white text-sm rounded-lg block w-full p-2.5" placeholder="HH:MM">
                        @error('jam_selesai') <div class="text-red-400 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="status" class="block mb-2 text-sm font-medium">Status Booking</label>
                    <select id="status" name="status" class="bg-white/5 border border-white/20 text-white text-sm rounded-lg block w-full p-2.5" required>
                        <option value="Booked" {{ old('status', $booking->status) == 'Booked' ? 'selected' : '' }} class="text-black">Booked</option>
                        <option value="Selesai" {{ old('status', $booking->status) == 'Selesai' ? 'selected' : '' }} class="text-black">Selesai</option>
                        <option value="Batal" {{ old('status', $booking->status) == 'Batal' ? 'selected' : '' }} class="text-black">Batal</option>
                    </select>
                    @error('status') <div class="text-red-400 text-sm mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="flex justify-end space-x-4 mt-6">
                    <a href="{{ route('backend.booking.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded transition-colors duration-200">Batal</a>
                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded transition-colors duration-200">Update Booking</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Inisialisasi Flatpickr
    flatpickr("#tanggal_booking", { dateFormat: "Y-m-d", altInput: true, altFormat: "j F Y" });
    flatpickr("#jam_mulai", { enableTime: true, noCalendar: true, dateFormat: "H:i", time_24hr: true });
    flatpickr("#jam_selesai", { enableTime: true, noCalendar: true, dateFormat: "H:i", time_24hr: true });

    // Fungsi filter input
    function hanyaAngka(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) return false;
        return true;
    }
    function hanyaHuruf(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        if ((charCode < 65 || charCode > 90) && (charCode < 97 || charCode > 122) && charCode != 32) return false;
        return true;
    }
</script>
@endsection
@extends('layouts.backend')
@section('title', 'Tambah Booking')
@section('page-title', 'Tambah Booking')

@section('content')
<div class="flex justify-center">
    <div class="w-full lg:w-2/3">
        <div class="bg-white/10 backdrop-blur-lg shadow-lg rounded-xl p-8 border border-white/10">
            <form action="{{ route('backend.booking.store') }}" method="POST">
                @csrf
                
                {{-- Dropdown Lapangan (tidak berubah) --}}
                <div class="mb-4">
                    <label for="lapangan_id" class="block mb-2 text-sm font-medium">Lapangan</label>
                    <select id="lapangan_id" name="lapangan_id" class="bg-white/5 border border-white/20 text-white text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5" required>
                        <option value="" class="text-black">Pilih Lapangan</option>
                        @foreach($lapangans as $lapangan)
                            <option value="{{ $lapangan->id }}" {{ old('lapangan_id', $preData['lapangan_id']) == $lapangan->id ? 'selected' : '' }} class="text-black">
                                {{ $lapangan->nama_lapangan }} - {{ $lapangan->jenis }}
                            </option>
                        @endforeach
                    </select>
                    @error('lapangan_id') <div class="text-red-400 text-sm mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="grid md:grid-cols-2 md:gap-6">
                    {{-- Input Nama Penyewa dengan "Satpam" --}}
                    <div class="relative z-0 w-full mb-5 group">
                        <label for="nama_penyewa" class="block mb-2 text-sm font-medium">Nama Penyewa</label>
                        <input type="text" id="nama_penyewa" name="nama_penyewa" value="{{ old('nama_penyewa') }}" required 
                               class="bg-white/5 border border-white/20 text-white text-sm rounded-lg block w-full p-2.5"
                               onkeypress="return hanyaHuruf(event)"> {{-- INI PENAMBAHANNYA --}}
                        @error('nama_penyewa') <div class="text-red-400 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>
                    {{-- Input No. HP dengan "Satpam" --}}
                    <div class="relative z-0 w-full mb-5 group">
                        <label for="no_hp_penyewa" class="block mb-2 text-sm font-medium">No. HP Penyewa</label>
                        <input type="text" id="no_hp_penyewa" name="no_hp_penyewa" value="{{ old('no_hp_penyewa') }}" required 
                               class="bg-white/5 border border-white/20 text-white text-sm rounded-lg block w-full p-2.5"
                               onkeypress="return hanyaAngka(event)"> {{-- INI PENAMBAHANNYA --}}
                        @error('no_hp_penyewa') <div class="text-red-400 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- ... (input tanggal dan jam tetap sama) ... --}}
                <div class="mb-4">
                    <label for="tanggal_booking" class="block mb-2 text-sm font-medium">Tanggal Booking</label>
                    <input type="text" id="tanggal_booking" name="tanggal_booking" value="{{ old('tanggal_booking', $preData['tanggal_booking']) }}" required class="bg-white/5 border border-white/20 text-white text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5" placeholder="YYYY-MM-DD">
                    @error('tanggal_booking') <div class="text-red-400 text-sm mt-1">{{ $message }}</div> @enderror
                </div>
                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-5 group">
                        <label for="jam_mulai" class="block mb-2 text-sm font-medium">Jam Mulai</label>
                        <input type="text" id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai', $preData['jam_mulai']) }}" required class="bg-white/5 border border-white/20 text-white text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5" placeholder="HH:MM">
                        @error('jam_mulai') <div class="text-red-400 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <label for="jam_selesai" class="block mb-2 text-sm font-medium">Jam Selesai</label>
                        <input type="text" id="jam_selesai" name="jam_selesai" value="{{ old('jam_selesai') }}" required class="bg-white/5 border border-white/20 text-white text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5" placeholder="HH:MM">
                        @error('jam_selesai') <div class="text-red-400 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>
                
                <div class="flex justify-end space-x-4 mt-4">
                    <a href="{{ route('backend.dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded transition-colors duration-200">Batal</a>
                    <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded transition-colors duration-200">Simpan Booking</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
{{-- INI SCRIPT BARU UNTUK FILTER INPUT & FLATPCIKR --}}
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    // Inisialisasi Flatpickr
    flatpickr("#tanggal_booking", { dateFormat: "Y-m-d" });
    flatpickr("#jam_mulai", { enableTime: true, noCalendar: true, dateFormat: "H:i", time_24hr: true });
    flatpickr("#jam_selesai", { enableTime: true, noCalendar: true, dateFormat: "H:i", time_24hr: true });

    // Fungsi untuk memfilter input, hanya mengizinkan ANGKA
    function hanyaAngka(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57)){
            return false;
        }
        return true;
    }

    // Fungsi untuk memfilter input, hanya mengizinkan HURUF dan SPASI
    function hanyaHuruf(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if ((charCode < 65 || charCode > 90) && (charCode < 97 || charCode > 122) && charCode != 32){
            return false;
        }
        return true;
    }
</script>
@endsection
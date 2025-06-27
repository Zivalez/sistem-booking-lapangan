@extends('layouts.backend')
@section('title', 'Tambah Booking')
@section('page-title', 'Tambah Booking')

@section('content')
<div class="flex justify-center">
    <div class="w-full lg:w-2/3">
        <div class="bg-white/10 backdrop-blur-lg shadow-lg rounded-xl p-8 border border-white/10">
            <form action="{{ route('backend.booking.store') }}" method="POST">
                @csrf

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
                    <div class="relative z-0 w-full mb-5 group">
                        <label for="nama_penyewa" class="block mb-2 text-sm font-medium">Nama Penyewa</label>
                        <input type="text" id="nama_penyewa" name="nama_penyewa" value="{{ old('nama_penyewa') }}" required class="bg-white/5 border border-white/20 text-white text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5">
                        @error('nama_penyewa') <div class="text-red-400 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <label for="no_hp_penyewa" class="block mb-2 text-sm font-medium">No. HP Penyewa</label>
                        <input type="text" id="no_hp_penyewa" name="no_hp_penyewa" value="{{ old('no_hp_penyewa') }}" required class="bg-white/5 border border-white/20 text-white text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5">
                        @error('no_hp_penyewa') <div class="text-red-400 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="tanggal_booking" class="block mb-2 text-sm font-medium">Tanggal Booking</label>
                    <input type="date" id="tanggal_booking" name="tanggal_booking" value="{{ old('tanggal_booking', $preData['tanggal_booking']) }}" required class="bg-white/5 border border-white/20 text-white text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5">
                    @error('tanggal_booking') <div class="text-red-400 text-sm mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-5 group">
                        <label for="jam_mulai" class="block mb-2 text-sm font-medium">Jam Mulai</label>
                        <input type="time" id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai', $preData['jam_mulai']) }}" required class="bg-white/5 border border-white/20 text-white text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5">
                        @error('jam_mulai') <div class="text-red-400 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <label for="jam_selesai" class="block mb-2 text-sm font-medium">Jam Selesai</label>
                        <input type="time" id="jam_selesai" name="jam_selesai" value="{{ old('jam_selesai') }}" required class="bg-white/5 border border-white/20 text-white text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5">
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
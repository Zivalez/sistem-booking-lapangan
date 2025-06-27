@extends('layouts.backend')

@section('title', 'Edit Lapangan')
@section('page-title', 'Edit Lapangan')

@section('content')
<div class="flex justify-center">
    <div class="w-full lg:w-2/3">
        <div class="bg-white/10 backdrop-blur-lg shadow-lg rounded-xl p-8 border border-white/10">
            <form action="{{ route('backend.lapangan.update', $lapangan) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="nama_lapangan" class="block mb-2 text-sm font-medium">Nama Lapangan</label>
                    <input type="text" id="nama_lapangan" name="nama_lapangan" value="{{ old('nama_lapangan', $lapangan->nama_lapangan) }}" required class="bg-white/5 border border-white/20 text-white text-sm rounded-lg block w-full p-2.5">
                    @error('nama_lapangan') <div class="text-red-400 text-sm mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label for="jenis" class="block mb-2 text-sm font-medium">Jenis Lapangan</label>
                    <select id="jenis" name="jenis" class="bg-white/5 border border-white/20 text-white text-sm rounded-lg block w-full p-2.5" required>
                        <option value="Futsal" {{ old('jenis', $lapangan->jenis) == 'Futsal' ? 'selected' : '' }} class="text-black">Futsal</option>
                        <option value="Badminton" {{ old('jenis', $lapangan->jenis) == 'Badminton' ? 'selected' : '' }} class="text-black">Badminton</option>
                        <option value="Basket" {{ old('jenis', $lapangan->jenis) == 'Basket' ? 'selected' : '' }} class="text-black">Basket</option>
                    </select>
                    @error('jenis') <div class="text-red-400 text-sm mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label for="harga_per_jam" class="block mb-2 text-sm font-medium">Harga per Jam (Rp)</label>
                    <input type="number" id="harga_per_jam" name="harga_per_jam" value="{{ old('harga_per_jam', $lapangan->harga_per_jam) }}" required class="bg-white/5 border border-white/20 text-white text-sm rounded-lg block w-full p-2.5">
                    @error('harga_per_jam') <div class="text-red-400 text-sm mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label for="foto" class="block mb-2 text-sm font-medium">Ganti Foto Lapangan</label>
                    @if($lapangan->foto)
                        <img src="{{ Storage::url($lapangan->foto) }}" alt="{{ $lapangan->nama_lapangan }}" class="w-48 h-32 object-cover rounded-md mb-2">
                    @endif
                    <input type="file" id="foto" name="foto" class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-500 file:text-white hover:file:bg-indigo-600">
                    @error('foto') <div class="text-red-400 text-sm mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="flex justify-end space-x-4 mt-6">
                    <a href="{{ route('backend.lapangan.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded transition-colors duration-200">Batal</a>
                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded transition-colors duration-200">Update Lapangan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
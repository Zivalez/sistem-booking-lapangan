@extends('layouts.backend')

@section('title', 'Manajemen Lapangan')
@section('page-title', 'Manajemen Lapangan')

@section('page-actions')
    <a href="{{ route('backend.lapangan.create') }}" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded-lg inline-flex items-center transition-colors duration-200">
        <i class="fas fa-plus mr-2"></i> Tambah Lapangan
    </a>
@endsection

@section('content')
<div class="bg-white/10 backdrop-blur-lg shadow-lg rounded-xl border border-white/10 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="border-b border-white/20">
                <tr>
                    <th class="py-3 px-4 text-left uppercase font-semibold text-sm">Foto</th>
                    <th class="py-3 px-4 text-left uppercase font-semibold text-sm">Nama Lapangan</th>
                    <th class="py-3 px-4 text-left uppercase font-semibold text-sm">Jenis</th>
                    <th class="py-3 px-4 text-left uppercase font-semibold text-sm">Harga/Jam</th>
                    <th class="py-3 px-4 text-right uppercase font-semibold text-sm">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-300">
                @forelse($lapangans as $lapangan)
                <tr class="border-b border-white/10 hover:bg-white/5 transition-colors duration-200">
                    <td class="py-3 px-4">
                        @if($lapangan->foto)
                            <img src="{{ Storage::url($lapangan->foto) }}" 
                                 alt="{{ $lapangan->nama_lapangan }}" 
                                 class="w-16 h-12 object-cover rounded-md">
                        @else
                            <div class="w-16 h-12 bg-gray-700 flex items-center justify-center text-xs text-gray-400 rounded-md">No Image</div>
                        @endif
                    </td>
                    <td class="py-3 px-4 font-semibold">{{ $lapangan->nama_lapangan }}</td>
                    <td class="py-3 px-4">{{ $lapangan->jenis }}</td>
                    <td class="py-3 px-4">{{ $lapangan->formatted_harga }}</td>
                    <td class="py-3 px-4 text-right">
                        <div class="flex justify-end items-center space-x-4">
                            {{-- Tombol Edit --}}
                            <a href="{{ route('backend.lapangan.edit', $lapangan) }}" class="text-yellow-400 hover:text-yellow-300 transition-colors" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            {{-- Tombol Hapus --}}
                            <form action="{{ route('backend.lapangan.destroy', $lapangan) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Yakin ingin menghapus lapangan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-400 transition-colors" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-8">Tidak ada data lapangan. Silakan tambah baru.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-6 border-t border-white/10">
        {{ $lapangans->links() }}
    </div>
</div>
@endsection
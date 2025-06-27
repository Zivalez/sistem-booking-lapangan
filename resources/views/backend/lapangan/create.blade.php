@extends('layouts.backend')

@section('title', 'Tambah Lapangan')
@section('page-title', 'Tambah Lapangan')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('backend.lapangan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="nama_lapangan" class="form-label">Nama Lapangan</label>
                        <input type="text" class="form-control @error('nama_lapangan') is-invalid @enderror" 
                               id="nama_lapangan" name="nama_lapangan" value="{{ old('nama_lapangan') }}" required>
                        @error('nama_lapangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jenis" class="form-label">Jenis</label>
                        <select class="form-select @error('jenis') is-invalid @enderror" id="jenis" name="jenis" required>
                            <option value="">Pilih Jenis</option>
                            <option value="Futsal" {{ old('jenis') == 'Futsal' ? 'selected' : '' }}>Futsal</option>
                            <option value="Badminton" {{ old('jenis') == 'Badminton' ? 'selected' : '' }}>Badminton</option>
                            <option value="Basket" {{ old('jenis') == 'Basket' ? 'selected' : '' }}>Basket</option>
                            <option value="Voli" {{ old('jenis') == 'Voli' ? 'selected' : '' }}>Voli</option>
                            <option value="Tenis" {{ old('jenis') == 'Tenis' ? 'selected' : '' }}>Tenis</option>
                        </select>
                        @error('jenis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="harga_per_jam" class="form-label">Harga per Jam (Rp)</label>
                        <input type="number" class="form-control @error('harga_per_jam') is-invalid @enderror" 
                               id="harga_per_jam" name="harga_per_jam" value="{{ old('harga_per_jam') }}" 
                               min="0" step="1000" required>
                        @error('harga_per_jam')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto Lapangan</label>
                        <input type="file" class="form-control @error('foto') is-invalid @enderror" 
                               id="foto" name="foto" accept="image/*">
                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Format yang didukung: JPEG, PNG, JPG, GIF. Maksimal 2MB.</div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('backend.lapangan.index') }}" class="btn btn-secondary me-md-2">Batal</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
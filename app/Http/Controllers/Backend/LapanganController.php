<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Lapangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LapanganController extends Controller
{
    public function index()
    {
        $lapangans = Lapangan::latest()->paginate(10);
        return view('backend.lapangan.index', compact('lapangans'));
    }

    public function create()
    {
        return view('backend.lapangan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lapangan' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'harga_per_jam' => 'required|integer|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('lapangan', 'public');
        }

        Lapangan::create($data);

        return redirect()->route('backend.lapangan.index')
                        ->with('success', 'Lapangan berhasil ditambahkan.');
    }

    public function show(Lapangan $lapangan)
    {
        return view('backend.lapangan.show', compact('lapangan'));
    }

    public function edit(Lapangan $lapangan)
    {
        return view('backend.lapangan.edit', compact('lapangan'));
    }

    public function update(Request $request, Lapangan $lapangan)
    {
        $request->validate([
            'nama_lapangan' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'harga_per_jam' => 'required|integer|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            // Delete foto lama kalo ada
            if ($lapangan->foto) {
                Storage::disk('public')->delete($lapangan->foto);
            }
            $data['foto'] = $request->file('foto')->store('lapangan', 'public');
        }

        $lapangan->update($data);

        return redirect()->route('backend.lapangan.index')
                        ->with('success', 'Lapangan berhasil diperbarui.');
    }

    public function destroy(Lapangan $lapangan)
    {
        // cek kalo lapangan ini masih memiliki booking
        if ($lapangan->bookings()->count() > 0) {
            return redirect()->route('backend.lapangan.index')
                            ->with('error', 'Lapangan tidak dapat dihapus karena masih memiliki booking.');
        }

        // delete foto jika ada
        if ($lapangan->foto) {
            Storage::disk('public')->delete($lapangan->foto);
        }

        $lapangan->delete();

        return redirect()->route('backend.lapangan.index')
                        ->with('success', 'Lapangan berhasil dihapus.');
    }
}
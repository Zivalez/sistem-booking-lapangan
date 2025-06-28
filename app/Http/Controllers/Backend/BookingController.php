<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Lapangan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with('lapangan')->latest();
        if ($request->filled('start_date')) {
            $query->whereDate('tanggal_booking', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('tanggal_booking', '<=', $request->end_date);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('lapangan_id')) {
            $query->where('lapangan_id', $request->lapangan_id);
        }
        $bookings = $query->paginate(15);
        $lapangans = Lapangan::all();
        return view('backend.booking.index', compact('bookings', 'lapangans'));
    }

    public function create(Request $request)
    {
        $lapangans = Lapangan::all();
        $preData = [
            'lapangan_id' => $request->get('lapangan_id'),
            'tanggal_booking' => $request->get('tanggal_booking'),
            'jam_mulai' => $request->get('jam_mulai'),
        ];
        return view('backend.booking.create', compact('lapangans', 'preData'));
    }

    public function store(Request $request)
    {
        // Validasi dengan aturan baru yang lebih ketat
        $request->validate([
            'lapangan_id' => 'required|exists:lapangans,id',
            'nama_penyewa' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/', // Hanya huruf dan spasi
            'no_hp_penyewa' => 'required|numeric|digits_between:10,15', // Hanya angka, panjang 10-15 digit
            'tanggal_booking' => 'required|date',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ], [
            // Pesan error custom biar lebih ramah
            'nama_penyewa.regex' => 'Nama penyewa hanya boleh berisi huruf dan spasi.',
            'no_hp_penyewa.numeric' => 'Nomor HP hanya boleh berisi angka.',
            'no_hp_penyewa.digits_between' => 'Nomor HP harus antara 10 sampai 15 digit.',
        ]);

        // Cek double booking
        $isBooked = Booking::where('lapangan_id', $request->lapangan_id)
            ->where('tanggal_booking', $request->tanggal_booking)
            ->where('status', '!=', 'Batal')
            ->where(function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('jam_mulai', '<', $request->jam_selesai)
                        ->where('jam_selesai', '>', $request->jam_mulai);
                });
            })->exists();

        if ($isBooked) {
            return back()->withErrors(['jam_mulai' => 'Jadwal di jam ini sudah terisi. Silakan pilih waktu lain.'])->withInput();
        }

        // Hitung total harga
        $lapangan = Lapangan::find($request->lapangan_id);
        $durasi = Carbon::parse($request->jam_selesai)->diffInHours(Carbon::parse($request->jam_mulai));
        $totalHarga = $durasi * $lapangan->harga_per_jam;

        Booking::create(array_merge($request->all(), ['total_harga' => $totalHarga, 'status' => 'Booked']));

        return redirect()->route('backend.booking.index')->with('success', 'Booking berhasil ditambahkan.');
    }

    public function edit(Booking $booking)
    {
        $lapangans = Lapangan::all();
        return view('backend.booking.edit', compact('booking', 'lapangans'));
    }

    public function update(Request $request, Booking $booking)
    {
        // Validasi sama seperti store, tapi bisa juga disesuaikan
        $request->validate([
            'lapangan_id' => 'required|exists:lapangans,id',
            'nama_penyewa' => 'required|string|max:255',
            'no_hp_penyewa' => 'required|string|max:20',
            'tanggal_booking' => 'required|date',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'status' => 'required|in:Booked,Selesai,Batal'
        ]);

        // Hitung ulang total harga
        $lapangan = Lapangan::find($request->lapangan_id);
        $durasi = Carbon::parse($request->jam_selesai)->diffInHours(Carbon::parse($request->jam_mulai));
        $totalHarga = $durasi * $lapangan->harga_per_jam;

        $booking->update(array_merge($request->all(), ['total_harga' => $totalHarga]));

        return redirect()->route('backend.booking.index')->with('success', 'Booking berhasil diperbarui.');
    }


    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('backend.booking.index')->with('success', 'Booking berhasil dihapus.');
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate(['status' => 'required|in:Booked,Selesai,Batal']);
        $booking->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Status booking berhasil diperbarui.');
    }
}

<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $bookings = null;
        $totalPendapatan = 0;
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $bookings = Booking::with('lapangan')
                ->where('status', 'Selesai')
                ->whereBetween('tanggal_booking', [$request->start_date, $request->end_date])
                ->get();
            $totalPendapatan = $bookings->sum('total_harga');
        }
        return view('backend.laporan.index', compact('bookings', 'totalPendapatan'));
    }
}
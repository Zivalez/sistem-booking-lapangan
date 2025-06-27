<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Lapangan;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Ambil tanggal yang dipilih dari filter, atau pake tanggal hari ini
        $selectedDate = $request->get('date', Carbon::today()->format('Y-m-d'));
        $date = Carbon::parse($selectedDate);

        // Ambil semua data lapangan
        $lapangans = Lapangan::all();

        // Ambil semua booking HANYA untuk tanggal yang dipilih
        $bookings = Booking::with('lapangan')
            ->whereDate('tanggal_booking', $date)
            ->get();

        // Buat slot waktu dari jam 8 pagi sampai 10 malam
        $timeSlots = [];
        for ($hour = 8; $hour <= 22; $hour++) {
            $timeSlots[] = sprintf('%02d:00', $hour);
        }

        // Susun data jadi matriks jadwal [jam][lapangan_id]
        $bookingMatrix = [];
        foreach ($timeSlots as $time) {
            foreach ($lapangans as $lapangan) {
                // Cari, ada gak bookingan di jam & lapangan ini?
                $booking = $bookings->first(function($booking) use ($lapangan, $time) {
                    return $booking->lapangan_id == $lapangan->id && 
                           Carbon::parse($booking->jam_mulai)->format('H:i') == $time;
                });

                $bookingMatrix[$time][$lapangan->id] = $booking;
            }
        }

        return view('backend.dashboard', compact(
            'lapangans', 
            'timeSlots', 
            'bookingMatrix', 
            'selectedDate'
        ));
    }
}
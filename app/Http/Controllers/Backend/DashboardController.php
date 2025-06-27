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
        $selectedDate = $request->get('date', Carbon::today()->format('Y-m-d'));
        $date = Carbon::parse($selectedDate);

        $lapangans = Lapangan::all();

        $bookings = Booking::with('lapangan')
            ->whereDate('tanggal_booking', $date)
            ->where('status', '!=', 'Batal') // Ambil yg tidak batal saja
            ->get();

        // Buat slot waktu dari jam 8 pagi sampai 10 malam
        $timeSlots = [];
        for ($hour = 8; $hour <= 22; $hour++) {
            $timeSlots[] = sprintf('%02d:00', $hour);
        }

        // LOGIKA BARU YANG BISA NGITUNG DURASI
        $bookingMatrix = [];
        foreach ($timeSlots as $time) {
            foreach ($lapangans as $lapangan) {
                // Cari booking yang MULAI di jam ini
                $booking = $bookings->first(function($b) use ($lapangan, $time) {
                    return $b->lapangan_id == $lapangan->id &&
                           $time == Carbon::parse($b->jam_mulai)->format('H:i');
                });

                // Hitung durasi booking dalam jam
                $duration = $booking ? Carbon::parse($booking->jam_selesai)->diffInHours(Carbon::parse($booking->jam_mulai)) : 0;

                $bookingMatrix[$time][$lapangan->id] = [
                    'booking' => $booking,
                    'duration' => $duration,
                ];
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
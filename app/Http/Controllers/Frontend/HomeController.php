<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Lapangan;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $selectedDate = $request->get('date', Carbon::today()->format('Y-m-d'));
        $date = Carbon::parse($selectedDate);

        $lapangans = Lapangan::all();

        $bookings = Booking::with('lapangan')
            ->whereDate('tanggal_booking', $date)
            ->get();

        $timeSlots = [];
        for ($hour = 8; $hour <= 22; $hour++) {
            $timeSlots[] = sprintf('%02d:00', $hour);
        }

        $bookingMatrix = [];
        foreach ($timeSlots as $time) {
            foreach ($lapangans as $lapangan) {
                $booking = $bookings->first(function($booking) use ($lapangan, $time) {
                    return $booking->lapangan_id == $lapangan->id && 
                           Carbon::parse($booking->jam_mulai)->format('H:i') == $time;
                });

                $bookingMatrix[$time][$lapangan->id] = $booking;
            }
        }

        return view('frontend.home', compact(
            'lapangans', 
            'timeSlots', 
            'bookingMatrix', 
            'selectedDate'
        ));
    }
}
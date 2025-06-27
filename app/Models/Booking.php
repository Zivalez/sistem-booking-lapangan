<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'lapangan_id',
        'nama_penyewa',
        'no_hp_penyewa',
        'tanggal_booking',
        'jam_mulai',
        'jam_selesai',
        'total_harga',
        'status'
    ];

    protected $casts = [
        'tanggal_booking' => 'date',
        'jam_mulai' => 'datetime:H:i',
        'jam_selesai' => 'datetime:H:i',
    ];

    public function lapangan()
    {
        return $this->belongsTo(Lapangan::class);
    }

    public function getFormattedTotalHargaAttribute()
    {
        return 'Rp ' . number_format($this->total_harga, 0, ',', '.');
    }

    public function getDurasiAttribute()
    {
        $mulai = \Carbon\Carbon::parse($this->jam_mulai);
        $selesai = \Carbon\Carbon::parse($this->jam_selesai);
        return $mulai->diffInHours($selesai);
    }
}
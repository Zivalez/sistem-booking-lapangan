<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lapangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_lapangan',
        'jenis',
        'harga_per_jam',
        'foto'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getFormattedHargaAttribute()
    {
        return 'Rp ' . number_format($this->harga_per_jam, 0, ',', '.');
    }
}
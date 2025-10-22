<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    use HasFactory;

    protected $fillable = [
        'model',
        'merek',
        'tipe',
        'tahun',
        'harga',
        'stok',
        'user_id',
    ];

    /**
     * 🔗 Relasi ke model User (admin yang menambahkan mobil)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 🔗 Relasi ke Penjualan (mobil ini bisa muncul di banyak transaksi)
     */
    public function penjualans()
    {
        return $this->hasMany(Penjualan::class);
    }
}

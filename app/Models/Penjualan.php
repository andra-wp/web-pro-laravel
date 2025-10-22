<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $fillable = ['user_id', 'mobil_id', 'harga'];

    public function mobil() {
        return $this->belongsTo(Mobil::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}


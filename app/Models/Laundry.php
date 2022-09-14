<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laundry extends Model
{
    use HasFactory;

    protected $fillable = ['counter_id', 'no_invoice', 'tanggal_input', 'jumlah_item', 
    'jumlah_item_selesai', 'total', 'status', 'keterangan', 'tanggal_selesai', 'catatan', 'menggunakan_kartu_spotting'];

    public function counter(){
        return $this->belongsTo(Counter::class, 'counter_id');
    }
}

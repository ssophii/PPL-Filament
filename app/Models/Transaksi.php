<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use NumberFormatter;

class Transaksi extends Model
{
    use HasFactory;
    protected $fillable = [
        'anggota_id',
        'tanggal',      //date
        'tipe',         //enum
        'keterangan',   //string
        'nominal',      //integer
        'bukti',        //image dan file
        'konfirmasi'    //boolean
    ];

    public function getNominalFormattedAttribute()
    {
        $formatter = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);
        return $formatter->format($this->nominal);
    }

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }
}

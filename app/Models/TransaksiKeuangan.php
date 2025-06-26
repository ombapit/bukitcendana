<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiKeuangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'tipe',
        'kategori',
        'deskripsi',
        'jumlah',
        'bukti',
        'ipl_id',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah' => 'decimal:2',
    ];

    public function ipl()
    {
        return $this->belongsTo(Ipl::class, 'ipl_id');
    }
}

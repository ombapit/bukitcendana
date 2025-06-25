<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tunggakan extends Model
{
    use HasFactory;

    protected $table = "v_tunggakan";

    // Mass assignable fields
    protected $fillable = [
        'nama',
        'alamat',
        'no_hp',
        'tanggal_lahir',
        'jenis_kelamin',
        'status_keluarga',
        'is_kepala_keluarga',
        'jumlah_tunggakan',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'is_kepala_keluarga' => 'boolean',
    ];    
}

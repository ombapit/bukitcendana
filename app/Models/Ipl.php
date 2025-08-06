<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

function bulanIndonesiaFromAngka(int $angka): string
{
    return \Carbon\Carbon::create()->locale('id')->month($angka)->translatedFormat('F');
}

class Ipl extends Model
{
    use HasFactory;

    protected $fillable = [
        'warga_id',
        'bulan',
        'tahun',
        'jumlah',
        'catatan',
        'status_pembayaran',
        'tanggal_bayar',
    ];

    protected $casts = [
        'tanggal_bayar' => 'date',
    ];    

    protected static function booted(): void
    {
        static::created(function ($pembayaran) {
            $pembayaran->transaksi()->create([
                'tanggal' => $pembayaran->tanggal_bayar,
                'tipe' => 'pemasukan',
                'kategori' => 'Pembayaran IPL',
                'deskripsi' => 'IPL ' . bulanIndonesiaFromAngka($pembayaran->bulan) . ' ' . $pembayaran->tahun . ' - ' . $pembayaran->warga->nama,
                'jumlah' => $pembayaran->jumlah,
            ]);
        });

        static::updated(function ($pembayaran) {
            if ($pembayaran->transaksi) {
                $pembayaran->transaksi->update([
                    'tanggal' => $pembayaran->tanggal_bayar,
                    'jumlah' => $pembayaran->jumlah,
                    'deskripsi' => 'IPL ' . bulanIndonesiaFromAngka($pembayaran->bulan) . ' ' . $pembayaran->tahun . ' - ' . $pembayaran->warga->nama,
                ]);
            } else {
                // Jika belum ada transaksi terkait → buat baru
                $pembayaran->transaksi()->create([
                    'tanggal' => $pembayaran->tanggal_bayar,
                    'tipe' => 'pemasukan',
                    'kategori' => 'Pembayaran IPL',
                    'deskripsi' => 'IPL ' . bulanIndonesiaFromAngka($pembayaran->bulan) . ' ' . $pembayaran->tahun . ' - ' . $pembayaran->warga->nama,
                    'jumlah' => $pembayaran->jumlah,
                ]);
            }
        });

        static::deleted(function ($pembayaran) {
            $pembayaran->transaksi()->delete();
        });
    }

    // Relasi ke Warga
    public function warga()
    {
        return $this->belongsTo(Warga::class);
    }

    public function transaksi()
    {
        return $this->hasOne(TransaksiKeuangan::class, 'ipl_id');
    }
}

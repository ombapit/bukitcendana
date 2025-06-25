<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiKeuangan;
use Illuminate\Support\Carbon;

class TransaksiKeuanganController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->get('bulan', now()->format('m'));
        $tahun = $request->get('tahun', now()->format('Y'));
        $tipe = $request->get('tipe', '');

        $data = TransaksiKeuangan::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->when($tipe != '', fn($query) => $query->where('tipe', $tipe))
            ->orderBy('tanggal', 'desc')
            ->get();

        $total_pemasukan = $data->where('tipe', 'pemasukan')->sum('jumlah');
        $total_pengeluaran = $data->where('tipe', 'pengeluaran')->sum('jumlah');

        return view('transaksi-keuangan.index', compact('data', 'bulan', 'tahun', 'tipe', 'total_pemasukan', 'total_pengeluaran'));
    }
}

<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Ipl; // Import model Ipl
use Illuminate\Support\Facades\Validator; // Import Validator
use Carbon\Carbon; // Import Carbon untuk tanggal
use App\Http\Controllers\Controller;

class IplController extends Controller
{
    /**
     * Store a newly created payment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'warga_id' => 'required|exists:wargas,id', // Pastikan warga_id ada di tabel wargas
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000|max:' . (date('Y') + 5), // Contoh range tahun
            'jumlah' => 'required|numeric|min:0',            
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422); // Kode status 422 untuk Unprocessable Entity
        }

        try {
            // Buat instance Ipl baru dan simpan ke database
            $pembayaran = Ipl::create([
                'warga_id' => $request->warga_id,
                'bulan' => $request->bulan,
                'tahun' => $request->tahun,
                'jumlah' => $request->jumlah,
                'catatan' => $request->catatan,
                'tanggal_bayar' => Carbon::now()->format('Y-m-d'), // Otomatis diisi tanggal saat ini
            ]);

            // Berikan respons berhasil
            return response()->json([
                'message' => 'Ipl berhasil ditambahkan',
                'data' => $pembayaran
            ], 201); // Kode status 201 untuk Created
        } catch (\Exception $e) {
            // Tangani kesalahan jika terjadi masalah saat menyimpan ke database
            return response()->json([
                'message' => 'Gagal menambahkan pembayaran',
                'error' => $e->getMessage()
            ], 500); // Kode status 500 untuk Internal Server Error
        }
    }

    /**
     * Display a listing of the payments.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Mengambil semua data pembayaran beserta data warganya
        $pembayarans = Ipl::with('warga')->get();
        return response()->json($pembayarans);
    }
}
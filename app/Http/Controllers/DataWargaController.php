<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Warga;

class DataWargaController extends Controller
{
    public function index(Request $request)
    {
        // Ambil nilai filter dari request
        $nama = $request->input('nama');
        $alamat = $request->input('alamat');

        // Query dasar
        $query = Warga::query();

        // Filter berdasarkan nama jika ada
        if (!empty($nama)) {
            $query->where('nama', 'like', '%' . $nama . '%');
        }

        // Filter berdasarkan alamat jika ada
        if (!empty($alamat)) {
            $query->where('alamat', 'like', '%' . $alamat . '%');
        }

        // Ambil data warga (bisa ditambahkan pagination kalau perlu)
        $wargas = $query->orderBy('nama', 'asc')->paginate(60);

        // Kirim ke view (atau nanti kita sesuaikan sesuai instruksi)
        return view('data-warga.index', compact('wargas', 'nama', 'alamat'));
    }
}
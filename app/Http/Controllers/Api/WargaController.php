<?php

namespace App\Http\Controllers\Api;

use App\Models\Warga;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WargaController extends Controller
{
  public function index()
  {
    return Warga::orderBy('nama', 'asc')->get();
  }

  public function store(Request $request)
  {
    $data = $request->validate([
      'nama' => 'required|string|max:255',
      'alamat' => 'required|string',
      'no_hp' => 'nullable|string|max:20',
      'tanggal_lahir' => 'nullable|date',
      'jenis_kelamin' => 'nullable|in:L,P',
      'status_keluarga' => 'nullable|string|max:255',
      'is_kepala_keluarga' => 'boolean',
    ]);

    $warga = Warga::create($data);
    return response()->json($warga, 201);
  }

  public function show($id)
  {
    return Warga::findOrFail($id);
  }

  public function update(Request $request, $id)
  {
    $warga = Warga::findOrFail($id);

    $data = $request->validate([
      'nama' => 'required|string|max:255',
      'alamat' => 'required|string',
      'no_hp' => 'nullable|string|max:20',
      'tanggal_lahir' => 'nullable|date',
      'jenis_kelamin' => 'required|in:L,P',
      'status_keluarga' => 'nullable|string|max:255',
      'is_kepala_keluarga' => 'boolean',
    ]);

    $warga->update($data);
    return response()->json($warga);
  }

  public function destroy($id)
  {
    $warga = Warga::findOrFail($id);
    $warga->delete();

    return response()->json(null, 204);
  }
}


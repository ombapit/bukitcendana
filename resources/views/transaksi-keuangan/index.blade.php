@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
  <h2 class="text-2xl font-bold mb-6">Transaksi Keuangan</h2>

  <!-- Filter Bulan dan Tahun -->
  <form method="GET" class="flex flex-wrap gap-4 mb-6 items-end">
    <div>
      <label class="block text-sm text-white">Bulan</label>
      <select name="bulan" class="rounded border-gray-300 text-gray-900 px-4 py-2 text-base">   
        @foreach(range(1,12) as $b)
          <option value="{{ str_pad($b,2,'0',STR_PAD_LEFT) }}" @selected($bulan == str_pad($b,2,'0',STR_PAD_LEFT))>
            {{ bulanIndo($b) }}
          </option>
        @endforeach
      </select>
    </div>

    <div>
      <label class="block text-sm text-white">Tahun</label>
      <select name="tahun" class="rounded border-gray-300 text-gray-900 px-4 py-2 text-base">
        @foreach(range(now()->year, 2020) as $y)
          <option value="{{ $y }}" @selected($tahun == $y)>{{ $y }}</option>
        @endforeach
      </select>
    </div>

    <div>
      <label class="block text-sm text-white">Tipe</label>
      <select name="tipe" class="rounded border-gray-300 text-gray-900 px-4 py-2 text-base">
        <option value="">--Semua--</option>
        <option value="pemasukan" @selected($tipe == "pemasukan")>Pemasukan</option>
        <option value="pengeluaran" @selected($tipe == "pengeluaran")>Pengeluaran</option>
      </select>
    </div>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Tampilkan</button>
  </form>

  <!-- Table -->
  <div class="overflow-x-auto bg-white rounded shadow">
    <table class="min-w-full text-sm text-gray-800">
      <thead class="bg-gray-200 text-left">
        <tr>
          <th class="px-4 py-2">Tanggal</th>
          <th class="px-4 py-2">Tipe</th>
          <th class="px-4 py-2">Kategori</th>
          <th class="px-4 py-2 text-right">Jumlah (Rp)</th>
          <th class="px-4 py-2">Catatan</th>
        </tr>
      </thead>
      <tbody>
        @forelse($data as $item)
          <tr class="border-b hover:bg-gray-50">
            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
            <td class="px-4 py-2 capitalize">{{ $item->tipe }}</td>
            <td class="px-4 py-2">{{ $item->kategori ?? '-' }}</td>
            <td class="px-4 py-2 text-right {{ $item->tipe === 'pemasukan' ? 'text-green-600' : 'text-red-600' }}">
              {{ number_format($item->jumlah, 0, ',', '.') }}
            </td>
            <td class="px-4 py-2">{{ $item->catatan ?? '-' }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="px-4 py-4 text-center text-gray-500">Tidak ada data</td>
          </tr>
        @endforelse
      </tbody>
      <tfoot class="bg-gray-100 font-semibold">
        <tr>
          <td colspan="3" class="px-4 py-2 text-right">Total Pemasukan</td>
          <td colspan="2" class="px-4 py-2 text-right text-green-700">
            Rp {{ number_format($total_pemasukan ?? 0, 0, ',', '.') }}
          </td>
        </tr>
        <tr>
          <td colspan="3" class="px-4 py-2 text-right">Total Pengeluaran</td>
          <td colspan="2" class="px-4 py-2 text-right text-red-700">
            Rp {{ number_format($total_pengeluaran ?? 0, 0, ',', '.') }}
          </td>
        </tr>
      </tfoot>
    </table>
  </div>
</div>
@endsection
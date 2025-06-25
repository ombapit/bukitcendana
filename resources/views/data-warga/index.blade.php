@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
  <h2 class="text-2xl font-bold mb-6">Data Warga</h2>

  {{-- Form Filter --}}
  <form method="GET" action="{{ url('/data-warga') }}" class="mb-6 flex flex-col md:flex-row gap-4">
    <input type="text" name="nama" placeholder="Cari Nama" value="{{ request('nama') }}"
      class="w-full md:w-1/3 border rounded px-3 py-2 text-gray-800">
    <input type="text" name="alamat" placeholder="Cari Alamat" value="{{ request('alamat') }}"
      class="w-full md:w-1/3 border rounded px-3 py-2 text-gray-800">
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Cari</button>
  </form>

  {{-- Cards --}}
  <div class="flex flex-wrap gap-4 justify-start">
    @foreach ($wargas as $warga)
        <div class="bg-white shadow rounded-lg p-4 w-full sm:w-full md:w-1/2 lg:w-[16.6%]">
        <h3 class="text-lg font-semibold mb-2 text-gray-800">{{ $warga->nama }}</h3>
        <p class="text-sm text-gray-600"><strong>Alamat:</strong> {{ $warga->alamat }}</p>
        <p class="text-sm text-gray-600"><strong>HP:</strong> {{ $warga->no_hp }}</p>
        <p class="text-sm text-gray-600"><strong>Lahir:</strong> {{ \Carbon\Carbon::parse($warga->tanggal_lahir)->translatedFormat('d F Y') }}</p>
        <p class="text-sm text-gray-600"><strong>Jenis Kelamin:</strong> {{ ucfirst($warga->jenis_kelamin) }}</p>
        <p class="text-sm text-gray-600"><strong>Status Keluarga:</strong> {{ ucfirst($warga->status_keluarga) }}</p>
        <p class="text-sm text-gray-600"><strong>Kepala Keluarga:</strong> 
            @if($warga->is_kepala_keluarga)
            <span class="text-green-600 font-semibold">Ya</span>
            @else
            <span class="text-red-600 font-semibold">Tidak</span>
            @endif
        </p>
        </div>
    @endforeach
  </div>

  {{-- Tombol/indikator loading untuk Infinite Scroll --}}
  <div id="scroll-loader" class="text-center my-6">
    @if ($wargas->hasMorePages())
      <button id="load-more" class="bg-gray-200 px-4 py-2 rounded">Muat Lebih Banyak...</button>
    @endif
  </div>
</div>
@endsection

@section('scripts')
<script>
let page = 2;
const loadMoreBtn = document.getElementById('load-more');
const container = document.getElementById('warga-container');
const loader = document.getElementById('scroll-loader');

function fetchNextPage() {
  loadMoreBtn.disabled = true;
  loadMoreBtn.innerText = 'Memuat...';

  const params = new URLSearchParams(window.location.search);
  params.set('page', page);

  fetch(`?${params.toString()}`, {
    headers: { 'X-Requested-With': 'XMLHttpRequest' }
  })
    .then(res => res.text())
    .then(html => {
      const parser = new DOMParser();
      const nextCards = parser.parseFromString(html, 'text/html')
                              .querySelectorAll('#warga-container > div');

      if (nextCards.length === 0) {
        loader.innerHTML = '<p class="text-gray-500">Tidak ada data lagi.</p>';
        return;
      }

      nextCards.forEach(card => container.appendChild(card));
      loadMoreBtn.disabled = false;
      loadMoreBtn.innerText = 'Muat Lebih Banyak...';
      page++;
    });
}

if (loadMoreBtn) {
  loadMoreBtn.addEventListener('click', fetchNextPage);
}
</script>
@endsection

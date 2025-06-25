@extends('layouts.app')

@section('content')
  <!-- Hero -->
  <section class="bg-white text-gray-800 py-20 text-center shadow-lg">
    <h2 class="text-4xl font-bold mb-4">Selamat Datang di {{ config('app.name') }}</h2>
    <p class="text-lg text-gray-600">Webnya warga Bukit Cendana</p>
  </section>

  <!-- 2 Column Card -->
  <section class="container mx-auto px-4 py-12">
    <div class="grid md:grid-cols-2 gap-8">
        
        <!-- Card 1 -->
        <div class="bg-gray-50 shadow rounded-lg p-6 text-gray-800 flex items-start gap-4">
        <!-- Icon -->
        <div class="flex-shrink-0">
            <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M3 3h18v6H3V3zM3 9h18v12H3V9zM7 15h4m-2-2v4"/>
            </svg>
        </div>
        <!-- Text -->
        <div>
            <h3 class="text-xl font-semibold mb-1 text-purple-600"><a href="{{ url('/transaksi-keuangan') }}">Transaksi Keuangan</a></h3>
            <p class="text-gray-600">Pantau seluruh pemasukan dan pengeluaran secara transparan.</p>
        </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-gray-50 shadow rounded-lg p-6 text-gray-800 flex items-start gap-4">
        <!-- Icon -->
        <div class="flex-shrink-0">
            <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M17 20h5v-2a3 3 0 00-5.356-1.857M9 20H4v-2a3 3 0 015.356-1.857M16 7a4 4 0 11-8 0 4 4 0 018 0zm6 4v4m0 0h-4m4 0l-2-2m2 2l-2 2"/>
            </svg>
        </div>
        <!-- Text -->
        <div>
            <h3 class="text-xl font-semibold mb-1 text-purple-600">Data Warga</h3>
            <p class="text-gray-600">Informasi warga secara terpusat dan terstruktur.</p>
        </div>
        </div>

    </div>
</section>
@endsection
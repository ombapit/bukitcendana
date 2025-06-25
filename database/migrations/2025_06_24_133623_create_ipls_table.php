<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ipls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warga_id')->constrained()->cascadeOnDelete();
            $table->integer('bulan');
            $table->integer('tahun');
            $table->decimal('jumlah', 15, 2)->default(0);
            $table->string('catatan')->nullable();
            $table->enum('status_pembayaran', ['belum', 'sudah'])->default('sudah');
            $table->date('tanggal_bayar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ipls');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengembalians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peminjaman_id')->constrained('peminjamans')->onDelete('restrict');
            $table->foreignId('petugas_id')->constrained('users')->onDelete('restrict');
            $table->date('tanggal_pengembalian');
            $table->integer('hari_terlambat')->default(0);
            $table->decimal('denda', 10, 2)->default(0);
            $table->enum('kondisi_buku', ['baik', 'rusak_ringan', 'rusak_berat', 'hilang'])->default('baik');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengembalians');
    }
};

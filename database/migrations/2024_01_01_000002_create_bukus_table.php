<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bukus', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('penulis');
            $table->string('penerbit')->nullable();
            $table->string('isbn')->unique()->nullable();
            $table->year('tahun_terbit')->nullable();
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('restrict');
            $table->string('lokasi_rak')->nullable();
            $table->integer('stok')->default(1);
            $table->integer('stok_tersedia')->default(1);
            $table->text('deskripsi')->nullable();
            $table->string('sampul')->nullable(); // image path
            $table->enum('status', ['tersedia', 'dipinjam', 'tidak_tersedia'])->default('tersedia');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};

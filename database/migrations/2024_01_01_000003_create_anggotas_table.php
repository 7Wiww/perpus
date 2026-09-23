<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anggotas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('no_anggota')->unique(); // e.g. AGT0001
            $table->string('nim_nip')->nullable()->unique();
            $table->string('no_telepon')->nullable();
            $table->text('alamat')->nullable();
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan'])->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('program_studi')->nullable();
            $table->string('fakultas_instansi')->nullable();
            $table->enum('jenis_anggota', ['mahasiswa', 'dosen', 'staff', 'umum'])->default('mahasiswa');
            $table->date('tanggal_bergabung')->nullable();
            $table->enum('status', ['aktif', 'nonaktif', 'diblokir'])->default('aktif');
            $table->string('foto')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggotas');
    }
};

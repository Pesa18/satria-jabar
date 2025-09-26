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
        Schema::create('layanan_halals', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('no_layanan')->unique();
            $table->foreignId('team_satria_id')->constrained('team_satria')->onDelete('cascade');
            $table->foreignId('p3h_id')->constrained('p3h_user')->onDelete('cascade')->nullable();
            $table->string('NIK')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('nama_pemohon');
            $table->string('email');
            $table->string('no_hp');
            $table->string('nama_usaha')->nullable();
            $table->string('alamat_lengkap')->nullable();
            $table->string('NIB')->nullable();
            $table->string('catatan')->nullable();
            $table->integer('kabupaten_id')->nullable();
            $table->integer('kecamatan_id')->nullable();
            $table->enum('klasifikasi_usaha', ['mikro', 'kecil', 'menengah', 'besar'])->nullable();
            $table->foreignId('status_layanan_id')->constrained('status_layanan')->onDelete('cascade')->nullable()->default(1);
            $table->enum('layanan_halal', ['selfdeclare', 'reguler'])->default('selfdeclare')->nullable();
            $table->enum('jenis_usaha', ['makanan', 'minuman', 'kosmetik', 'farmasi', 'jasa', 'barang gunaan', 'produk kimiawi', 'produk biologi', 'lainnya'])->nullable();
            $table->string('foto_pelayanan')->nullable();
            $table->string('dokumen_pengajuan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanan_halals');
    }
};

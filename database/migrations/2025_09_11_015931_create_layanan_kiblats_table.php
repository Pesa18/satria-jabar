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
        Schema::create('layanan_kiblats', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('no_layanan')->unique();
            $table->foreignId('team_satria_id')->constrained('team_satria')->onDelete('cascade');
            $table->foreignId('kua_id')->nullable()->constrained('kua_user')->onDelete('cascade');
            $table->string('nama_pemohon');
            $table->string('NIK')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('email');
            $table->string('no_hp');
            $table->string('alamat_lengkap')->nullable();
            $table->string('nama_masjid')->nullable();
            $table->string('alamat_masjid')->nullable();
            $table->integer('kabupaten_id')->nullable();
            $table->integer('kecamatan_id')->nullable();
            $table->enum('jenis_layanan', ['id_masjid', 'perubahan_data'])->nullable();
            $table->string('catatan')->nullable();
            $table->foreignId('status_layanan_id')->nullable()->constrained('status_layanan')->onDelete('cascade');
            $table->string('dokumnen_pengajuan')->nullable();
            $table->string('foto_pelayanan')->nullable();
            $table->string('dokumen_output')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanan_kiblats');
    }
};

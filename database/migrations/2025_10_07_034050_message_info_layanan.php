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
        Schema::create('message_info_layanan', function (Blueprint $table) {
            $table->id()->primary();
            $table->foreignId('layanan_halal_id')->nullable()->constrained('layanan_halals')->onDelete('cascade');
            $table->foreignId('layanan_kiblat_id')->nullable()->constrained('layanan_masjids')->onDelete('cascade');
            $table->foreignId('layanan_masjid_id')->nullable()->constrained('layanan_kiblats')->onDelete('cascade');
            $table->string('status');
            $table->string('last_message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_info_layanan');
    }
};

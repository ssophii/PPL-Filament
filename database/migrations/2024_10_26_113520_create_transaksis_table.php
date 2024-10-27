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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->default(now());
            $table->enum('tipe', ['Debit', 'Kredit']);
            $table->decimal('nominal', 15, 0)->default(0);
            $table->string('keterangan');
            $table->binary('bukti')->nullable();
            $table->foreignId('anggota_id')->constrained('anggotas');
            $table->boolean('konfirmasi')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};

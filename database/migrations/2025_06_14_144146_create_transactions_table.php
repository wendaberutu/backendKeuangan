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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->timestamp('waktu')->useCurrent();
            $table->string('kode_akun', 10);
            $table->string('nama_transaksi');
            $table->text('keterangan')->nullable();
            $table->decimal('nominal', 15, 2);
            $table->enum('tipe_transaksi', ['masuk', 'keluar']); // masuk = debit, keluar = kredit
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreign('kode_akun')->references('kode_akun')->on('accounts')->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

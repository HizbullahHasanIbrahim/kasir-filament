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
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pelanggan')
                ->constrained('pelanggans')
                ->onDelete('cascade');
            $table->foreignId('id_user')
                ->constrained('users')
                ->onDelete('cascade');;
            $table->decimal('diskon', 8, 2);
            $table->decimal('total_harga', 8, 2);
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualans');
    }
};

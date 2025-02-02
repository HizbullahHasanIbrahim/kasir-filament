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
        Schema::create('detail_penjualans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_penjualan')
                ->constrained('penjualans')
                ->onDelete('cascade');;
            $table->foreignId('id_produk')
                ->constrained('produks')
                ->onDelete('cascade');;
            $table->decimal('harga_jual', 8 ,2);
            $table->integer('qty');
            $table->decimal('sub_total', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_penjualans');
    }
};

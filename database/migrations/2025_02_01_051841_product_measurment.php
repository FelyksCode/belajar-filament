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
        Schema::create('product_measurments', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable();

            $table->foreignId('id_barcode');
            $table->foreignId('id_employee');

            $table->foreign('id_barcode')->references('id_barcode')->on('products');
            $table->foreign('id_employee')->references('id_employee')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_measurments');
    }
};

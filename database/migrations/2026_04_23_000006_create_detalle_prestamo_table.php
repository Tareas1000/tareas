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
        Schema::create('Detalle_Prestamo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_prestamo');
            $table->unsignedBigInteger('id_libro');
            $table->foreign('id_prestamo')->references('id')->on('Prestamos');
            $table->foreign('id_libro')->references('id')->on('Libros');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Detalle_Prestamo');
    }
};

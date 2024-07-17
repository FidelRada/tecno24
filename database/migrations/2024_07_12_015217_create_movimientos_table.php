<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            $table->string('motivo');
            $table->dateTime('fecha');
            $table->unsignedBigInteger('id_tipo');
            $table->unsignedBigInteger('id_proveedor')->nullable();
            $table->unsignedBigInteger('id_personal');
            $table->timestamps();

            $table->foreign('id_tipo')
                ->references('id')
                ->on('tipo_movimientos')
                ->onDelete('set null');

            $table->foreign('id_proveedor')
                ->references('id')
                ->on('proveedors')
                ->onDelete('set null');

            $table->foreign('id_personal')
                ->references('id')
                ->on('personals')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};

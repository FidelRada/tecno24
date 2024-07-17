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
        Schema::create('detalle_insumos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cantidad');
            $table->unsignedBigInteger('id_insumo');
            $table->unsignedBigInteger('id_movimiento');
            $table->timestamps();

            $table->foreign('id_insumo')
                ->references('id')
                ->on('insumos')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('id_movimiento')
                ->references('id')
                ->on('movimientos')
                ->onDelete('set null')
                ->onUpdate('cascade');

        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_insumos');
    }
};

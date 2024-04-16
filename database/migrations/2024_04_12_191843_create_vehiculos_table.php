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
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('marca_id');
            $table->foreignId('modelo_id');
            $table->string('color');
            $table->string('tipo');
            $table->string('combustible');
            $table->string('traccion');
            $table->string('vin');
            $table->integer('no');
            $table->string('patente');
            $table->integer('sector');
            $table->timestamps();
            $table->string('veh_imagen');
            $table->foreignId('user_id');
            $table->date('rev_tec');
            $table->boolean('estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehiculos');
    }
};

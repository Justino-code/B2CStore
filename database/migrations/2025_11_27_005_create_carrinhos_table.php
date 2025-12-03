<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('carrinhos', function (Blueprint $table) {
            $table->id('id_carrinho');
            $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('carrinhos');
    }
};
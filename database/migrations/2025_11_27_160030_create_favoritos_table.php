<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('favoritos', function (Blueprint $table) {
            $table->id('id_favorito');
            $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario');
            $table->foreignId('id_produto')->constrained('produtos', 'id_produto');
            $table->timestamps();

            $table->unique(['id_usuario', 'id_produto']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('favoritos');
    }
};
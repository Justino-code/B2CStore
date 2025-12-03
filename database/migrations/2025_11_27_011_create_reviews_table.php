<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id('id_review');
            $table->foreignId('id_produto')->constrained('produtos', 'id_produto');
            $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario');
            $table->integer('rating')->unsigned()->between(1, 5);
            $table->text('comentario')->nullable();
            $table->boolean('aprovado')->default(false);
            $table->timestamps();

            $table->unique(['id_produto', 'id_usuario']);
            $table->index(['aprovado', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};
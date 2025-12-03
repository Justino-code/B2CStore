<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('produto_imagens', function (Blueprint $table) {
            $table->id('id_imagem');
            $table->unsignedBigInteger('id_produto');
            $table->foreign('id_produto')->references('id_produto')->on('produtos')->onDelete('cascade');
            $table->string('url_imagem');
            $table->integer('ordem')->default(0);
            $table->boolean('principal')->default(false);
            $table->timestamps();

            $table->index(['id_produto', 'principal']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('produto_imagens');
    }
};

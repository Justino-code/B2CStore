<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('carrinho_itens', function (Blueprint $table) {
            $table->id('id_item_carrinho');
            $table->foreignId('id_carrinho')->constrained('carrinhos', 'id_carrinho')->onDelete('cascade');
            $table->foreignId('id_produto')->constrained('produtos', 'id_produto');
            $table->integer('quantidade');
            $table->decimal('preco_unitario', 10, 2);
            $table->timestamps();

            $table->unique(['id_carrinho', 'id_produto']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('carrinho_itens');
    }
};
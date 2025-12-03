<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pedido_itens', function (Blueprint $table) {
            $table->id('id_item_pedido');
            $table->foreignId('id_pedido')->constrained('pedidos', 'id_pedido')->onDelete('cascade');
            $table->foreignId('id_produto')->constrained('produtos', 'id_produto');
            $table->integer('quantidade');
            $table->decimal('preco_unitario', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pedido_itens');
    }
};
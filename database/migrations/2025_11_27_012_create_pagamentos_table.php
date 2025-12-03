<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pagamentos', function (Blueprint $table) {
            $table->id('id_pagamento');
            $table->foreignId('id_pedido')->constrained('pedidos', 'id_pedido');
            $table->enum('metodo', ['cartao', 'pix', 'boleto', 'transferencia']);
            $table->enum('status', ['pendente', 'pago', 'falhou', 'reembolsado'])->default('pendente');
            $table->decimal('valor', 10, 2);
            $table->string('transacao_id')->nullable();
            $table->json('detalhes')->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('pagamentos');
    }
};
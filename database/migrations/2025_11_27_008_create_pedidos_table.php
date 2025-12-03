<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id('id_pedido');
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_cupom')->nullable();
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('cascade');
            $table->foreign('id_cupom')->nullable()->references('id_cupom')->on('cupons')->onDelete('set null');
            $table->string('codigo_pedido', 20)->unique();
            $table->decimal('total', 10, 2);
            $table->decimal('custo_envio', 8, 2)->default(0.00);
            $table->decimal('valor_desconto', 10, 2)->default(0.00);
            $table->enum('status', ['pendente', 'pago', 'processando', 'enviado', 'entregue', 'cancelado'])->default('pendente');
            $table->text('endereco_entrega');
            $table->string('metodo_envio', 50)->nullable();
            $table->timestamp('data_entrega')->nullable();
            $table->text('observacoes')->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
};

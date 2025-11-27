<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id('id_produto');
            $table->foreignId('id_categoria')->constrained('categorias', 'id_categoria');
            $table->string('nome', 200);
            $table->text('descricao')->nullable();
            $table->decimal('preco', 10, 2);
            $table->decimal('preco_promocional', 10, 2)->nullable();
            $table->string('sku', 100)->unique();
            $table->integer('estoque')->default(0);
            $table->decimal('peso', 8, 2)->nullable();
            $table->string('dimensoes', 100)->nullable();
            $table->string('slug', 255)->unique();
            $table->boolean('ativo')->default(true);
            $table->boolean('destaque')->default(false);
            $table->timestamps();

            // Índices
            $table->index(['ativo', 'destaque']);
            $table->fullText(['nome', 'descricao']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('produtos');
    }
};
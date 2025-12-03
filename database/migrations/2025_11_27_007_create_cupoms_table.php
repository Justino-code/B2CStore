<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cupons', function (Blueprint $table) {
            $table->id('id_cupom');
            $table->string('codigo', 50)->unique();
            $table->enum('tipo_desconto', ['percentual', 'fixo']);
            $table->decimal('valor_desconto', 10, 2);
            $table->decimal('valor_minimo', 10, 2)->nullable();
            $table->integer('usos_maximos')->nullable();
            $table->integer('usos_atual')->default(0);
            $table->timestamp('validade_inicio')->nullable();
            $table->timestamp('validade_fim')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();

            $table->index(['ativo', 'validade_fim']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('cupons');
    }
};
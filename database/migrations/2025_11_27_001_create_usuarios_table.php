<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->string('nome', 150);
            $table->string('email', 150)->unique();
            $table->timestamp('email_verificado_em')->nullable();
            $table->string('senha');
            $table->string('telefone', 20)->nullable();
            $table->text('endereco')->nullable();
            $table->string('avatar_url')->nullable();
            $table->enum('status', ['ativo', 'inativo', 'bloqueiado'])->default('ativo');
            $table->string('remember_token', 100)->nullable();
            $table->enum('role', ['cliente', 'admin', 'gerente', 'operador', 'suporte'])->default('cliente');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
};

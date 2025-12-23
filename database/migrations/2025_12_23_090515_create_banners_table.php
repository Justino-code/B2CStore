<?php
// database/migrations/2024_12_01_000001_create_banners_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id('id_banner');
            $table->string('titulo', 200);
            $table->string('subtitulo', 200)->nullable();
            $table->text('descricao')->nullable();
            $table->string('imagem')->nullable();
            $table->string('link')->nullable();
            $table->string('texto_botao')->default('Saiba mais');
            $table->integer('ordem')->default(0);
            $table->boolean('ativo')->default(true);
            $table->enum('tipo', ['principal', 'secundario', 'promocional']);
            $table->date('inicio_exibicao')->nullable();
            $table->date('fim_exibicao')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('banners');
    }
};
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoriaFactory extends Factory
{
    protected $model = \App\Models\Categoria::class;

    // Lista de categorias base para geração
    private $categoriasBase = [
        'Material Escolar', 'Livros Didáticos', 'Uniforme Escolar', 'Eletrônicos',
        'Arte e Pintura', 'Esportes', 'Mochilas', 'Papelaria', 'Calculadoras',
        'Instrumentos Musicais', 'Laboratório', 'Geometria', 'Escrita',
        'Organização', 'Tecnologia', 'Música', 'Dança', 'Teatro', 'Biblioteca',
        'Informática', 'Robótica', 'Ciências', 'Matemática', 'Português',
        'História', 'Geografia', 'Inglês', 'Espanhol', 'Francês', 'Química',
        'Física', 'Biologia', 'Filosofia', 'Sociologia', 'Educação Física',
        'Artes Visuais', 'Ensino Médio', 'Ensino Fundamental', 'Graduação',
        'Pós-Graduação', 'Cursos Técnicos', 'Idiomas', 'Preparatórios',
        'Vestibular', 'ENEM', 'Concursos', 'Profissionalizantes'
    ];

    public function definition()
    {
        // Gerar nome único usando timestamp e random
        $baseNome = $this->faker->randomElement($this->categoriasBase);
        $nome = $baseNome . ' ' . Str::random(4) . ' ' . time();

        return [
            'nome' => $nome,
            'descricao' => $this->faker->paragraph(),
            'imagem_url' => $this->faker->imageUrl(400, 300, 'education'),
            'ordem' => $this->faker->numberBetween(1, 100),
            'ativo' => $this->faker->boolean(90),
        ];
    }

    public function inativa()
    {
        return $this->state(function (array $attributes) {
            return [
                'ativo' => false,
            ];
        });
    }
}

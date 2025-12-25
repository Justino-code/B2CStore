<?php
namespace Database\Factories;

use App\Models\Banner;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BannerFactory extends Factory
{
    protected $model = Banner::class;

    public function definition()
    {
        return [
            'titulo' => $this->faker->sentence(3),
            'subtitulo' => $this->faker->sentence(5),
            'descricao' => $this->faker->paragraph,
            'imagem' => $this->faker->imageUrl(1200, 800, 'business', true),
            'link' => $this->faker->url,
            'texto_botao' => $this->faker->word,
            'ordem' => $this->faker->numberBetween(1, 10),
            'ativo' => $this->faker->boolean,
            'tipo' => $this->faker->randomElement(['principal', 'secundario']),
            'inicio_exibicao' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'fim_exibicao' => $this->faker->dateTimeBetween('now', '+1 month'),
        ];
    }
}

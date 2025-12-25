<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannerSeeder extends Seeder
{
    public function run()
    {
        // Criando 10 banners aleatórios
        Banner::factory()->count(10)->create();
    }
}

<?php
// database/seeders/MarcaSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Marca;

class MarcaSeeder extends Seeder
{
    public function run(): void
    {
        Marca::factory(10)->create();
    }
}
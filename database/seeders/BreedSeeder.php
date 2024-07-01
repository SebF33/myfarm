<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Breed;

class BreedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $breeds = [
            'Frison',
            'Irish Cob',
            'Labrador',
            'Mérinos',
            'Pottok',
            'Solognotes',
        ];

        foreach ($breeds as $breed) {
            Breed::create(['name' => $breed]);
        }
    }
}

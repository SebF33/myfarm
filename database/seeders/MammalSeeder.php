<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mammal;

class MammalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mammals = [
            'Brebis',
            'Cheval',
            'Chien',
            'Cochon',
        ];

        foreach ($mammals as $mammal) {
            Mammal::create(['name' => $mammal]);
        }
    }
}

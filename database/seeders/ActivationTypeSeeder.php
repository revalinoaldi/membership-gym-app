<?php

namespace Database\Seeders;

use App\Models\TypeActivation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TypeActivation::create([
            'type' => 'days',
            'description' => 'Daily'
        ]);
        TypeActivation::create([
            'type' => 'month',
            'description' => 'Monthly'
        ]);
        TypeActivation::create([
            'type' => 'years',
            'description' => 'Yearly'
        ]);
    }
}

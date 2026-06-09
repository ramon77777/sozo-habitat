<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Property;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        Property::create([
            'title' => 'Villa moderne à Cocody',
            'price' => 125000000,
            'city' => 'Abidjan',
            'district' => 'Cocody',
            'surface' => 350,
            'bedrooms' => 5,
            'bathrooms' => 4,
            'type' => 'maison',
            'transaction' => 'vente',
            'description' => 'Magnifique villa avec piscine.',
            'main_image' => 'villa1.jpg',
            'featured' => true,
        ]);

        Property::create([
            'title' => 'Appartement standing Plateau',
            'price' => 750000,
            'city' => 'Abidjan',
            'district' => 'Plateau',
            'surface' => 120,
            'bedrooms' => 3,
            'bathrooms' => 2,
            'type' => 'appartement',
            'transaction' => 'location',
            'description' => 'Appartement moderne et sécurisé.',
            'main_image' => 'appartement1.jpg',
            'featured' => true,
        ]);

        Property::create([
            'title' => 'Terrain à Bingerville',
            'price' => 25000000,
            'city' => 'Abidjan',
            'district' => 'Bingerville',
            'surface' => 600,
            'type' => 'terrain',
            'transaction' => 'vente',
            'description' => 'Terrain viabilisé.',
            'main_image' => 'terrain1.jpg',
            'featured' => false,
        ]);
    }
}

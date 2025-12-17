<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Software', 'color' => 'primary'],   // Blue
            ['name' => 'Hardware', 'color' => 'danger'],    // Red
            ['name' => 'Network', 'color' => 'success'],    // Green
            ['name' => 'Other', 'color' => 'secondary'],    // Grey
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category['name'],
                'color' => $category['color'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

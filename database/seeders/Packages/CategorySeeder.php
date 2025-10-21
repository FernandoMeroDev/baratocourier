<?php

namespace Database\Seeders\Packages;

use App\Models\Packages\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    private array $categories = [
        [
            'name' => 'B 4X4',
            'code' => 'b'
        ],
        [
            'name' => 'C',
            'code' => 'c'
        ],
        [
            'name' => 'A (documentos)',
            'code' => 'a'
        ],
        [
            'name' => 'Especial',
            'code' => 'special'
        ],
        [
            'name' => 'G Migrante',
            'code' => 'g'
        ],
        [
            'name' => 'D',
            'code' => 'd'
        ],
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach($this->categories as $category)
            Category::create($category);
    }
}

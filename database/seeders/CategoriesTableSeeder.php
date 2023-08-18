<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{

    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Run the database seeds.
     */
    public function run()
    {
        $this->categoryRepository->create(['name' => 'Electronics']);
        $this->categoryRepository->create(['name' => 'Clothing']);
        $this->categoryRepository->create(['name' => 'Furniture']);
        $this->categoryRepository->create(['name' => 'Books']);
        $this->categoryRepository->create(['name' => 'Beauty']);
    }
}

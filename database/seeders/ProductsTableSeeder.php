<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    
    public function run()
    {
        foreach (range(1, 15) as $index) {
            $product = $this->productRepository->create([
                'name' => 'Product ' . $index,
                'description' => 'Description for Product ' . $index,
                'price' => rand(50, 500),
                'image' => 'testtesttest/product' . $index . '.jpg',
            ]);

            $randomCategories = Category::inRandomOrder()->limit(rand(1, 3))->pluck('id');
            $product->categories()->attach($randomCategories);
        }
    }
}

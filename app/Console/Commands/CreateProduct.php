<?php

namespace App\Console\Commands;

use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Console\Command;

class CreateProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $categoryRepository;
    protected $productRepository;
    
    public function __construct(CategoryRepository $categoryRepository, ProductRepository $productRepository )
    {
        parent::__construct();
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
    }

    
    public function handle()
    {
        $name = $this->ask('Enter product name:');
        $description = $this->ask('Enter product description:');
        $price = $this->ask('Enter product price:');
        $image = $this->ask('Enter product image path:');
    
        // fetch existed categories to present them to the console user
        $categories = $this->categoryRepository->all()->pluck('name', 'id')->toArray();

        $selectedCategories = $this->choice('Select categories for the product:', $categories, null, null, true);
    
        // get selected categories's id
        $ids = [];
        foreach ($categories as $id => $category) {
            if(in_array($category,$selectedCategories)){
                array_push($ids,$id);
            }
        }
        $product = $this->productRepository->create([
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'image' => $image,
        ]);
    
        // attach selected categories to the product
        $product->categories()->attach($ids);
    
        $this->info('Product created successfully!');
    }
    
}

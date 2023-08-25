<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ProductRepository;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function store(Request $request)
    {
        // return $request->image;
        // return validation error message if exist
        try {
            $data = $request->validate([
                'name' => 'required|string',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'category_ids' => 'required|array',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
                ]);

                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $imageName = time() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('images'), $imageName);
            
                    $data['image'] = 'images/' . $imageName;
                }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
       
        $product = $this->productRepository->create($data);
        $product->categories()->attach($data['category_ids']);

        return response()->json(['message' => 'Product created successfully'], 200);
    }

    public function index(Request $request)
    {
        $categoryId = $request->input('category_id');
        
        $sortByPrice = $request->input('sort') === 'price';
    
        $products = $this->productRepository->getAllWithFiltersAndSort($categoryId, $sortByPrice);

        // Create a new array to store the formatted products with image URLs
        $formattedProducts = [];

        foreach ($products as $product) {
            $formattedProducts[] = [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'image' => $product->image //? $this->getImageUrl($product->image) : null,
            ];
        }

        return response()->json([
            'products' => $formattedProducts,
        ]);
    }

}


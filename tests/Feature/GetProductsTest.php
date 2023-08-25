<?php

namespace Tests\Feature;

use App\Http\Controllers\ProductController;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Tests\TestCase;

class GetProductsTest extends TestCase
{
    public function testProductIndex()
    {
        $productRepository = new ProductRepository();
        $controller = new ProductController($productRepository);

        $request = new Request([
            'category_id' => 1,
            'sort' => 'price',
        ]);

        $response = $controller->index($request);

        $this->assertEquals(200, $response->getStatusCode()); 
    }
}

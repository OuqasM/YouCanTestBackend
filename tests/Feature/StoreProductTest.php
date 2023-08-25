<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StoreProductTest extends TestCase
{
    // use RefreshDatabase; // Resets the database after each test

    public function testProductCreation()
    {
        Storage::fake('public'); // Fakes the public storage for testing

        $image = UploadedFile::fake()->image('product.jpg');

        $response = $this->postJson('/api/v1/products', [
            'name' => 'Test Product',
            'description' => 'A test p    // use RefreshDatabase; // Resets the database after each test
            roduct',
            'price' => 100,
            'category_ids' => [1, 2],
            'image' => $image,
        ]);

        $response->assertStatus(200); 

    }
}
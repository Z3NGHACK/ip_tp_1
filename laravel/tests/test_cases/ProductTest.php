<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_product_can_be_created(): void
{
    // Create a category for the product
    $category = Category::create(['name' => 'Electronics']);

    // Create the product without image upload
    $product = Product::create([
        'name' => 'Laptop',
        'category_id' => $category->id,
        'price' => 1000,
        'description' => 'A good laptop',
        'images' => json_encode([])  // No images, so an empty array
    ]);

    // Assert that the product has been created in the database
    $this->assertDatabaseHas('products', ['name' => 'Laptop']);

    // Optionally, you can also check for the absence of images
    $this->assertDatabaseHas('products', ['images' => json_encode([])]);
}


    public function test_if_we_can_access_get_all_products_api(): void
    {
        $category = Category::create(['name' => 'Electronics']);
        // Creating a product with image paths stored as JSON
        $imagePaths = json_encode(['products/image1.jpg', 'products/image2.jpg']);

        Product::create([
            'name' => 'Sample Product',
            'category_id' => $category->id,
            'price' => 100,
            'description' => 'Sample description',
            'images' => $imagePaths
        ]);

        $response = $this->get('/api/products');

        $response->assertJsonStructure([
            '*' => [
                'id',
                'name',
                'price',
                'description',
                'images',
                'category_id',
                'category',
                'created_at',
                'updated_at',
            ]
        ]);
    }

    public function test_get_single_product(): void
    {
        $category = Category::create(['name' => 'Accessories']);
        $imagePaths = json_encode(['products/image1.jpg', 'products/image2.jpg']);

        $product = Product::create([
            'name' => 'Mouse',
            'category_id' => $category->id,
            'price' => 25,
            'description' => 'Wireless mouse',
            'images' => $imagePaths
        ]);

        $response = $this->get("/api/products/{$product->id}");

        $response->assertJson([
            'id' => $product->id,
            'name' => 'Mouse',
            'price' => 25,
        ]);
    }

    public function test_update_product(): void
    {
        $category = Category::create(['name' => 'Books']);
        $imagePaths = json_encode(['products/image1.jpg', 'products/image2.jpg']);

        $product = Product::create([
            'name' => 'Book 1',
            'category_id' => $category->id,
            'price' => 10,
            'description' => 'Some description',
            'images' => $imagePaths
        ]);

        $response = $this->patch("/api/products/{$product->id}", [
            'name' => 'Updated Book',
            'price' => 15,
            'description' => 'Updated description',
        ]);

        $response->assertJson([
            'message' => 'Product updated successfully'
        ]);
    }

}

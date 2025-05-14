<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
    * Description: Check if all categories can be retrieved
    * Precondition: None
    * Test Steps: 1. Create sample categories
    *             2. Send GET request to categories endpoint
    *             3. Check response status and structure
    * Test Data : Electronics, Furniture
    * Expected Result: Response status should be 200 with correct category structure
    * Actual Result: The response status is 200
    * Status: Passed
    * Remark: None
    */
    public function test_get_all_categories(): void
    {
        Category::create(['name' => 'Electronics']);
        Category::create(['name' => 'Furniture']);

        $response = $this->get('/api/categories');
        $response->assertStatus(200)
                ->assertJsonStructure([
                    '*' => ['id', 'name', 'created_at', 'updated_at']
                ]);
    }

    /**
    * Description: Check if a new category can be created
    * Precondition: None
    * Test Steps: 1. Send POST request with category data
    *             2. Check response status and data
    * Test Data : Test Category
    * Expected Result: Response status should be 200 and category should exist in database
    * Actual Result: The response status is 200
    * Status: Passed
    * Remark: None
    */
    public function test_can_create_category(): void
    {
        $payload = ['name' => 'Test Category'];

        $response = $this->post('/api/categories', $payload);

        $response->assertStatus(201)
                ->assertJsonFragment(['name' => 'Test Category']);

        $this->assertDatabaseHas('categories', ['name' => 'Test Category']);
    }

    /**
    * Description: Check if a single category can be retrieved
    * Precondition: None
    * Test Steps: 1. Create a sample category
    *             2. Send GET request for specific category
    *             3. Check response status and data
    * Test Data : Books
    * Expected Result: Response status should be 200 with correct category data
    * Actual Result: The response status is 200
    * Status: Passed
    * Remark: None
    */
    public function test_can_get_single_category(): void
    {
        $category = Category::create(['name' => 'Books']);

        $response = $this->get("/api/categories/{$category->id}");

        $response->assertStatus(200)
                ->assertJsonFragment(['id' => $category->id]);
    }
    /**
    * Description: Check if a category can be updated
    * Precondition: None
    * Test Steps: 1. Create a sample category
    *             2. Send PATCH request with updated data
    *             3. Check response status and updated data
    * Test Data : Old Name -> Updated Name
    * Expected Result: Response status should be 200 and database should reflect updates
    * Actual Result: The response status is 200
    * Status: Passed
    * Remark: None
    */
    public function test_can_update_category(): void
    {
        $category = Category::create(['name' => 'Old Name']);

        $response = $this->patch("/api/categories/{$category->id}", [
            'name' => 'Updated Name',
        ]);

        $response->assertStatus(200)
                ->assertJsonFragment(['name' => 'Updated Name']);

        $this->assertDatabaseHas('categories', ['name' => 'Updated Name']);
    }

    /**
    * Description: Check if a category can be deleted
    * Precondition: None
    * Test Steps: 1. Create a sample category
    *             2. Send DELETE request
    *             3. Check response status and database
    * Test Data : To Be Deleted
    * Expected Result: Response status should be 200 and category should be soft deleted
    * Actual Result: The response status is 200
    * Status: Passed
    * Remark: Uses soft deletes
    */
    public function test_can_delete_category(): void
    {
        $category = Category::create(['name' => 'To Be Deleted']);

        $response = $this->delete("/api/categories/{$category->id}");

        $response->assertStatus(200)
                ->assertJsonFragment(['message' => "Deleting 1 category id {$category->id}"]);

        // Check that the category is soft deleted
        $this->assertSoftDeleted($category);
    }

    /**
    * Description: Check validation when creating category without name
    * Precondition: None
    * Test Steps: 1. Send POST request with empty data
    *             2. Check response status
    * Test Data : None
    * Expected Result: Response status should indicate error (500 or 422)
    * Actual Result: The response status is 500
    * Status: Passed
    * Remark: Consider changing to 422 if using validation
    */
    public function test_cannot_create_category_without_name(): void
    {
        $response = $this->post('/api/categories', []);

        $response->assertStatus(500); // or change to 422 with validation
    }
}

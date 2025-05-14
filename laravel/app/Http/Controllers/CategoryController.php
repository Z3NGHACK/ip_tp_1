<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // --- Get /api/categories
    public function getCategories()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    // --- Post /api/categories
    public function createCategory(Request $request)
    {
        $category = Category::create([
            'name' => $request->name,
        ]);
        return response()->json($category, 201);
    }

    // --- Get /api/categories/{categoryId}
    public function getCategory($categoryId)
    {
        $category = Category::find($categoryId);
        return response()->json($category);
    }

    // --- Get /api/categories/{categoryId}
    public function updateCategory($categoryId, Request $request)
    {
        $category = Category::find($categoryId);
        $category->update([
            'name' => $request->name,
        ]);
        return response()->json($category);
    }

    // --- Delete /api/categories/{categoryId}
    public function deleteCategory($categoryId)
    {
        $category = Category::find($categoryId);
        $category->delete();
        return ["message" => "Deleting 1 category id $categoryId"];
    }
}

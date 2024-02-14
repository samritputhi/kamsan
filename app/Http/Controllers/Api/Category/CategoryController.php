<?php

namespace App\Http\Controllers\Api\Category;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function create(Request $request) {

    
        try {
            $validatedData = $request->validate([
                'name' => 'required|string',
                'image' => 'required',
                'order' => 'required', 
                'status' => 'required' 
            ]);
            $existingCategory = Category::where('name', $request->name)->exists();
            if ($existingCategory) {
                return response()->json([
                    'status' => false,
                    'message' => 'A category with the same name already exists.'
                ], 409); // 409 Conflict
            }
            $category = Category::create($validatedData);
            return response()->json([
                'status' => true,
                'message' => 'Category created successfully',
                'data' => $category
            ], 201);
    
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function index() {
        $category = Category::get();
        return  response()->json([
            'status' => true,
            "data" => $category
        ]);
    }

    public function detail($id) {
        $category = Category::find($id);
        return response()->json(['data' => $category]);
    }

    public function update(Request $request,$id) {
 
        try {
            $validatedData = $request->validate([
                'name' => 'required|string',
                'image' => 'required',
                'order' => 'required', 
                'status' => 'required' 
            ]);
            $category = Category::find($id);
            if (!$category) {
                return response()->json([
                    'status' => false,
                    'message' => 'Category not found'
                ], 404);
            }

            $existingCategory = Category::where('name', $request->name)->exists();
            if ($existingCategory) {
                return response()->json([
                    'status' => false,
                    'message' => 'A category with the same name already exists.'
                ], 409); // 409 Conflict
            }

            $category->update($validatedData);
            return response()->json([
                'status' => true,
                'message' => 'Category update successfully',
                'data' => $category
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 201);
        }
    }
}

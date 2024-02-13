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

            // $itemsArray = Category::get();
            // dd($itemsArray->array());
            // if (in_array($validatedData['name'], $itemsArray->array())) {
            //     return response()->json([
            //         'status' => false,
            //         'message' => 'Duplicate name found in the provided items array.'
            //     ], 422);
            // }
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

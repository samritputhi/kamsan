<?php

namespace App\Http\Controllers\Api\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
    public function create(Request $request) {
        try {
            $validator = $request->validate([
                "title" => "required",
                "category_id" => "required",
                "order" => "required",
                "status" => "required"
            ]);
            $existingNews = News::where("title",$request->title)->exists(); 
            if($existingNews) {
                return response()->json([
                    "status" => false,
                    "message" => "A title with the same title already exists."
                ],409);
            }
            $news = News::create([
                "title" => $validator["title"],
                "category_id" => $validator["category_id"],
                "order" => $validator["order"],
                "status" => $validator["status"],
                "image" => $request->image,
                "des" => $request->des
            ]);
            return response()->json([
                "status" => true,
                "message" => "Create Successfully.",
                "data" => $news
            ],409);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => $th->getMessage()
            ],500);
        }
    }
    
    public function index() {
        
        $news = News::get();
        return  response()->json([
            'status' => true,
            "data" => $news
        ]);
    }

    public function detail($id) {
        $news = News::find($id);
        return response()->json(['data' => $news]);
    }

    public function update(Request $request,$id) {
        try {

            $validator = $request->validate([
                "title" => "required",
                "category_id" => "required",
                "order" => "required",
                "status" => "required"
            ]);

            $news = News::find($id);
            $existingNews = News::where("title",$request->title)->exists(); 
            if($existingNews) {
                return response()->json([
                    "status" => false,
                    "message" => "A title with the same title already exists."
                ],409);
            }
           
            $news->update([
                "title" => $validator["title"],
                "category_id" => $validator["category_id"],
                "order" => $validator["order"],
                "status" => $validator["status"],
                "image" => $request->image,
                "des" => $request->des
            ]);
            return response()->json([
                "status" => true,
                "message" => "Create Successfully.",
                "data" => $news
            ],409);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => $th->getMessage()
            ],500);
        }
    }

    public function delete($id) {
       try {
            $news = News::find($id)->delete();
            if($news) {
                return response()->json([
                    "status" => true,
                    "message" => "Delete Successfully."
                ],200);            
            }
       } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => $th->getMessage()
            ],404);   
       }
    }

    public function search(Request $request) {
        $search = $request->input("search");
        if(!empty($search )) {
            $news = News::where("title", 'like' , "%$search%")
                    ->orWhere('category_id', 'LIKE', "%{$search}%")
                    ->get();
            return response()->json([
                'status' => true,
                'message' => 'Search results',
                'data' => $news
            ],200);
        }
        return response()->json([
            'status' => false,
            'message' => 'Search not found',
        ],400);
    }
}

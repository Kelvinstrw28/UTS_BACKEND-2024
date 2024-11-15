<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::all();
        return response()->json([
            'success' => true,
            'data' => $news
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255', 
            'author' => 'required|string|max:100', 
            'description' => 'required|string', 
            'content' => 'required', 
            'url' => 'required|url', 
            'url_image' => 'nullable|url', 
            'published_at' => 'nullable|date', 
            'category' => 'required|string' 
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors() 
            ], 400);
        }

        $news = News::create($request->all());
        return response()->json([
            'success' => true,
            'data' => $news
        ], 201);
    }

    public function show($id)
    {
        $news = News::find($id);
        if (!$news) {
            return response()->json([
                'success' => false,
                'message' => 'News not found'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $news
        ], 200);
    }
    public function update(Request $request, $id)
    {
        $news = News::find($id);
        if (!$news) {
            return response()->json([
                'success' => false,
                'message' => 'News not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:100',
            'description' => 'required|string',
            'content' => 'required',
            'url' => 'required|url',
            'url_image' => 'nullable|url',
            'published_at' => 'nullable|date',
            'category' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        $news->update($request->all());

        return response()->json([
            'success' => true,
            'data' => $news
        ], 200);
    }

    public function destroy($id)
    {
        $news = News::find($id);

        if (!$news) {
            return response()->json([
                'success' => false,
                'message' => 'News not found'
            ], 404);
        }

        $news->delete();

        return response()->json([
            'success' => true,
            'message' => 'News deleted successfully'
        ], 200);
    }
    
    
    public function search($title)
    {

        $news = News::where('title', 'LIKE', "%{$title}%")->get();

  
        return response()->json([
            'success' => true,
            'data' => $news
        ], 200);
    }

    
    public function getByCategory($category)
    {
        
        $news = News::where('category', $category)->get();

        
        return response()->json([
            'success' => true,
            'data' => $news
        ], 200);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\PostModel;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function index()
    {
        try {
            $posts = PostModel::orderBy('created_at', 'DESC')->get();
            return response()->json($posts);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch posts.'], 500);
        }
    }       

    public function show($id)
    {
        try {
            $post = PostModel::find($id);
            if (!$post) {
                return response()->json(['error' => 'Post not found'], 404);
            }
            return response()->json($post);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch post.'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'title' => 'required|string',
                'location' => 'required|string',
                'type' => 'required|string',
                'description' => 'required|string',
                'paiement_method' => 'required|string',
                'period' => 'nullable|string',
            ]);

            $post = PostModel::create($data);

            return response()->json($post, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create post.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $post = PostModel::find($id);

            if (!$post) {
                return response()->json(['error' => 'Post not found'], 404);
            }

            $post->delete();

            return response()->json(['message' => 'Post deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete post.'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'title' => 'required|string',
                'location' => 'required|string',
                'type' => 'required|string',
                'description' => 'required|string',
                'paiement_method' => 'required|string',
                'period' => 'nullable|string',
            ]);

            $post = PostModel::find($id);

            if (!$post) {
                return response()->json(['error' => 'Post not found'], 404);
            }

            $post->update($data);

            return response()->json($post);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update post.'], 500);
        }
    }

    public function searchByContent()
    {
        try {
            $posts = PostModel::where('title', 'like', '%' . request()->get('title') . '%')->get();
            return response()->json($posts);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to search for posts.'], 500);
        }
    }

}

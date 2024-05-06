<?php

namespace App\Http\Controllers;

use App\Models\PostModel;
use Illuminate\Http\Request;

class PostModelController extends Controller
{

    //afficher les post
    public function index()
    {
        return response()->json(PostModel::orderBy('created_at', 'DESC')->get());
    }       

    //afficher post par id
    public function show($id)
    {
        $post = PostModel::find($id);
        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }
        return response()->json($post);
    }


    //creer un post
    public function store()
    {
        $data = request()->validate([
            'title' => 'required',
            'location' => 'required',
            'type' => 'required',
            'description' => 'required',
            'paiement_method' => 'required',
            'title' => 'required',
            'period' => 'string',
            'description' => 'string',
        ]);

        $post = PostModel::create($data);

        return response()->json($post, 201);
    }


    //supprimer un post
    public function destroy($id)
    {
        $post = PostModel::find($id);

        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        $post->delete();

        return response()->json(['message' => 'Post deleted successfully']);
    }


    //mettre à jour un post
    public function update($id)
    {
        $data = request()->validate([
            'name' => 'required',
            'price' => 'string',
            'description' => 'string'
        ]);

        $post = PostModel::find($id);

        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        $post->update($data);

        return response()->json($post);
    }



    //rechercher un post par titre
    public function searchByContent()
    {
        $posts = PostModel::where('title', 'like', '%' . request()->get('title') . '%')->get();
        return response()->json($posts);
    }


}

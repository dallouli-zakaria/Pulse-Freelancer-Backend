<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{


    public function index()
    {
        try {
            // Retrieve all posts with their related skills
            $posts = Post::with('skills')->orderBy('created_at', 'DESC')->get();
            
            return response()->json($posts);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function show($id)
    {
        try {
            // Retrieve the post with its related skills
            $post = Post::with('skills')->find($id);

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
                'freelancers_number' => 'required|numeric',
                'skills_required' => 'required|array',
                'period' => 'required|string',
                'periodvalue' => 'nullable|numeric',
                'budget' => 'required|string',
                'budgetvalue' => 'nullable|numeric',
                'client_id' => 'required'
            ]);
    
            $postData = array_diff_key($data, ['skills_required' => '']);
            $post = Post::create($postData);
    
            if (isset($data['skills_required'])) {
                $post->skills()->attach($data['skills_required']);
            }
            return response()->json($post->load('skills'), 201);
        } catch (\Exception $e) {
            return response()->json(['error' =>  $e->getMessage()], 500);
        }
    }
    

    public function destroy($id)
    {
        try {
            $post = Post::find($id);

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
                'freelancers_number' => 'required|numeric',
                'skills_required' => 'required|array',
                'period' => 'required|string',
                'periodvalue' => 'nullable|numeric',
                'budget' => 'required|string',
                'budgetvalue' => 'nullable|numeric',
                'client_id' => 'required'
            ]);
    
            // Find the post by id
            $post = Post::findOrFail($id);
    
            // Update the post with the validated data
            $postData = array_diff_key($data, ['skills_required' => '']);
            $post->update($postData);
    
            // Sync the skills
            if (isset($data['skills_required'])) {
                $post->skills()->sync($data['skills_required']);
            }
    
            return response()->json($post->load('skills'), 200);
        } catch (\Exception $e) {
            return response()->json(['error' =>  $e->getMessage()], 500);
        }
    }

    public function searchByContent()
    {
        try {
            $posts = Post::where('title', 'like', '%' . request()->get('title') . '%')->get();
            return response()->json($posts);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to search for posts.'], 500);
        }
    }

    public function addPost(Request $request,$id){
       $client_id=User::findOrFail($id);
       $post=new Post;
       if($client_id !==null){
        //  $data=$request.validator([
        //     'title' => 'required',
        //     'location' => 'required',
        //     'type' => 'required',
        //     'description' => '',
        //     'period' => '',
        //     'Periodvalue' => '',
        //     'budget' => '',
        //     'Budgetvalue' => '',
         
            
        //  ]);
        


        $post->title=$request->title;
       $post->location= $request->location;
       $post->type=$request->type;
       $post->description=$request->description;
       $post->period=$request->perid;
       $post->periodvalue=$request->peridvalue;
       $post->budget=$request->budget;
       $post->budgetvalue=$request->budgetvalue;
       $post->client_id=$id;
        $post=Post::create([$post]);
        return response()->json('created post');
        }
       


    }
    public function count(){
      try   {$freelancer=Post::count();
        return response()->json($freelancer);} catch (\Exception $e){
            return response()->json($e);
        }
    }



    public function showPostsByClient($client_id)
        {
            try {
                $client = Client::find($client_id);

                if (!$client) {
                    return response()->json(['error' => 'Client not found'], 404);
                }

                $posts = Post::with('skills')->where('client_id', $client_id)->orderBy('created_at', 'DESC')->get();
                
                return response()->json($posts);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Failed to fetch posts.'], 500);
            }
        }


public function showByPostId($post_id)
    {
        try {
            $posts = Post::where('id', $post_id)->get();
            if ($posts->isEmpty()) {
                return response()->json(['error' => 'No offers found.'], 404);
            }
            return response()->json($posts);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch offers.'], 500);
        }
    }


    public function checkFreelancerOffer($postId, $freelancerId)
    {
        $offerExists = DB::table('posts')
                            ->join('offers', 'posts.id', '=', 'offers.post_id')
                            ->where('posts.id', $postId)
                            ->where('offers.freelancer_id', $freelancerId)
                            ->exists();

        return response()->json([
            'offer_exists' => $offerExists,
        ]);
    }

    public function getClientDetailsByPostId($post_id)
        {
            try {
                // Retrieve offers with given post_id
                $posts = Post::where('id', $post_id)->get();
                
                // Extract freelancer ids from offers
                $clientids = $posts->pluck('client_id')->unique()->toArray();
                
                // Retrieve freelancers details for the extracted ids
                $client = Client::whereIn('id', $clientids)
                ->with('user:id,name,email') 
                ->orderBy('created_at', 'DESC')
                ->get();
                
                return response()->json($client);
            } catch (\Exception $e) {
                return response()->json($e, 500);
            }
        }


        public function getSkills($postId)
        {
            try {
                // Find the post with related skills
                $post = Post::with('skills')->findOrFail($postId);
    
                // Return the skills associated with the post
                return response()->json($post->skills, 200);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Failed to retrieve skills.'], 500);
            }
        }



        
    

    
}

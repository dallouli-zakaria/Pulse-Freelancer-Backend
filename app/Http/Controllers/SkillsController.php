<?php

namespace App\Http\Controllers;

use App\Models\Freelancers;
use App\Models\Post;
use App\Models\skills;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SkillsController extends Controller
{
    public function index()
    {
        try {
            $skills = skills::all();
            return response()->json($skills);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch skills.'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string',

                
            ]);

            $skill = skills::create($validatedData);
            return response()->json($skill, 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create skill.'], 500);
        }
    }

    public function show($id)
    {
        try {
            $skill = skills::findOrFail($id);
            return response()->json($skill);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Skill not found.'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'string',
            ]);

            $skill = skills::findOrFail($id);
            $skill->update($validatedData);

            return response()->json($skill);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update skill.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $skill = skills::findOrFail($id);
            $skill->delete();
            return response()->json(['message' => 'Skill deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete skill.'], 500);
        }
    }



    public function searchByTitle(Request $request)
    {
        try {
            $searchQuery = $request->input('title');
            $skills = Skills::where('title', 'LIKE', "%{$searchQuery}%")->get();
    
            if ($skills->isEmpty()) {
                return response()->json(['error' => 'No skills found with the given title.'], 404);
            }
    
            return response()->json($skills);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to search skills.'], 500);
        }
    }


    public function checkFreelancerSkillsMatchWithScore($freelancerId, $postId)
    {
        try {
            // Retrieve the post and its required skills
            $post = Post::findOrFail($postId);
            $postSkills = $post->skills->pluck('id')->toArray(); // Get required skills IDs

            // Retrieve the freelancer and their skills
            $freelancer = Freelancers::findOrFail($freelancerId);
            $freelancerSkills = $freelancer->skills->pluck('id')->toArray(); // Get freelancer's skills IDs

            // Calculate the number of required skills
            $totalRequiredSkills = count($postSkills);
            
            // Calculate the number of matched skills
            $matchedSkills = array_intersect($postSkills, $freelancerSkills);
            $totalMatchedSkills = count($matchedSkills);

            // Calculate the score as a percentage
            $score = $totalRequiredSkills > 0 ? ($totalMatchedSkills / $totalRequiredSkills) * 100 : 0;

            return response()->json([
                'matches' => $totalMatchedSkills === $totalRequiredSkills,
                'score' => $score,
                'matched_skills' => $totalMatchedSkills,
                'total_required_skills' => $totalRequiredSkills
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error occurred while checking skills.'], 500);
        }
    }
}

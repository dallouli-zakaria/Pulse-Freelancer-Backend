<?php

namespace App\Http\Controllers;

use App\Models\PostSkill;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
class PostSkillController extends Controller
{
    public function index()
    {
        try {
            $PostSkills = PostSkill::all();
            return response()->json($PostSkills);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch PostSkills.'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title'=>'required|string',
                'post_id'=>'required|numeric',
                'skill_id'=>'required|numeric'
            ]);
            
            $PostSkill = PostSkill::create($request->all());
            return response()->json($PostSkill, 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create PostSkill.'], 500);
        }
    }

    public function show($id)
    {
        try {
            $PostSkill = PostSkill::findOrFail($id);
            return response()->json($PostSkill);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'PostSkill not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch PostSkill.'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'title'=>'required|string',
                'freelancer_id'=>'required|numeric',
                'skill_id'=>'required|numeric'
            ]);

            $PostSkill = PostSkill::findOrFail($id);
            $PostSkill->update($request->all());
            return response()->json($PostSkill, 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'PostSkill not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update PostSkill.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $PostSkill = PostSkill::findOrFail($id);
            $PostSkill->delete();
            return response()->json('Deleted succesfull', 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'PostSkill not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete PostSkill.'], 500);
        }
    }

    public function count(){
        $PostSkillCount = PostSkill::count();
        return response()->json($PostSkillCount);
    }

    public function showSkillsByPostId($post_id)
    {
        try {
            $PostSkills = PostSkill::where('post_id', $post_id)->get();
            return response()->json($PostSkills);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch skills for the given post.'], 500);
        }
    }


    public function showSkillsByPost($post_id)
        {
            try {
                $PostSkills = PostSkill::with('skill')
                    ->where('post_id', $post_id)
                    ->get()
                    ->map(function ($PostSkill) {
                        return [
                            'title' => $PostSkill->title,
                            'post_id' => $PostSkill->post_id,
                            'skill_id' => $PostSkill->skill_id,
                        ];
                    });

                return response()->json($PostSkills);
            } catch (\Exception $e) {
                return response()->json($e, 500);
            }
        }
}

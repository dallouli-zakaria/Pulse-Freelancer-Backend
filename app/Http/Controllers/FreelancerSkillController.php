<?php

namespace App\Http\Controllers;

use App\Models\Freelancers;
use App\Models\FreelancerSkill;
use App\Models\skills;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
class FreelancerSkillController extends Controller
{
    public function index()
    {
        try {
            $FreelancerSkills = FreelancerSkill::all();
            return response()->json($FreelancerSkills);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch FreelancerSkills.'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'level'=>'required|string',
                'freelancer_id'=>'required|numeric',
                'skill_id'=>'required|numeric'
            ]);
            
            $FreelancerSkill = FreelancerSkill::create($request->all());
            return response()->json($FreelancerSkill, 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create FreelancerSkill.'], 500);
        }
    }

    public function show($id)
    {
        try {
            $FreelancerSkill = FreelancerSkill::findOrFail($id);
            return response()->json($FreelancerSkill);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'FreelancerSkill not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch FreelancerSkill.'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'level'=>'required|string',
                'freelancer_id'=>'required|numeric',
                'skill_id'=>'required|numeric'
            ]);

            $FreelancerSkill = FreelancerSkill::findOrFail($id);
            $FreelancerSkill->update($request->all());
            return response()->json($FreelancerSkill, 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'FreelancerSkill not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update FreelancerSkill.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $FreelancerSkill = FreelancerSkill::findOrFail($id);
            $FreelancerSkill->delete();
            return response()->json('Deleted succesfull', 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'FreelancerSkill not found.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete FreelancerSkill.'], 500);
        }
    }

        public function count(){
        $FreelancerSkillCount = FreelancerSkill::count();
        return response()->json($FreelancerSkillCount);
    }

    public function showSkillsByFreelancerId($freelancer_id)
    {
        try {
            $FreelancerSkills = FreelancerSkill::where('freelancer_id', $freelancer_id)->get();
            return response()->json($FreelancerSkills);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch skills for the given freelancer.'], 500);
        }
    }


    public function showSkillsByFreelancer($freelancer_id)
        {
            try {
                $FreelancerSkills = FreelancerSkill::with('skill')
                    ->where('freelancer_id', $freelancer_id)
                    ->get()
                    ->map(function ($freelancerSkill) {
                        return [
                            'level' => $freelancerSkill->level,
                            'freelancer_id' => $freelancerSkill->freelancer_id,
                            'skill_id' => $freelancerSkill->skill_id,
                            'title' => $freelancerSkill->skill->title,
                        ];
                    });

                return response()->json($FreelancerSkills);
            } catch (\Exception $e) {
                return response()->json($e, 500);
            }
        }



        public function deleteSkillbyfreelancerId($freelancer_id, $skill_id)
        {
            $freelancer = Freelancers::find($freelancer_id);
    
            if ($freelancer) {
                $freelancer->skills()->detach($skill_id);
                return response()->json(['message' => 'Skill deleted successfully.'], 200);
            } else {
                return response()->json(['message' => 'Freelancer not found.'], 404);
            }
        }






}

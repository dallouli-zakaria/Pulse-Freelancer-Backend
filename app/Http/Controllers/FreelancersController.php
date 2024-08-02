<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Freelancers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Psy\CodeCleaner\ReturnTypePass;

class FreelancersController extends Controller
{

   public function index(){
    try {
       

        $freelancers = Freelancers::with(['user:id,name,email', 'skills'])
                                  ->orderBy('created_at', 'DESC');
                                  

        return response()->json($freelancers);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
   }
    public function indexPagination(Request $request){
    try {
        $page = $request->query('page', 1);
        $perPage = 8;

        $freelancers = Freelancers::with(['user:id,name,email', 'skills'])
                                  ->orderBy('created_at', 'DESC')
                                  ->paginate($perPage);

        return response()->json($freelancers);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
   }
    
   
   public function searchBar() {
    try {
        if (isset($_GET['query'])) {
            $search_bar_input = $_GET['query'];
            $freelancers = Freelancers::join('users', 'users.id', '=', 'freelancers.id')
                          ->orderBy('freelancers.id', 'DESC')
                          ->where(function($query) use ($search_bar_input) {
                              $query->where('users.name', 'LIKE', $search_bar_input . '%')
                                    ->orWhere('users.email', 'LIKE', $search_bar_input . '%');
                          })
                          ->select('freelancers.*', 'users.name', 'users.email')->with('user')
                          ->get();
        } else {
            $freelancers = Freelancers::join('users', 'users.id', '=', 'freelancers.id')
                          ->orderBy('freelancers.id', 'DESC')
                          ->select('freelancers.*', 'users.name', 'users.email')->with('user')
                          ->get();
        }
        return response()->json($freelancers, 200);
    } catch (\Illuminate\Database\QueryException $e) {
        // Database-related error
        return response()->json(['error' => 'Database query error', 'message' => $e->getMessage()], 500);
    } catch (\Exception $e) {
        // General error
        return response()->json(['error' => 'An unexpected error occurred', 'message' => $e->getMessage()], 500);
    }
}




public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
                'title' => 'nullable|string|max:255',
                'dateOfBirth' => 'nullable|date',
                'city' => 'nullable|string|max:255',
                'TJM' => 'nullable|numeric',
                'summary' => 'nullable|string',
                'availability' => 'nullable|string',
                'adress' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:20',
                'portfolio_Url' => 'nullable|url|max:255',
                'status'=> 'nullable|string',
                'user.email_verified_at' => 'nullable|date'
     
            ]);
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->email_verified_at = $request->email_verified_at;
            $user->password = Hash::make($request->password);
            if ($request->has('user.email_verified_at')) {
                $user->email_verified_at = $request->input('user.email_verified_at');
            }
            $user->save();
            event(new Registered($user));
    
            $freelancers = new Freelancers;
            $freelancers->id = $user->id;
            $freelancers->title = $request->title;
            $freelancers->dateOfBirth = $request->dateOfBirth;
            $freelancers->city = $request->city;
            $freelancers->TJM = $request->TJM;
            $freelancers->summary = $request->summary;
            $freelancers->availability = $request->availability;
            $freelancers->adress = $request->adress;
            $freelancers->phone = $request->phone;
            $freelancers->portfolio_Url = $request->portfolio_Url;
            $freelancers->status= $request->status;
            $freelancers->save();
            $user->assignRole('freelancer_role');
            return response()->json('created');
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
 } 
    public function show($id)
    {
        try {
            $freelancers = Freelancers::with(['user:id,name,email', 'skills'])->orderBy('created_at', 'DESC')->findOrFail($id);
            
    
            // Return the combined response data as JSON
            return response()->json($freelancers);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Freelancer not found.'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'nullable|string|max:255',
                'email' => 'nullable|email|unique:users,email,' . $id,
                'password' => 'nullable|string|min:6',
                'title' => 'nullable|string|max:255',
                'dateOfBirth' => 'nullable|date',
                'city' => 'nullable|string|max:255',
                'TJM' => 'nullable|numeric',
                'summary' => 'nullable|string',
                'availability' => 'nullable|string',
                'adress' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:20',
                'portfolio_Url' => 'nullable|url|max:255',
                'status'=>'nullable|string'
            ]);
    
            // Find the user and freelancer by id
            $user = User::findOrFail($id);
            $freelancer = Freelancers::findOrFail($id);
    
           // Update user fields only if they are provided in the request
            if ($request->has('name')) {
                $user->name = $request->name;
            }
            if ($request->has('email')) {
                $user->email = $request->email;
            }
            if ($request->has('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();
            

            // Update freelancer fields only if they are provided in the request
            if ($request->has('title')) {
                $freelancer->title = $request->title;
            }
            if ($request->has('dateOfBirth')) {
                $freelancer->dateOfBirth = $request->dateOfBirth;
            }
            if ($request->has('city')) {
                $freelancer->city = $request->city;
            }
            if ($request->has('TJM')) {
                $freelancer->TJM = $request->TJM;
            }
            if ($request->has('summary')) {
                $freelancer->summary = $request->summary;
            }
            if ($request->has('availability')) {
                $freelancer->availability = $request->availability;
            }
            if ($request->has('adress')) {
                $freelancer->adress = $request->adress;
            }
            if ($request->has('phone')) {
                $freelancer->phone = $request->phone;
            }
            if ($request->has('portfolio_Url')) {
                $freelancer->portfolio_Url = $request->portfolio_Url;
            }
            if ($request->has('status')) {
                $freelancer->status = $request->status;
            }
            $freelancer->save();
    
            return response()->json('updated');
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    

    public function destroy($id)
    {
        try {
       
                User::where('id', $id)->delete();
         

            return response()->json(['message' => 'Freelancer and associated user deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete freelancer: ' . $e->getMessage()], 500);
        }
    }

    public function assignRoleToUser($id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            $user->assignRole('role_name'); // Replace 'role_name' with the actual role name you want to assign

            return response()->json(['message' => 'Role assigned successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to assign role to user.'], 500);
        }
    }

    public function count(){
        $freelancer=Freelancers::count();
        return response()->json($freelancer);
    }

    public function assignSkills(Request $request, $freelancerId)
    {
        try {
            // Validate input
            $validator = Validator::make($request->all(), [
                'skills' => 'required|array',
                'skills.*' => 'exists:skills,id'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Find the freelancer
            $freelancer = Freelancers::findOrFail($freelancerId);

            // Attach skills to the freelancer
            $freelancer->skills()->sync($request->skills);

            return response()->json(['message' => 'Skills assigned successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to assign skills.'], 500);
        }
    }

    public function getSkills($freelancerId)
    {
        try {
            // Find the freelancer
            $freelancer = Freelancers::with('skills')->findOrFail($freelancerId);

            // Return the freelancer's skills
            return response()->json($freelancer->skills, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve skills.'], 500);
        }
    }

    public function getFreelancersBySkill($skillId)
{
    try {
        $freelancers = Freelancers::whereHas('skills', function ($query) use ($skillId) {
            $query->where('skills.id', $skillId);
        })->get();

        return response()->json($freelancers);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to retrieve freelancers.'], 500);
    }
}


// public function updateFreelancerSkills(Request $request, $freelancerId)
// {
//     try {
//         $validatedData = $request->validate([
//             'skills' => 'required|array',
//             'skills.*' => 'exists:skills,id',
//         ]);

//         $freelancer = Freelancers::findOrFail($freelancerId);
//         $currentSkillIds = $freelancer->skills->pluck('id')->toArray();
//         $newSkillIds = $validatedData['skills'];

//         // Merge current and new skill IDs
//         $allSkillIds = array_unique(array_merge($currentSkillIds, $newSkillIds));

//         // Sync the skills
//         $freelancer->skills()->sync($allSkillIds);

//         return response()->json(['message' => 'Freelancer skills updated successfully.']);
//     } catch (\Exception $e) {
//         return response()->json(['error' => 'Failed to update freelancer skills.'], 500);
//     }
// }

public function updateFreelancerSkills(Request $request, $freelancerId)
{
    try {
        $validatedData = $request->validate([
            'skills' => 'required|array',
            'skills.*' => 'exists:skills,id',
        ]);

        $freelancer = Freelancers::findOrFail($freelancerId);
        $currentSkillIds = $freelancer->skills->pluck('id')->toArray();
        $newSkillIds = $validatedData['skills'];

        // Merge current and new skill IDs
        $allSkillIds = array_unique(array_merge($currentSkillIds, $newSkillIds));

        // Sync the skills
        $freelancer->skills()->sync($allSkillIds);
        
        return response()->json(['message' => 'Freelancer skills updated successfully.']);
    } catch (\Exception $e) {
 
        return response()->json( $e->getMessage(), 500);
    }
}


public function getMatchingPostsForFreelancer($freelancerId)
{
    try {
        $freelancer = Freelancers::with('skills')->findOrFail($freelancerId);
        $skills = $freelancer->skills->pluck('id');

        $posts = Post::whereHas('skills', function ($query) use ($skills) {
            $query->whereIn('id', $skills);
        })->get();

        return response()->json($posts);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to retrieve matching posts.'], 500);
    }
}

public function getVerifiedFreelancers()
{
    try {
        // Fetch only freelancers with status 'verified'
        $freelancers = Freelancers::with(['user:id,name,email', 'skills'])->orderBy('created_at', 'DESC')
            ->where('status', 'verified')
            ->get();

        return response()->json($freelancers);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}





}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class skills extends Model
{
    use HasFactory;
    protected $fillable=
    [
        'title',
        
    ];


    public function posts(){
        return $this->belongsToMany(Post::class);
    }

    public function freelancer(){
        return $this->belongsToMany(Freelancers::class);
    }


    public function freelancerSkills()
    {
        return $this->hasMany(FreelancerSkill::class, 'skill_id');
    }




}

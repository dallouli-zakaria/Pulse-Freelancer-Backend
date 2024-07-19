<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class skills extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        
    ];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_skills','skill_id', 'post_id'); // Adjust 'post_skill' to your actual pivot table name
    }

    public function freelancers()
    {
        return $this->belongsToMany(Freelancers::class, 'freelancer_skill', 'skill_id', 'freelancer_id'); // Adjust 'freelancer_skill' to your actual pivot table name
    }
}

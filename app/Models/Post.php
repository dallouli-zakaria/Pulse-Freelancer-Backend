<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'location',
        'type',
        'description',
        'freelancers_number',
        'period',
        'periodvalue',
        'budget',
        'budgetvalue',
        'status',
        'client_id',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function freelancers()
    {
        return $this->belongsToMany(Freelancers::class, 'freelancer_post'); // Adjust 'freelancer_post' to your actual pivot table name
    }

    public function skills()
    {
        return $this->belongsToMany(skills::class, 'post_skills', 'post_id', 'skill_id'); // Adjust 'post_skill' to your actual pivot table name
    }
}

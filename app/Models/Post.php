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
        'skills_required',
        'period',
        'periodvalue',
        'budget',
        'budgetvalue',
        'client_id',
        
    ];

    function clientModel(){

        return $this->belongsTo(Client::class);
    }

    
    // function skills(){

    //     return $this->hasMany(skills::class);
    // }

    function offer(){
        return $this->belongsToMany(Freelancers::class);
    }

    public function skills()
    {
        return $this->belongsToMany(skills::class);
    }
    

}

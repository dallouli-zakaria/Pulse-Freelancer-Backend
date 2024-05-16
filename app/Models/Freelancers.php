<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Freelancers extends Model
{
    use HasFactory;

    protected $fillable = [
    
        'title',
        'dateOfBirth',
        'city',
        'TJM',
        'summary',
        'availability',
        'adress',
        'phone',
        'portfolio_Url',
        'CV'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

     function lunguage(){
        return $this->hasMany(languages::class);
     }
     function skill(){
         return $this->hasMany(skills::class);
     }

      function contract(){
        return $this->hasOne(Contract::class);
      }
    public function skills()
    {
        return $this->belongsToMany(skills::class, 'freelancer_skill')->withPivot('proficiency');
    }
    function experience(){
        return $this->hasMany(Expericence::class);
    }

    function education(){
        return $this->hasMany(Education::class);
    }
    function posts(){
        return $this->belongsToMany(Post::class);
    }

}

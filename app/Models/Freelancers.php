<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Freelancers extends User
{
    use HasFactory,HasRoles;

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
        'status'
    ];


    public function user()
    {
        return $this->belongsTo(User::class,'id','id');
    }

     function language(){
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
        return $this->belongsToMany(skills::class,'freelancer_skills', 'freelancer_id', 'skill_id');
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
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

}

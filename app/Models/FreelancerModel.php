<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class FreelancerModel extends User
{
    use HasFactory;

    protected $fillable = [
        'freelancer_profession',
        'freelancer_description',
        'freelancer_city',
        'freelancer_phone_number',
        'freelancer_adress',
        'freelancer_birth_date',
        'portfolio_URL',
        'CV'
    ];


     function lunguage(){
        return $this->hasMany(languages::class);
     }
     function skill(){
         return $this->hasMany(skills::class);
     }

      function contract(){
        return $this->hasOne(Contract::class);
      }


}

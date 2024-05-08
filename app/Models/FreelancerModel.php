<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class FreelancerModel extends User
{
    use HasFactory;

    protected $fillable = [
    
        'freelancer_profession',
        'freelancer_description',
        'freelancer_experience',
        'freelancer_city',
        'freelancer_phone_number',
        'freelancer_adress',
        'freelancer_birth_date',
        'portfolio_URL',
        'CV'
    ];


    public function skills()
    {
        return $this->belongsToMany(skills::class, 'freelancer_skill')->withPivot('proficiency');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $fillable=[
        'title',
        'description',
        'startDate',
        'endDate',
        'institution',
        'city',
        'freelancer_id'
    ];


    function freelancer(){
        return $this->belongsTo(Freelancers::class);
    }
}

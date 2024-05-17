<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expericence extends Model
{
    use HasFactory;

    protected $fillable=[
        
        'title',
        'companyName',
        'country',
        'city',
        'startDate',
        'endDate',
        'description',
        'freelancer_id'
    ];
    function freelancer(){
        return $this->belongsTo(Freelancers::class);
    }
}

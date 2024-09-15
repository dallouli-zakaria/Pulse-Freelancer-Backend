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
        'start_date',
        'end_date',
        'description',
        'freelancer_id'
    ];
    function freelancer(){
        return $this->belongsTo(Freelancers::class);
    }
}

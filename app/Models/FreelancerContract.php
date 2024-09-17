<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreelancerContract extends Model
{
    use HasFactory;

    protected $fillable=[
        'freelancer_id'
    ];

     function contract(){
        return $this->belongsTo(Contract::class);
    }
}

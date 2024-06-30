<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        'period',
        'budget',
        'project_description',
        'freelancer_id',
        'client_id'
        
    ];

    
    function client(){
        return $this->belongsTo(client::class);
    }
    function freelancer(){
        return $this->belongsTo(Freelancers::class);
    }
}

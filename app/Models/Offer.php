<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable=[
        'selected',
        'freelancer_id',
        'post_id'
    ] ;

    // function client(){
    //     return $this->belongsTo(Client::class);
    // }
    // function freelancer(){
    //     return $this->belongsTo(Freelancers::class);
    // }
}

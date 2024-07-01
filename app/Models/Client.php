<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends User
{
    use HasFactory;
    protected $fillable = [

        'profession',
        'company_name',
        'company_activity',
        'company_email',
        
    
        
    ];



        
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function posts(){
        return $this->hasMany(Post::class);
    }


    

}

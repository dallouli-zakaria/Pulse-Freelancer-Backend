<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;

class Client extends User
{
    use HasFactory,HasRoles;


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

    public function pack()
    {
        return $this->belongsTo(Pack::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }


    

}

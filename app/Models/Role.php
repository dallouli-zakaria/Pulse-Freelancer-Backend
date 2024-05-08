<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $fillable=[
        'name'
    ];

    public function roleUser(){
        return $this->belongsToMany(User::class);
    }
     
    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }
    
}

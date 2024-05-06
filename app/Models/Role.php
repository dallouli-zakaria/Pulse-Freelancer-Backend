<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable=[
        'name'
    ];

    public function roleUser(){
        return $this->belongsToMany(User::class);
    }
     
    public function rolePermission(){
        return $this->belongsToMany(Permission::class);
    }
}

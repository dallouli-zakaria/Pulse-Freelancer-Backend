<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role;

class Permission extends Model
{
    use HasFactory;
    protected $fillable=[
        'name'
    ];

   public function permession(){
    return $this->belongsToMany(Role::class);
   }



}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client_Company extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'field',
        'phone_number',
        'email',
        'ICE',
        'adresse',
        'website',

    ];


    function client(){
        return $this->belongsToMany(ClientModel::class);
    }
}

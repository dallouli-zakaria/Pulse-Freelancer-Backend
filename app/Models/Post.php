<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'location',
        'type',
        'description',
        'paiement_method',
        'period',
        'client_id'
    ];

    function clientModel(){

        return $this->belongsTo(Client::class);
    }

}

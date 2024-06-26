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
        'period',
        'periodvalue',
        'budget',
        'budgetvalue',
        'client_id',
        'created_at',
    ];

    function clientModel(){

        return $this->belongsTo(Client::class);
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostModel extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 
        'location',
        'type',
        'description',
        'paiement_method',
        'period'
    ];



    function clientModel(){

        return $this->belongsTo(ClientModel::class);
    }
}

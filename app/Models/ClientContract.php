<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientContract extends Model
{
    use HasFactory;

    protected $fillable=[

        'client_id'
    ];

    function contract(){
        return $this->belongsTo(Contract::class);
    }
}

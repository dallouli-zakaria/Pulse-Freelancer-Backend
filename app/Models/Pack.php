<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pack extends Model
{
    use HasFactory;
    
    protected $fillable=[
        'title',
        'description',
        'price',
        'client_ids'
    ];


    protected $casts = [
        'client_ids' => 'array',
    ];

    
    public function client(){
        $this->belongsTo(Client::class);
    }
}

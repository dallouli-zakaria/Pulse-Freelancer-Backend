<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        'start_date',
        'end_date',
        'description',
        'client_id',
        
    ];

    
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function freelancers()
    {
        return $this->belongsToMany(Freelancers::class,'contract_freelancer');
    }
}

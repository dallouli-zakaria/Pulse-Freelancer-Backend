<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contract extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        'start_date',
        'end_date',
        'project_description',
    ];

    
    function client(){
        return $this->belongsTo(client::class);
    }
    function freelancer(){
        return $this->belongsTo(Freelancers::class);
    }
    public function getFormattedstart_dateAttribute()
    {
        return $this->start_date ? Carbon::parse($this->start_date)->format('d/m/Y') : '';
    }

    public function getFormattedend_dateAttribute()
    {
        return $this->end_date ? Carbon::parse($this->end_date)->format('d/m/Y') : '';
    }
}
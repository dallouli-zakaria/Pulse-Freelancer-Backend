<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostSkill extends Model
{
    use HasFactory;

    protected $fillable=[
        'title',
        'post_id',
        'skill_id'
    ];

    public function skill()
    {
        return $this->belongsTo(skills::class, 'skill_id');
    }

}

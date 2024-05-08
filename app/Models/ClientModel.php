<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientModel extends User
{
    use HasFactory;

    protected $fillable = [
        'profession'];



        function company(){
            return $this->hasOne(Client_Company::class);
        }
}

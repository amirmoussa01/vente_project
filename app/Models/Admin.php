<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    //
    protected $fillable = [
        'username',
        'mdp',
    ];

    protected $hidden = [
        'mdp'
    ];
}

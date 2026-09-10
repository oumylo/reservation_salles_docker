<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Responsable extends Model
{
    protected $table = 'responsables';

    protected $fillable = [
        'nom',
        'email',
        'password',
        'role',
    ];
}

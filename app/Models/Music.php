<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Music extends Model
{

    protected $table = 'musics';

    protected $fillable = ['name', 'path'];
}

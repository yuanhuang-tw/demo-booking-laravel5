<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dj extends Model
{
    protected $table = 'djs';

    protected $fillable = ['date', 'start_hour', 'end_hour', 'msg'];
}

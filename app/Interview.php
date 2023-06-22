<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    protected $table = 'interviews';

    protected $fillable = [
        'user_id',
        'i_date',
        'i_time',
        'i_client',
        'i_note',
        'status',
        'contact',
        's_status',
        'i_type',
        'language',
        'tp',
        'interviewee',
        'additional',
        'pr',
        'stage_1',
        'stage_1_datetime',
        'department_status',
        'department_datetime',
    ];

    public function belongsToUser()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}

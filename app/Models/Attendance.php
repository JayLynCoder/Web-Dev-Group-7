<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendance';

    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'attendance_date',
        'time_in',
        'time_out',
    ];
}
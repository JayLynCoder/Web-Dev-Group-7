<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'student_number',
        'year_section',
        'college_program',
        'picture',
    ];
}
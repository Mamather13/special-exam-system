<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamRequest extends Model
{
    protected $table = 'requests'; // ✅ FIX HERE

    protected $fillable = [
        'student_id',
        'term',
        'school_year',
        'exam_type',
        'subject',
        'section',
        'teacher_name',
        'reason',
        'status',
        'payment_status'
    ];
}
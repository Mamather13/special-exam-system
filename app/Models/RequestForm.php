<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

protected $fillable = [
    'student_id',
    'term',
    'school_year',
    'exam_type',
    'subject',
    'subject_code',
    'section',
    'teacher_name',
    'reason',
    'parent_id_front',
    'parent_id_back',
    'parent_selfie',
    'parent_signature',
    'medical_certificate',
    'death_certificate',
    'supporting_document',
    'payment_status'
    'face_verified',
    'liveness_passed',
    'match_score',
    'face_verified_at',
];



class RequestForm extends Model
{
    //
}

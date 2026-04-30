<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequestController extends Controller
{
    public function store(Request $request)
    {
        /* ======================
           1. SAVE USER
        ====================== */
        $userId = DB::table('users')->insertGetId([
            'Lname'      => $request->Lname,
            'Fname'      => $request->Fname,
            'Mname'      => $request->Mname,
            'email'      => $request->email ?? $request->student_number . '@student.com',
            'role'       => 'student',
            'created_at' => now(),
        ]);

        /* ======================
           2. SAVE STUDENT
        ====================== */
        $studentId = DB::table('students')->insertGetId([
            'user_id'        => $userId,
            'student_number' => $request->student_number,
            'program'        => $request->program,
            'section'        => $request->section,
            'year_level'     => $request->year_level,
            'contact_number' => $request->contact_number,
        ]);

        /* ======================
           3. HANDLE FILE UPLOADS
        ====================== */
        if (!$request->input('face_verified') || $request->input('face_verified') == '0') {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Parent face verification must be completed before submitting.');
        }

        $parent_id_front = $request->file('parent_id_front')?->store('parent_id', 'public');
        $parent_id_back  = $request->file('parent_id_back')?->store('parent_id', 'public');
        $parent_selfie   = $request->file('parent_selfie')?->store('parent_id', 'public');

        $medical_certificate = $request->file('medical_certificate')?->store('documents', 'public');
        $death_certificate   = $request->file('death_certificate')?->store('documents', 'public');
        $supporting_document = $request->file('supporting_document')?->store('documents', 'public');

        /* ======================
           4. SIGNATURE (BASE64)
        ====================== */
        $signature_file = null;
        if ($request->signature) {
            $signature_data = str_replace('data:image/png;base64,', '', $request->signature);
            $signature_data = base64_decode($signature_data);
            $signature_file = 'signatures/' . time() . '.png';
            \Storage::disk('public')->put($signature_file, $signature_data);
        }

        /* ======================
           5. PAYMENT LOGIC
        ====================== */
        $payment_status = ($medical_certificate || $death_certificate)
            ? 'Exempted'
            : 'Pending Payment';

        /* ======================
           6. SAVE REQUEST
        ====================== */
        DB::table('requests')->insert([
            'student_id'          => $studentId,
            'term'                => $request->term,
            'school_year'         => $request->school_year,
            'exam_type'           => $request->exam_type,
            'subject'             => $request->subject,
            'subject_code'        => $request->subject_code,
            'section'             => $request->section,
            'teacher_name'        => $request->teacher_name,
            'reason'              => $request->reason_type,
            'parent_id_front'     => $parent_id_front,
            'parent_id_back'      => $parent_id_back,
            'parent_selfie'       => $parent_selfie,
            'parent_signature'    => $signature_file,
            'medical_certificate' => $medical_certificate,
            'death_certificate'   => $death_certificate,
            'supporting_document' => $supporting_document,
            'payment_status'      => $payment_status,
            'status'              => 'pending',
            'date_submitted'      => now(),
            'face_verified'       => $request->input('face_verified', 0),
            'liveness_passed'     => $request->input('liveness_passed', 0),
            'match_score'         => $request->input('match_score', 0),
            'face_verified_at'    => $request->input('face_verified') ? now() : null,
        ]);

        return redirect()->back()->with('success', 'Request submitted successfully!');
    }
}
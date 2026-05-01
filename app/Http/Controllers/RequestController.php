<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RequestController extends Controller
{
    public function store(Request $request)
    {
        $userId = session('user_id');

    // Debug - remove after fix
    if (!$userId) {
        return back()->with('error', 'Not logged in. Please login again.');
    }

    $student = DB::table('students')->where('user_id', $userId)->first();
    if (!$student) {
        // Try to find by session directly
        return back()->with('error', 'No student for user_id: ' . $userId . '. Students user_ids: ' . DB::table('students')->pluck('user_id')->implode(','));
    }

        $files = Session::get('verification_files', []);

        DB::table('requests')->insert([
            'student_id'          => $student->id,
            'term'                => $request->term,
            'school_year'         => $request->school_year,
            'exam_type'           => $request->exam_type ?? null,
            'subject'             => $request->subject,
            'subject_code'        => $request->subject_code,
            'section'             => $request->section,
            'teacher_name'        => $request->teacher_name,
            'reason'              => $request->reason_type,
            'status'              => 'pending_registrar',
            'date_submitted'      => now(),
            'parent_id_front'     => $files['parent_id_front']  ?? null,
            'parent_id_back'      => $files['parent_id_back']   ?? null,
            'parent_signature'    => $files['parent_signature'] ?? null,
            'parent_selfie'       => $files['parent_selfie']    ?? null,
            'medical_certificate' => $request->file('medical_certificate')?->store('docs', 'public'),
            'death_certificate'   => $request->file('death_certificate')?->store('docs', 'public'),
            'supporting_document' => $request->file('supporting_document')?->store('docs', 'public'),
            'face_verified'       => $request->face_verified ?? 0,
            'liveness_passed'     => $request->liveness_passed ?? 0,
            'match_score'         => $request->match_score ?? 0,
            'face_verified_at'    => now(),
            'payment_status'      => 'Pending Payment',
        ]);

        Session::forget('verification_files');

        return redirect()->route('student.dashboard')
            ->with('success', 'Request submitted successfully!');
    }
}
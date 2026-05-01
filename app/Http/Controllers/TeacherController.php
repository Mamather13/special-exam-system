<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    public function dashboard()
    {
        $userId = session('user_id');

        $teacher = DB::table('users')->where('id', $userId)->first();
        $teacherName = $teacher->teacher_name ?? null;

        // Get subjects with pending request counts for this teacher
        $subjects = DB::table('requests')
            ->where('teacher_name', $teacherName)
            ->where('status', 'pending_teacher')
            ->select('subject', 'subject_code', DB::raw('count(*) as total'))
            ->groupBy('subject', 'subject_code')
            ->get();

        $totalPending = $subjects->sum('total');

        // Get all pending requests for this teacher
        $requests = DB::table('requests')
            ->join('students', 'requests.student_id', '=', 'students.id')
            ->join('users', 'students.user_id', '=', 'users.id')
            ->where('requests.teacher_name', $teacherName)
            ->where('requests.status', 'pending_teacher')
            ->select(
                'requests.id',
                'requests.term',
                'requests.school_year',
                'requests.exam_type',
                'requests.subject',
                'requests.subject_code',
                'requests.section',
                'requests.teacher_name',
                'requests.reason',
                'requests.status',
                'requests.date_submitted',
                'requests.parent_id_front',
                'requests.parent_id_back',
                'requests.parent_selfie',
                'requests.parent_signature',
                'requests.medical_certificate',
                'requests.death_certificate',
                'requests.supporting_document',
                'requests.payment_status',
                'students.student_number',
                'students.program',
                'students.year_level',
                'users.Fname',
                'users.Lname'
            )
            ->orderBy('requests.date_submitted', 'desc')
            ->get();

        return view('teacher-dashboard', compact('subjects', 'totalPending', 'requests'));
    }

    public function approve($id)
{
    DB::table('requests')
        ->where('id', $id)
        ->update([
            'status' => 'pending_final'
        ]);

    return back()->with('success', 'Request fully approved.');
}

    public function reject($id)
{
    DB::table('requests')
        ->where('id', $id)
        ->update([
            'status' => 'rejected'
        ]);

    return back()->with('error', 'Request rejected.');
}
}
<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProgramHeadController extends Controller
{
    public function dashboard()
    {
        $courses = DB::table('requests')
            ->join('students', 'requests.student_id', '=', 'students.id')
            ->select('students.program', DB::raw('count(*) as total'))
            ->where('requests.status', 'pending_program_head')
            ->groupBy('students.program')
            ->get();

        $totalPending = $courses->sum('total');

        $finalApplications = DB::table('requests')
            ->join('students', 'requests.student_id', '=', 'students.id')
            ->join('users', 'students.user_id', '=', 'users.id')
            ->where('requests.status', 'pending_final')
            ->select(
                'requests.id',
                'requests.subject',
                'requests.subject_code',
                'requests.section',
                'requests.term',
                'requests.school_year',
                'requests.exam_type',
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
                'requests.or_number',
                'requests.amount_paid',
                'requests.receipt_path',
                'requests.receipt_at',
                'students.student_number',
                'students.program',
                'students.year_level',
                'users.Fname',
                'users.Lname'
            )
            ->orderBy('requests.date_submitted', 'desc')
            ->get();

        $totalFinal = $finalApplications->count();

        $requests = DB::table('requests')
            ->join('students', 'requests.student_id', '=', 'students.id')
            ->join('users', 'students.user_id', '=', 'users.id')
            ->where('requests.status', 'pending_program_head')
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

        return view('head-dashboard', compact('courses', 'totalPending', 'totalFinal', 'requests', 'finalApplications'));
    }

    public function approve($id)
    {
        DB::table('requests')
            ->where('id', $id)
            ->update(['status' => 'pending_teacher']);

        return back()->with('success', 'Forwarded to Teacher.');
    }

    public function finalApprove($id)
    {
        DB::table('requests')
            ->where('id', $id)
            ->update(['status' => 'scheduled']);

        return back()->with('success', 'Request scheduled successfully.');
    }

    public function reject($id)
    {
        DB::table('requests')
            ->where('id', $id)
            ->update(['status' => 'rejected']);

        return back()->with('error', 'Request rejected.');
    }

    public function departmentData(Request $request)
    {
        $examType = $request->exam_type;

        $paid = DB::table('requests')
            ->join('students', 'requests.student_id', '=', 'students.id')
            ->join('users', 'students.user_id', '=', 'users.id')
            ->where('requests.exam_type', $examType)
            ->where('requests.payment_status', 'Paid')
            ->select(
                DB::raw("DATE_FORMAT(requests.date_submitted, '%d/%m/%Y') as date_submitted"),
                DB::raw("CONCAT(users.Lname, ', ', users.Fname) as student_name"),
                'requests.section', 'requests.subject',
                'requests.subject_code', 'students.program'
            )
            ->get();

        $summary = DB::table('requests')
            ->where('exam_type', $examType)
            ->select('subject_code', 'subject', DB::raw('count(*) as count'))
            ->groupBy('subject_code', 'subject')
            ->get();

        $waived = DB::table('requests')
            ->join('students', 'requests.student_id', '=', 'students.id')
            ->join('users', 'students.user_id', '=', 'users.id')
            ->where('requests.exam_type', $examType)
            ->where('requests.payment_status', 'Exempted')
            ->select(
                DB::raw("DATE_FORMAT(requests.date_submitted, '%d/%m/%Y') as date_submitted"),
                DB::raw("CONCAT(users.Lname, ', ', users.Fname) as student_name"),
                'requests.section', 'requests.subject', 'requests.reason'
            )
            ->get();

        return response()->json(compact('paid', 'summary', 'waived'));
    }
}
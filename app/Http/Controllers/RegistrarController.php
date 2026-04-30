<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExamRequest; // adjust if your model name is different
use Illuminate\Support\Facades\DB;

class RegistrarController extends Controller
{
   public function dashboard()
{
    $pendingCount = DB::table('requests')
        ->where('status', 'pending')
        ->count();

    // TERTIARY (BS courses)
    $tertiaryCount = DB::table('requests')
        ->join('students', 'requests.student_id', '=', 'students.id')
        ->where('requests.status', 'pending')
        ->where('students.program', 'LIKE', '%BS%')
        ->count();

    // SHS (non-BS)
    $shsCount = DB::table('requests')
        ->join('students', 'requests.student_id', '=', 'students.id')
        ->where('requests.status', 'pending')
        ->where('students.program', 'NOT LIKE', '%BS%')
        ->count();

    return view('registrar.dashboard', compact(
        'pendingCount',
        'tertiaryCount',
        'shsCount'
    ));
}

public function courses($type)
{
    $query = DB::table('requests')
        ->join('students', 'requests.student_id', '=', 'students.id')
        ->where('requests.status', 'pending');

    // 🔥 FILTER BASED ON TYPE
    if ($type === 'tertiary') {
        $query->where('students.program', 'LIKE', 'BS%');
    } else {
        $query->where('students.program', 'NOT LIKE', 'BS%');
    }

    $courses = $query
        ->select('students.program', DB::raw('count(*) as total'))
        ->groupBy('students.program')
        ->get();

    return view('registrar.courses', compact('courses', 'type'));
}

public function submissions($course)
{
    $requests = DB::table('requests')
        ->join('students', 'requests.student_id', '=', 'students.id')
        ->where('students.program', $course)
        ->where('requests.status', 'pending')
        ->select('requests.*', 'students.student_number')
        ->get();

    return view('registrar.submissions', compact('requests', 'course'));
}
    public function approve($id)
    {
        $request = ExamRequest::findOrFail($id);
        $request->status = 'approved';
        $request->save();

        return redirect()->back()->with('success', 'Request approved');
    }

    public function reject($id)
    {
        $request = ExamRequest::findOrFail($id);
        $request->status = 'rejected';
        $request->save();

        return redirect()->back()->with('error', 'Request rejected');
    }
}
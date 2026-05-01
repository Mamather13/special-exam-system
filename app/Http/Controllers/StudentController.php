<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\SpecialExam;

class StudentController extends Controller
{
    
    public function dashboard()
 {
    $userId = session('user_id');

    $student = DB::table('students')
        ->where('user_id', $userId)
        ->first();

    $requests = collect();

    if ($student) {
        $requests = DB::table('requests')
            ->join('students', 'requests.student_id', '=', 'students.id')
            ->join('users', 'students.user_id', '=', 'users.id')
            ->where('requests.student_id', $student->id)
            ->select(
                'requests.*',
                'students.student_number',
                'students.program',
                'students.year_level',
                'users.Fname',
                'users.Lname'
            )
            ->orderBy('requests.date_submitted', 'desc')
            ->get();
    }

    return view('student-dashboard', compact('requests'));
 }

    public function getSubjects(Request $request)
    {
        $subjects = DB::table('subjects')
            ->where('program', $request->program)
            ->where('year_level', $request->year_level)
            ->where('section', $request->section)
            ->select('subject_title', 'subject_code')
            ->distinct()
            ->get();

        return response()->json($subjects);
    }

    public function getSections(Request $request)
    {
        $sections = DB::table('subjects')
            ->where('program', $request->program)
            ->where('year_level', $request->year_level)
            ->select('section')
            ->distinct()
            ->orderBy('section')
            ->pluck('section');

        return response()->json($sections);
    }
    public function uploadReceipt(Request $request, $id)
{
    $request->validate([
        'receipt' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048'
    ]);

    $file = $request->file('receipt');
    $filename = time() . '.' . $file->getClientOriginalExtension();

    $file->move(public_path('receipts'), $filename);

    // save to database
    \DB::table('requests')
    ->where('id', $id)
    ->update([
        'receipt_path'  => $filename,
        'payment_status'=> 'submitted',
        'or_number'     => $request->or_number,
        'amount_paid'   => 200.00,
        'receipt_at'    => now(),
        'status'        => 'pending_final',
    ]);

    return back()->with('success', 'Receipt uploaded successfully!');
}
}

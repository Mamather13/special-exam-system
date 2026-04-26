<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function dashboard()
    {
        // For now, show all requests joined with student info
        // Later this will filter by logged-in student session
        $requests = DB::table('requests')
            ->join('students', 'requests.student_id', '=', 'students.id')
            ->join('users', 'students.user_id', '=', 'users.id')
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
}
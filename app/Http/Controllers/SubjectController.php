<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    public function getPrograms()
    {
        $programs = DB::table('subjects')
            ->select('program')
            ->distinct()
            ->orderBy('program')
            ->pluck('program');

        return response()->json($programs);
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
}
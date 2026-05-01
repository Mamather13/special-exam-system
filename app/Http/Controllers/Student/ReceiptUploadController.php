<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ReceiptUploadController extends Controller
{
    public function show($id)
    {
        $userId = session('user_id');
        abort_if(!$userId, 403);

        $student = DB::table('students')
            ->where('user_id', $userId)
            ->first();

        abort_if(!$student, 403);

        $application = DB::table('requests')
            ->where('id', $id)
            ->where('student_id', $student->id)
            ->first();

        abort_if(!$application, 404);
        abort_if($application->status !== 'approved', 403, 'Receipt upload is not available at this stage.');

        return view('student.upload-receipt', compact('application'));
    }

    public function store(Request $request, $id)
    {
        $userId = session('user_id');
        abort_if(!$userId, 403);

        $student = DB::table('students')
            ->where('user_id', $userId)
            ->first();

        abort_if(!$student, 403);

        $application = DB::table('requests')
            ->where('id', $id)
            ->where('student_id', $student->id)
            ->first();

        abort_if(!$application, 404);
        abort_if($application->status !== 'approved', 403, 'Receipt upload is not available at this stage.');

        $request->validate([
            'or_number'    => ['required', 'string', 'max:50'],
            'receipt_file' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ]);

        $path = $request->file('receipt_file')->store("receipts/{$id}", 'public');

        DB::table('requests')
            ->where('id', $id)
            ->update([
                'or_number'    => $request->or_number,
                'amount_paid'  => 200.00,
                'receipt_path' => $path,
                'receipt_at'   => now(),
                'status'       => 'pending_final',
            ]);

        return redirect('/student')
            ->with('success', 'Receipt submitted! Your application is now pending final approval.');
    }
}
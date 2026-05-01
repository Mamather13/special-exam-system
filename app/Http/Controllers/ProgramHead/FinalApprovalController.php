<?php

namespace App\Http\Controllers\ProgramHead;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FinalApprovalController extends Controller
{
    /**
     * Show the receipt review page.
     * Only for applications with status = 'pending_final'.
     */
    public function show(Application $application)
    {
        abort_if($application->status !== 'pending_final', 403, 'This application is not pending final approval.');

        // Eager load student so the view can show their name/number
        $application->load('student');

        return view('program_head.review-receipt', compact('application'));
    }

    /**
     * Serve the uploaded receipt file securely (never expose storage path to browser).
     */
    public function serveReceipt(Application $application)
    {
        abort_if(! Storage::disk('private')->exists($application->receipt_path), 404);

        return Storage::disk('private')->response($application->receipt_path);
    }

    /**
     * Handle approve or reject decision.
     */
    public function decision(Request $request, Application $application)
    {
        abort_if($application->status !== 'pending_final', 403);

        $request->$request->validate([
                'action' => ['required', 'in:approve,reject'],
                ]);

        if ($request->action === 'approve') {
            $application->update([
                'status'           => 'scheduled', 
                'ph_final_at'      => now(),
                'ph_final_by'      => auth()->id(),
            ]);

            // Optional: fire an event/notification to the student here
            // event(new ApplicationScheduled($application));

            return redirect()
                ->route('program_head.applications.index')
                ->with('success', "Application for {$application->student->name} approved and moved to Scheduled.");
        }

        // Reject
        $application->update([
            'status'           => 'rejected',
            'ph_final_at'      => now(),
            'ph_final_by'      => auth()->id(),
        ]);

        // Optional: notify student
        // event(new ApplicationRejected($application));

        return redirect()
            ->route('program_head.applications.index')
            ->with('success', "Application rejected. The student has been notified.");
    }
}

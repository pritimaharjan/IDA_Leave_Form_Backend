<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Leave;
use App\Models\LeaveApplication;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class LeaveApplicationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
            'leave_slug' => 'required|string|exists:leaves,slug',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string|max:500',
            'documents' => 'nullable|array',
            'documents.*' => 'file|mimes:pdf,jpg,jpeg,png|max:2048', // each file validation
        ]);

        // Fetch the user
        $user = User::where('email', $validated['email'])->firstOrFail();
        Log::info('User found: '.$user->name.', Line Manager ID: '.$user->line_manager_id);

        // Fetch the leave type by slug
        $leave = Leave::where('slug', $validated['leave_slug'])->firstOrFail();

        // Calculate total days
        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);
        $totalDays = $startDate->diffInDays($endDate) + 1;

        // Create leave application
        $leaveApplication = LeaveApplication::create([
            'user_id' => $user->id,
            'leave_id' => $leave->id,
            'department_id' => $user->department_id,
            'line_manager_id' => $user->line_manager_id,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'total_days' => $totalDays,
            'reason' => $validated['reason'] ?? null,
            'status' => 'pending',
            'applied_at' => now(),
        ]);

        // Handle document uploads
        if (! empty($validated['documents'])) {
            foreach ($validated['documents'] as $file) {
                $filePath = $file->store('documents', 'public');

                Document::create([
                    'leave_application_id' => $leaveApplication->id,
                    'file_path' => $filePath,
                ]);
            }
        }

        return response()->json([
            'message' => 'Leave application created successfully.',
            'data' => [
                'id' => $leaveApplication->id,
                'employee_name' => $user->name,
                'department' => optional($user->department)->name,
                'leave_type' => $leave->name,
                'start_date' => $leaveApplication->start_date,
                'end_date' => $leaveApplication->end_date,
                'total_days' => $leaveApplication->total_days,
                'reason' => $leaveApplication->reason,
                'status' => $leaveApplication->status,
                'documents' => $leaveApplication->documents->map(fn ($doc) => [
                    'id' => $doc->id,
                    'file_path' => Storage::url($doc->file_path),
                ]),
            ],
        ], 201);
    }
}

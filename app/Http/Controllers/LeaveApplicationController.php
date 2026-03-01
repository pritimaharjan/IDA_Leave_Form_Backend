<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\LeaveApplication;
use Illuminate\Http\Request;

class LeaveApplicationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'users_id' => 'required|exists:users,id',
            'department_id' => 'required|exists:departments,id',
            'leave_type_id' => 'required|exists:leave_type,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'total_days' => 'required|integer|min:1',
            'reason' => 'nullable|string|max:500',
            'documents.*' => 'file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ]);
        $leaveApplication = LeaveApplication::create([
            'users_id' => $validated['users_id'],
            'department_id' => $validated['department_id'],
            'leave_type_id' => $validated['leave_type_id'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'total_days' => $validated['total_days'],
            'reason' => $validated['reason'] ?? null,
            'status' => 'pending',
        ]);

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $file) {
                $path = $file->store('leave_documents', 'public');
                Document::create([
                    'leave_application_id' => $leaveApplication->id,
                    'file_path' => $path,
                ]);
            }

        }

        return response()->json([
            'message' => 'Leave Application created successfully',
            'data' => $leaveApplication->load('documents'),
        ], 200);

    }
}

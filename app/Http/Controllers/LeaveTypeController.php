<?php

namespace App\Http\Controllers;

use App\Models\Leave;

class LeaveTypeController extends Controller
{
    public function show()
    {
        $leaveTypes = Leave::all();

        return response()->json([
            'message' => 'Leave type list',
            'data' => $leaveTypes,
        ]);

    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveApplication extends Model
{
    protected $fillable = [
        'users_id',
        'leave_type_id',
        'start_date',
        'end_date',
        'total_days',
        'reason',
        'status',
        'line_manager_id',
        'applied_at',
        'approved_by',
        'approved_timestamp',
        'manager_remark',
        'department_id',

    ];

    public function employee()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveTypes::class, 'leave_type_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function lineManager()
    {
        return $this->belongsTo(User::class, 'line_manager_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}

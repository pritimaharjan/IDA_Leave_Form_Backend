<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveApplication extends Model
{
    protected $fillable = [
        'user_id',
        'leave_id',
        'department_id',
        'line_manager_id',
        'start_date',
        'end_date',
        'total_days',
        'reason',
        'status',
        'applied_at',
        'approved_by',
        'approved_timestamp',
        'manager_remark',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'applied_at' => 'datetime',
        'approved_timestamp' => 'datetime',
    ];

    /** Relationships **/
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function leave()
    {
        return $this->belongsTo(Leave::class, 'leave_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
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
        return $this->hasMany(Document::class, 'leave_application_id');
    }
}

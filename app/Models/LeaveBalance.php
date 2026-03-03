<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveBalance extends Model
{
    protected $fillable = [
        'users_id',
        'leave_type_id',
        'year',
        'total_allocated',
        'used_days',
        'remaining_days',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function leaveType()
    {
        return $this->belongsTo(Leave::class);
    }
}

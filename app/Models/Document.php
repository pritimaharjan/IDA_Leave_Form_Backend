<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'leave_application_id',
        'file_path',
    ];

    public function leaveApplication()
    {
        return $this->belongsTo(LeaveApplication::class);
    }
}

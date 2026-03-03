<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, HasRoles, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'employee_id',
        'phone_number',
        'designation',
        'department_id',
        'line_manager_id',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->password)) {
                $user->password = bcrypt('password'); // Set a default password or handle as needed
            }
        });
    }

    /** Relationships **/
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function lineManager()
    {
        return $this->belongsTo(User::class, 'line_manager_id');
    }

    public function leaveApplications()
    {
        return $this->hasMany(LeaveApplication::class, 'user_id');
    }
}

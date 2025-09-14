<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        "status",
        "student_id",
        "session_id",
        "enrollment_id",
    ];

    public function session()
    {
        return $this->belongsTo(OfferingSession::class, "session_id");
    }

    public function student()
    {
        return $this->belongsTo(User::class, "student_id");
    }

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class, "enrollment_id");
    }
}

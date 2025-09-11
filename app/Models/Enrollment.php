<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable = ["workshop_offering_id", "student_id"];

    public function class()
    {
        return $this->belongsTo(
            WorkshopOffering::class,
            "workshop_offering_id",
        );
    }

    public function student()
    {
        return $this->belongsTo(User::class, "student_id");
    }
}

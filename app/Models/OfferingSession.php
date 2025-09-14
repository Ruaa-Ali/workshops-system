<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfferingSession extends Model
{
    protected $fillable = ["session_date", "status", "workshop_offering_id"];

    public function offering()
    {
        return $this->belongsTo(
            WorkshopOffering::class,
            "workshop_offering_id",
        );
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, "session_id");
    }
}

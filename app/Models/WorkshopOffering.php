<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkshopOffering extends Model
{
    protected $fillable = [
        "start_date",
        "end_date",
        "hours_per_day",
        "max_capacity",
        "price",
        "workshop_id",
        "teacher_id",
        "off_days",
    ];

    protected $casts = [
        "start_date" => "date",
        "end_date" => "date",
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, foreignKey: "teacher_id");
    }

    public function workshop(): BelongsTo
    {
        return $this->belongsTo(Workshop::class, foreignKey: "workshop_id");
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, "workshop_offering_id");
    }

    public function students()
    {
        return $this->belongsToMany(
            User::class,
            "enrollments",
            "workshop_offering_id",
            "student_id",
        )->withTimestamps();
    }

    public function sessions()
    {
        return $this->hasMany(OfferingSession::class, "workshop_offering_id");
    }
}

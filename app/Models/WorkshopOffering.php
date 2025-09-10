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
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, foreignKey: "teacher_id");
    }

    public function workshop(): BelongsTo
    {
        return $this->belongsTo(Workshop::class, foreignKey: "workshop_id");
    }
}

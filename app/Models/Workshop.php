<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Workshop extends Model
{
    /** @use HasFactory<\Database\Factories\WorkshopFactory> */
    use HasFactory;

    // protected $table = "workshops";
    protected $fillable = [
        "title_en",
        "description_en",
        "title_ar",
        "description_ar",
        "duration_hours",
        "initial_price",
        "image",
        "created_by",
    ];

    protected $casts = [
        "initial_price" => "decimal:2",
        "duration_hours" => "integer",
    ];

    /**
     * @return BelongsTo<User,Workshop>
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, "created_by");
    }

    public function offerings(): BelongsTo
    {
        return $this->hasMany(WorkshopOffering::class, "workshop_id");
    }

    // Accessor for current locale title
    public function getTitleAttribute(): string
    {
        return app()->getLocale() === "ar" ? $this->title_ar : $this->title_en;
    }

    // Accessor for current locale description
    public function getDescriptionAttribute(): string
    {
        return app()->getLocale() === "ar"
            ? $this->description_ar
            : $this->description_en;
    }
}

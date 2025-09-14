<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Collection;

trait CalculateOfferingDates
{
    public function calculateEndDate(
        $startDate,
        $totalHours,
        $hoursPerDay,
        $skipDayNumbers = [5],
    ) {
        // 5=Friday,
        $currentDate = Carbon::parse($startDate);
        $remainingHours = $totalHours;

        while ($remainingHours > 0) {
            // Check if current day should be skipped (using numeric representation)
            if (in_array($currentDate->dayOfWeek, $skipDayNumbers)) {
                $currentDate->addDay();
                continue;
            }

            // Deduct hours for this day
            $remainingHours -= $hoursPerDay;

            // If we still have hours left, move to next day
            if ($remainingHours > 0) {
                $currentDate->addDay();
            }
        }

        return $currentDate;
    }

    public function getBusinessDatesByEndDate(
        Carbon $startDate,
        Carbon $endDate,
        array $offDays,
    ): Collection {
        $businessDates = new Collection();
        $currentDate = $startDate->copy()->startOfDay();
        $endDate = $endDate->copy()->startOfDay();

        while ($currentDate->lte($endDate)) {
            // Get the current day of the week (Carbon style, 1=Monday)
            $dayOfWeek = $currentDate->dayOfWeekIso;

            // Check if the current day is NOT in the off-days array
            if (!in_array($dayOfWeek, $offDays)) {
                $businessDates->push($currentDate->copy());
            }

            // Move to the next day
            $currentDate->addDay();
        }

        return $businessDates;
    }

    public function getBusinessDatesByDuration(
        Carbon $startDate,
        int $durationHours,
        int $hoursPerDay,
        array $offDays,
    ): Collection {
        if ($hoursPerDay <= 0) {
            throw new \InvalidArgumentException(
                "Hours per day must be a positive integer.",
            );
        }

        $businessDates = new Collection();
        $currentDate = $startDate->copy();
        $remainingHours = $durationHours;

        while ($remainingHours > 0) {
            $dayOfWeek = $currentDate->dayOfWeekIso;

            if (!in_array($dayOfWeek, $offDays)) {
                // Add the current day to the collection
                $businessDates->push($currentDate->copy());
                $remainingHours -= $hoursPerDay;
            }

            // Move to the next day
            if ($remainingHours > 0) {
                $currentDate->addDay();
            }
        }

        return $businessDates;
    }
}

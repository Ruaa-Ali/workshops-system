<?php

namespace App\Exports;

use App\Models\WorkshopOffering;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class AttendanceExport implements FromQuery, WithHeadings, WithMapping
{
    private $workshopOffering;
    private $sessions;

    public function __construct(WorkshopOffering $workshopOffering)
    {
        $this->workshopOffering = $workshopOffering;
        $this->sessions = $workshopOffering->sessions
            ->pluck("session_date", "id")
            ->toArray();
    }

    public function query()
    {
        return $this->workshopOffering->students()->with([
            "attendances" => function ($query) {
                $query->whereIn("session_id", array_keys($this->sessions));
            },
        ]);
    }

    public function headings(): array
    {
        $headings = ["Student Name"];
        foreach ($this->sessions as $date) {
            $headings[] = Carbon::parse($date)->format("Y-m-d");
        }
        return $headings;
    }

    public function map($student): array
    {
        $attendanceData = [];
        $attendanceData[] = $student->name;

        $studentAttendance = $student->attendances
            ->pluck("status", "session_id")
            ->toArray();

        foreach (array_keys($this->sessions) as $sessionId) {
            $status = $studentAttendance[$sessionId] ?? "";
            $attendanceData[] = ucfirst($status);
        }

        return $attendanceData;
    }
}

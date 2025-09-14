<?php

namespace App\Livewire\Teachers;

use App\Enums\PermissionsTypes;
use App\Models\WorkshopOffering;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Excel;
use App\Exports\AttendanceExport;

#[Layout("layouts.app")]
class IndexTeacherClasses extends Component
{
    use WithPagination;

    public function fetchTeacherClasses()
    {
        $this->authorize(PermissionsTypes::MANAGE_OWN_OFFERINGS);
        return WorkshopOffering::with("workshop")
            ->where("teacher_id", "=", auth()->id())
            ->orderBy("start_date", "asc")
            ->paginate(10);
        // Enrollment::with("class.workshop", "class.teacher")
        //     ->where("student_id", "=", auth()->id())
        //     ->join(
        //         "workshop_offerings",
        //         "enrollments.workshop_offering_id",
        //         "=",
        //         "workshop_offerings.id",
        //     )
        //     ->orderBy("workshop_offerings.start_date", "asc")
        //     ->paginate(5);
    }

    public function exportAttendance($id)
    {
        // $workshopOffering = WorkshopOffering::with(["sessions", "students."]);
        $workshopOffering = WorkshopOffering::with([
            "sessions:id,session_date,workshop_offering_id",
            "students.attendances" => function ($query) {
                $query->select(
                    "attendances.id",
                    "session_id",
                    "enrollment_id",
                    "status",
                );
            },
        ])->find($id);
        $fileName = "attendance_{$id}.xlsx";
        return Excel::download(
            new AttendanceExport($workshopOffering),
            $fileName,
        );
    }

    #[On("teacher-classes-updated")]
    public function render()
    {
        $classes = $this->fetchTeacherClasses();
        return view(
            "livewire.teachers.index-teacher-classes",
            compact("classes"),
        );
    }
}

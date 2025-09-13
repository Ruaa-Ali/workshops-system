<?php

namespace App\Livewire\Teachers;

use App\Enums\PermissionsTypes;
use App\Models\WorkshopOffering;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

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

<?php

namespace App\Livewire\StudentClasses;

use App\Enums\PermissionsTypes;
use App\Models\Enrollment;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Layout;

#[Layout("layouts.app")]
class IndexStudentClasses extends Component
{
    use WithPagination;

    public function fetchUserClasses()
    {
        $this->authorize(PermissionsTypes::VIEW_CLASSES);
        return Enrollment::with("class.workshop", "class.teacher")
            ->where("student_id", "=", auth()->id())
            ->join(
                "workshop_offerings",
                "enrollments.workshop_offering_id",
                "=",
                "workshop_offerings.id",
            )
            ->orderBy("workshop_offerings.start_date", "asc")
            ->paginate(5);
    }

    #[On("user-classes-updated")]
    public function render()
    {
        $enrollments = $this->fetchUserClasses();

        // dd($enrollments);
        return view(
            "livewire.student-classes.index-student-classes",
            compact("enrollments"),
        );
    }
}

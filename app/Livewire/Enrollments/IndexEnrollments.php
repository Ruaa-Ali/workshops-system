<?php

namespace App\Livewire\Enrollments;

use App\Models\Enrollment;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout("layouts.app")]
class IndexEnrollments extends Component
{
    use WithPagination;

    public function fetchEnrollments()
    {
        return Enrollment::with("class.workshop", "student")->paginate(10);
    }

    public function render()
    {
        $entollments = $this->fetchEnrollments();
        $this->resetPage();
        return view(
            "livewire.enrollments.index-enrollments",
            compact("entollments"),
        );
    }
}

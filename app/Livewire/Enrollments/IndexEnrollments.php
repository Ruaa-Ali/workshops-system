<?php

namespace App\Livewire\Enrollments;

use App\Enums\PermissionsTypes;
use App\Models\Enrollment;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout("layouts.app")]
class IndexEnrollments extends Component
{
    use WithPagination;

    public $search = "";

    public function fetchEnrollments()
    {
        $this->authorize(PermissionsTypes::VIEW_ENROLLMENTS);
        return Enrollment::with(["class.workshop", "student"])
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query
                        ->where("enrollments.id", "like", "%{$this->search}%")
                        ->orWhereHas("student", function ($query) {
                            // WHERE group for student
                            $query->where("name", "like", "%{$this->search}%");
                        })
                        ->orWhereHas("class", function ($query) {
                            // WHERE group for class
                            $query->whereHas("workshop", function ($query) {
                                // WHERE group for workshop
                                $query
                                    ->where(
                                        "title_ar",
                                        "like",
                                        "%{$this->search}%",
                                    )
                                    ->orWhere(
                                        "title_en",
                                        "like",
                                        "%{$this->search}%",
                                    );
                            });
                        });
                });
            })
            ->paginate(10);
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

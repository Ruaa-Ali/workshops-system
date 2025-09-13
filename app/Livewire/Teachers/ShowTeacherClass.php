<?php

namespace App\Livewire\Teachers;

use App\Enums\PermissionsTypes;
use App\Models\WorkshopOffering;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout("layouts.app")]
class ShowTeacherClass extends Component
{
    public WorkshopOffering $offering;

    public function mount(string $id)
    {
        $this->authorize(PermissionsTypes::MANAGE_OWN_OFFERINGS);
        $this->offering = WorkshopOffering::with([
            "teacher",
            "workshop",
            "students",
        ])->find($id);
    }

    public function render()
    {
        return view("livewire.teachers.show-teacher-class");
    }
}

<?php

namespace App\Livewire\Offerings;

use App\Enums\PermissionsTypes;
use App\Models\WorkshopOffering;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout("layouts.app")]
class ShowOffering extends Component
{
    public WorkshopOffering $offering;

    public function mount(string $id)
    {
        $this->authorize(PermissionsTypes::MANAGE_OFFERINGS);
        $this->offering = WorkshopOffering::with([
            "teacher",
            "workshop",
            "students",
        ])->find($id);
    }

    public function render()
    {
        return view("livewire.offerings.show-offering");
    }
}

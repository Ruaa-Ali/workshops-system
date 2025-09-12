<?php

namespace App\Livewire\Workshops;

use Livewire\Component;
use App\Models\Workshop;
use Livewire\Attributes\Layout;

#
#[Layout("layouts.app")]
class ShowWorkshop extends Component
{
    public Workshop $workshop;

    public function mount(string $id)
    {
        $this->workshop = Workshop::with(["creator", "offerings"])->find($id);
    }

    public function render()
    {
        return view("livewire.workshops.show-workshop");
    }
}

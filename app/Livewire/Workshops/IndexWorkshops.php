<?php

namespace App\Livewire\Workshops;
use App\Models\Workshop;
use Livewire\Attributes\Layout;

use Livewire\Component;

#[Layout("layouts.app")]
class IndexWorkshops extends Component
{
    public function fetchWorkshops()
    {
        return Workshop::with("creator")->paginate(5);
    }

    public function render()
    {
        $workshops = $this->fetchWorkshops();
        return view("livewire.workshops.index-workshops", compact("workshops"));
    }
}

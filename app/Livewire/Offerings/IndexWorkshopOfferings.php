<?php

namespace App\Livewire\Offerings;

use App\Models\WorkshopOffering;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout("layouts.app")]
class IndexWorkshopOfferings extends Component
{
    public function fetchOfferings()
    {
        return WorkshopOffering::with(["workshop", "teacher"])->paginate(5);
    }

    public function render()
    {
        $offerings = $this->fetchOfferings();
        return view(
            "livewire.offerings.index-workshop-offerings",
            compact("offerings"),
        );
    }
}

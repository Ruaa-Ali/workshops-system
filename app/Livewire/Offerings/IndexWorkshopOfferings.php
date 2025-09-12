<?php

namespace App\Livewire\Offerings;

use App\Models\WorkshopOffering;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout("layouts.app")]
class IndexWorkshopOfferings extends Component
{
    protected $listeners = ["offering-deleted" => '$refresh'];

    public function fetchOfferings()
    {
        return WorkshopOffering::with(["workshop", "teacher"])
            // ->whereHas("workshop", function ($query) {
            //     $query->whereNull("deleted_at"); // For soft deletes
            // })
            ->paginate(5);
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

<?php

namespace App\Livewire\Offerings;

use App\Enums\PermissionsTypes;
use App\Models\WorkshopOffering;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout("layouts.app")]
class IndexWorkshopOfferings extends Component
{
    use WithPagination;
    protected $listeners = ["offering-deleted" => '$refresh'];

    public function fetchOfferings()
    {
        $this->authorize(PermissionsTypes::MANAGE_OFFERINGS);
        return WorkshopOffering::with(["workshop", "teacher"])
            // ->whereHas("workshop", function ($query) {
            //     $query->whereNull("deleted_at"); // For soft deletes
            // })
            ->paginate(5);
    }

    public function render()
    {
        $offerings = $this->fetchOfferings();
        $this->resetPage();
        return view(
            "livewire.offerings.index-workshop-offerings",
            compact("offerings"),
        );
    }
}

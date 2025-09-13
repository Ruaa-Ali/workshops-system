<?php

namespace App\Livewire\Offerings;

use App\Enums\PermissionsTypes;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\WorkshopOffering;

#[Layout("layouts.app")]
class IndexOfferingsForStudents extends Component
{
    public function fetchOfferings()
    {
        $this->authorize(PermissionsTypes::VIEW_CLASSES);
        return WorkshopOffering::with(["workshop", "teacher"])
            ->whereHas("workshop", function ($query) {
                $query->whereNull("deleted_at"); // For soft deletes
            })
            ->whereDate("start_date", ">=", now()) // Offerings starting today or later
            ->orderBy("start_date", "asc") // Order by upcoming first
            ->paginate(6);
    }

    public function render()
    {
        $offerings = $this->fetchOfferings();

        return view(
            "livewire.offerings.index-offerings-for-students",
            compact("offerings"),
        );
    }
}

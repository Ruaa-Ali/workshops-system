<?php

namespace App\Livewire\Workshops;
use App\Enums\PermissionsTypes;
use App\Models\Workshop;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout("layouts.app")]
class IndexWorkshops extends Component
{
    use WithPagination;

    public function fetchWorkshops()
    {
        $this->authorize(PermissionsTypes::VIEW_WORKSHOPS);
        return Workshop::with("creator")
            ->withTrashed()
            ->orderByRaw("deleted_at IS NOT NULL, deleted_at DESC")
            ->paginate(5);
    }

    #[On("workshop-deleted")]
    public function render()
    {
        $workshops = $this->fetchWorkshops();
        $this->resetPage();
        return view("livewire.workshops.index-workshops", compact("workshops"));
    }
}

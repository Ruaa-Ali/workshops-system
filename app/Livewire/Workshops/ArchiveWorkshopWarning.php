<?php

namespace App\Livewire\Workshops;

use App\Models\Workshop;
use App\Traits\ToastNotifications;
use Illuminate\Database\QueryException;
use LivewireUI\Modal\ModalComponent;

class ArchiveWorkshopWarning extends ModalComponent
{
    use ToastNotifications;

    public Workshop $workshop;

    public function mount(Workshop $workshop)
    {
        $this->workshop = $workshop;
    }

    public function archive()
    {
        try {
            $this->workshop->delete();
            $this->dispatch("workshop-deleted");
            $this->toastSuccess(__("messages.archived_successfully"));
            $this->closeModal();
        } catch (QueryException $e) {
            $this->toastError($e->getMessage());
            $this->closeModal();
        }
    }

    public function render()
    {
        return view("livewire.workshops.archive-workshop-warning");
    }
}

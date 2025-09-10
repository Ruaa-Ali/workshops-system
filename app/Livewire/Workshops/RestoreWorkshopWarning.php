<?php

namespace App\Livewire\Workshops;

use App\Models\Workshop;
use App\Traits\ToastNotifications;
use Illuminate\Database\QueryException;
use LivewireUI\Modal\ModalComponent;

class RestoreWorkshopWarning extends ModalComponent
{
    use ToastNotifications;

    public Workshop $workshop;

    public function mount($id)
    {
        $this->workshop = Workshop::onlyTrashed()->find($id);
    }

    public function restore()
    {
        try {
            $this->workshop->restore();
            $this->dispatch("workshop-deleted");
            $this->toastSuccess(__("messages.restored_successfully"));
            $this->closeModal();
        } catch (QueryException $e) {
            $this->toastError($e->getMessage());
            $this->closeModal();
        }
    }

    public function render()
    {
        return view("livewire.workshops.restore-workshop-warning");
    }
}

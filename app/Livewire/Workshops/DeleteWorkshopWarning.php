<?php

namespace App\Livewire\Workshops;

use App\Models\Workshop;
// use Illuminate\Support\Facades\Gate;

use Illuminate\Database\QueryException;
use LivewireUI\Modal\ModalComponent;
use App\Traits\ToastNotifications;

class DeleteWorkshopWarning extends ModalComponent
{
    use ToastNotifications;

    public string $id;
    public Workshop $workshop;
    public string $title;

    public function mount()
    {
        $this->workshop = Workshop::with("offerings")->find($this->id);
        $this->title = $this->workshop->title_ar;
        if (app()->getLocale() == "en") {
            $this->title = $this->workshop->title_en;
        }
    }

    public function delete()
    {
        try {
            // TODO: create a policy first
            // if (Gate::denies("delete", $this->workshop)) {
            //     $this->toastError(__("messages.not_auth_for_operation"));
            //     $this->dispatch("closeModal");
            // }

            // TODO: must handle when workshops has offerings
            if (count($this->workshop->offerings)) {
                $this->toastError(__("messages.workshop_has_offerings"));
                $this->closeModal();
                return;
            }
            $this->workshop->delete();
            $this->dispatch("workshop-deleted");
            $this->toastSuccess(__("messages.deleted_successfully"));
            $this->closeModal();
        } catch (QueryException $e) {
            $this->toastError($e->getMessage());
            $this->closeModal();
        }
    }

    public function render()
    {
        return view("livewire.workshops.delete-workshop-warning");
    }
}

<?php

namespace App\Livewire\Workshops;

use App\Models\Workshop;
// use Illuminate\Support\Facades\Gate;
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
        $this->workshop = Workshop::find($this->id);
        $this->title = $this->workshop->title_ar;
        if (app()->getLocale() == "en") {
            $this->title = $this->workshop->title_en;
        }
    }

    public function delete()
    {
        // TODO: create a policy first
        // if (Gate::denies("delete", $this->workshop)) {
        //     $this->toastError(__("messages.not_auth_for_operation"));
        //     $this->dispatch("closeModal");
        // }

        // TODO: must handle when workshops has offerings
        $this->workshop->delete();
        $this->dispatch("workshop-deleted");
        $this->toastSuccess(__("messages.deleted_successfully"));
        $this->closeModal();
    }

    public function render()
    {
        return view("livewire.workshops.delete-workshop-warning");
    }
}

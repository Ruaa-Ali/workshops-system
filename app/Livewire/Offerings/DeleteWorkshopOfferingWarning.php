<?php

namespace App\Livewire\Offerings;

use App\Models\WorkshopOffering;
use App\Traits\ToastNotifications;
use LivewireUI\Modal\ModalComponent;
use Livewire\Component;

class DeleteWorkshopOfferingWarning extends ModalComponent
{
    use ToastNotifications;

    public string $id;
    public WorkshopOffering $offering;

    public function mount()
    {
        $this->offering = WorkshopOffering::find($this->id);
    }

    public function delete()
    {
        // TODO: create a policy first
        // if (Gate::denies("delete", $this->workshop)) {
        //     $this->toastError(__("messages.not_auth_for_operation"));
        //     $this->dispatch("closeModal");
        // }

        // TODO: must handle when offerings has regs
        $this->offering->delete();
        $this->dispatch("offering-deleted");
        $this->toastSuccess(__("messages.deleted_successfully"));
        $this->closeModal();
    }

    public function render()
    {
        return view("livewire.offerings.delete-workshop-offering-warning");
    }
}

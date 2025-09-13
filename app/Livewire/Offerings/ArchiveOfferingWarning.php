<?php

namespace App\Livewire\Offerings;

use App\Enums\PermissionsTypes;
use App\Models\WorkshopOffering;
use App\Traits\ToastNotifications;
use LivewireUI\Modal\ModalComponent;

class ArchiveOfferingWarning extends ModalComponent
{
    use ToastNotifications;

    public WorkshopOffering $offering;
    public $title;
    public bool $leavePage;

    public function mount(
        WorkshopOffering $offering,
        bool $leavePage = false,
        string $title,
    ) {
        $this->title = $title;
        $this->offering = $offering;
        $this->leavePage = $leavePage ?? false;
    }

    public function archive()
    {
        try {
            $this->authorize(PermissionsTypes::MANAGE_OFFERINGS);
            $this->offering->delete();
            $this->dispatch("offering-deleted");
            $this->toastSuccess(__("messages.archived_successfully"));
            $this->closeModal();
            if ($this->leavePage) {
                $this->redirect(route("offerings.index"));
            }
        } catch (QueryException $e) {
            $this->toastError($e->getMessage());
            $this->closeModal();
        }
    }

    public function render()
    {
        return view("livewire.offerings.archive-offering-warning");
    }
}

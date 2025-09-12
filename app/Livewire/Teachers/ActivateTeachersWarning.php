<?php

namespace App\Livewire\Teachers;

use App\Models\User;
use App\Traits\ToastNotifications;
use Exception;
use LivewireUI\Modal\ModalComponent;

class ActivateTeachersWarning extends ModalComponent
{
    use ToastNotifications;

    public User $teacher;

    public function mount($id)
    {
        $this->teacher = User::onlyTrashed()->find($id);
    }

    public function activate()
    {
        try {
            $this->teacher->restore();
            $this->dispatch("teachers-updated");
            $this->toastSuccess(__("messages.user_restored_successfully"));
            $this->closeModal();
        } catch (Exception $e) {
            $this->toastError($e->getMessage());
            $this->closeModal();
        }
    }

    public function render()
    {
        return view("livewire.teachers.activate-teachers-warning");
    }
}

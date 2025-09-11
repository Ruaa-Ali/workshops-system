<?php

namespace App\Livewire\Teachers;

use App\Models\User;
use App\Traits\ToastNotifications;
use Exception;
use LivewireUI\Modal\ModalComponent;

class SuspendTeachersWarning extends ModalComponent
{
    use ToastNotifications;

    public User $teacher;

    public function mount(User $teacher)
    {
        $this->teacher = $teacher;
    }

    public function suspend()
    {
        try {
            //TODO:  MUST INVALIDATE ALL USERS CREDENTIALS
            $this->teacher->delete();
            $this->dispatch("teachers-updated");
            $this->toastSuccess(__("messages.suspended_successfully"));
            $this->closeModal();
        } catch (Exception $e) {
            $this->toastError($e->getMessage());
            $this->closeModal();
        }
    }

    public function render()
    {
        return view("livewire.teachers.suspend-teachers-warning");
    }
}

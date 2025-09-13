<?php

namespace App\Livewire\Users;

use App\Enums\PermissionsTypes;
use App\Models\User;
use App\Traits\ToastNotifications;
use Exception;
use LivewireUI\Modal\ModalComponent;

class SuspendUserWarning extends ModalComponent
{
    use ToastNotifications;

    public User $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function suspend()
    {
        try {
            $this->authorize(PermissionsTypes::MANAGE_USERS);
            //TODO:  MUST INVALIDATE ALL USERS CREDENTIALS
            $this->user->delete();
            $this->dispatch("users-updated");
            $this->toastSuccess(__("messages.suspended_successfully"));
            $this->closeModal();
        } catch (Exception $e) {
            $this->toastError($e->getMessage());
            $this->closeModal();
        }
    }

    public function render()
    {
        return view("livewire.users.suspend-user-warning");
    }
}

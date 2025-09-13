<?php

namespace App\Livewire\Users;

use App\Enums\PermissionsTypes;
use App\Models\User;
use App\Traits\ToastNotifications;
use Exception;
use LivewireUI\Modal\ModalComponent;

class ActivateUserWarning extends ModalComponent
{
    use ToastNotifications;

    public User $user;

    public function mount($id)
    {
        $this->authorize(PermissionsTypes::MANAGE_USERS);
        $this->user = User::onlyTrashed()->find($id);
    }

    public function activate()
    {
        try {
            $this->user->restore();
            $this->dispatch("users-updated");
            $this->toastSuccess(__("messages.user_restored_successfully"));
            $this->closeModal();
        } catch (Exception $e) {
            $this->toastError($e->getMessage());
            $this->closeModal();
        }
    }

    public function render()
    {
        return view("livewire.users.activate-user-warning");
    }
}

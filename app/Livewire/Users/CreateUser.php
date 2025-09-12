<?php

namespace App\Livewire\Users;

use App\Enums\LocalRole;
use App\Livewire\Forms\UserForm;
use App\Models\User;
use App\Traits\ToastNotifications;
use Exception;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Hash;

#[Layout("layouts.app")]
class CreateUser extends Component
{
    use ToastNotifications;

    public User $teacher;
    public UserForm $form;

    public $role;

    public function mount()
    {
        $this->role = request()->query("role");
        if (
            !in_array($this->role, [
                LocalRole::ADMIN->value,
                LocalRole::TEACHER->value,
                LocalRole::STUDENT->value,
            ])
        ) {
            abort(404);
        }
    }

    public function save()
    {
        try {
            $this->form->validate();

            $user = User::create([
                "name" => $this->form->name,
                "email" => $this->form->email,
                "password" => Hash::make($this->form->password),
            ]);

            $user->assignRole($this->role);

            $this->form->reset(["name", "email", "password"]);

            $this->toastSuccess(__("messages.user_created"));
        } catch (Exception $e) {
            $this->toastError($e->getMessage());
        }
    }

    public function render()
    {
        return view("livewire.users.create-user");
    }
}

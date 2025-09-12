<?php

namespace App\Livewire\Users;

use App\Enums\LocalRole;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Livewire\Attributes\On;

#[Layout("layouts.app")]
class IndexUsers extends Component
{
    use WithPagination;

    public $currentID;

    public $role;

    public function mount()
    {
        $this->currentID = auth()->id();
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

    public function fetchUsers()
    {
        return User::role($this->role)
            ->withTrashed()
            ->orderByRaw("deleted_at IS NOT NULL, deleted_at DESC, id")
            ->paginate(10);
    }

    #[On("users-updated")]
    public function render()
    {
        $users = $this->fetchUsers();
        $this->resetPage();
        return view("livewire.users.index-users", compact("users"));
    }
}

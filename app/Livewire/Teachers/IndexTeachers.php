<?php

namespace App\Livewire\Teachers;

use App\Enums\LocalRole;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Livewire\Attributes\On;

#[Layout("layouts.app")]
class IndexTeachers extends Component
{
    use WithPagination;

    public function fetchTeachers()
    {
        return User::role(LocalRole::TEACHER)
            ->withTrashed()
            ->orderByRaw("deleted_at IS NOT NULL, deleted_at DESC")
            ->paginate(10);
    }

    #[On("teachers-updated")]
    public function render()
    {
        $teachers = $this->fetchTeachers();
        $this->resetPage();
        return view("livewire.teachers.index-teachers", compact("teachers"));
    }
}

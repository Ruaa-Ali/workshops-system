<?php

namespace App\Livewire\Offerings;

use App\Enums\LocalRole;
use App\Models\Enrollment;
use App\Traits\ToastNotifications;
use Illuminate\Support\Facades\Auth;
use LivewireUI\Modal\ModalComponent;

class EnrollInOfferingsForStudents extends ModalComponent
{
    use ToastNotifications;

    public $id;
    public $title;
    public $date;

    public function mount($id, $title, $date)
    {
        $this->id = $id;
        $this->title = $title;
        $this->date = $date;
    }

    public function enroll()
    {
        // check if student
        if (!Auth::user()->hasRole(LocalRole::STUDENT)) {
            $this->toastError(__("messages.cant_perform_this_action"));
            $this->closeModal();
            return;
        }

        $enrollment = Enrollment::firstOrCreate([
            "workshop_offering_id" => $this->id,
            "student_id" => auth()->id(),
        ]);

        if ($enrollment->wasRecentlyCreated) {
            $this->toastSuccess(__("messages.enrolled_successfully"));
        } else {
            $this->toastError(__("messages.already_enrolled"));
        }

        $this->dispatch("user-classes-updated");
        $this->closeModal();
    }

    public function render()
    {
        return view("livewire.offerings.enroll-in-offerings-for-students");
    }
}

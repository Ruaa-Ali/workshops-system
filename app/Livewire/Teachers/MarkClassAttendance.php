<?php

namespace App\Livewire\Teachers;

use App\Models\OfferingSession;
use Livewire\Component;
use App\Enums\LocalRole;
use App\Enums\PermissionsTypes;
use App\Models\WorkshopOffering;
use App\Models\Enrollment;
use App\Models\Attendance;
use App\Traits\ToastNotifications;
use Livewire\Attributes\Layout;

#[Layout("layouts.app")]
class MarkClassAttendance extends Component
{
    use ToastNotifications;

    public $students;
    public $session = [];

    public function mount($id)
    {
        // first check if today is in the sessions

        $this->session = OfferingSession::with("attendances")
            ->where("workshop_offering_id", "=", $id)
            ->whereDate("session_date", today())
            ->get();

        $this->authorize(PermissionsTypes::MANAGE_OWN_OFFERINGS);
        $this->students = Enrollment::with("student")
            ->where("workshop_offering_id", "=", $id)
            ->get();
        // $this->students = WorkshopOffering::with("students")->find(
        //     $id,
        // )->students;
    }

    public function present($id, $enrollmentID)
    {
        Attendance::create([
            "status" => "present",
            "student_id" => $id,
            "session_id" => $this->session[0]->id,
            "enrollment_id" => $enrollmentID,
        ]);
    }

    public function absent($id, $enrollmentID)
    {
        Attendance::create([
            "status" => "apsent",
            "student_id" => $id,
            "session_id" => $this->session[0]->id,
            "enrollment_id" => $enrollmentID,
        ]);
    }

    public function undo($id)
    {
        Attendance::where("student_id", $id)
            ->where("session_id", $this->session[0]->id)
            ->delete();
    }

    public function endSession()
    {
        $attendance = Attendance::where(
            "session_id",
            $this->session[0]->id,
        )->get();
        if (count($attendance) != count($this->students)) {
            $this->toastError(__("messages.check_students"));
            return;
        }

        // $this->toastSuccess(count($attendance));
        $this->session[0]->status = "completed";
        $this->session[0]->save();

        $this->dispatch('$refresh'); // Dispatching the $refresh event
    }

    public function skipSession()
    {
        Attendance::where("session_id", $this->session[0]->id)->delete();

        $this->session[0]->status = "off";
        $this->session[0]->save();

        $this->dispatch('$refresh'); // Dispatching the $refresh event
    }

    public function render()
    {
        return view("livewire.teachers.mark-class-attendance");
    }
}

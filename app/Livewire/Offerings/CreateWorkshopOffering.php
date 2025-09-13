<?php

namespace App\Livewire\Offerings;

use App\Enums\LocalRole;
use App\Enums\PermissionsTypes;
use App\Livewire\Forms\WorkshopOfferingForm;
use App\Models\User;
use App\Models\Workshop;
use App\Models\WorkshopOffering;
use App\Traits\ToastNotifications;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout("layouts.app")]
class CreateWorkshopOffering extends Component
{
    use ToastNotifications;

    public WorkshopOfferingForm $form;
    public ?Workshop $workshop;

    public $workshops = [];
    public $teachers = [];

    public function mount()
    {
        $this->authorize(PermissionsTypes::MANAGE_OFFERINGS);
        $this->workshops = Workshop::select(
            "id",
            "title_ar",
            "title_en",
        )->get();

        // $this->workshop = $this->workshops[0];
        $this->workshop = Workshop::find($this->workshops[0]->id);
        $this->form->workshopID = $this->workshop->id;
        $this->form->price = $this->workshop->initial_price;

        // only call users that are teachers
        $this->teachers = User::role(LocalRole::TEACHER)
            ->select("id", "name")
            ->get();
        $this->form->teacherID = $this->teachers[0]->id;
    }

    public function updatedFormWorkshopID($value)
    {
        $this->workshop = Workshop::find($value);
        $this->form->price = $this->workshop->initial_price;
    }

    public function save()
    {
        try {
            $this->form->validate();

            //
            $offering = WorkshopOffering::create([
                "start_date" => $this->form->startDate,
                "end_date" => $this->form->endDate,
                "hours_per_day" => $this->form->hoursPerDay,
                "max_capacity" => $this->form->maxCapacity,
                "price" => $this->form->price,
                "workshop_id" => $this->form->workshopID,
                "teacher_id" => $this->form->teacherID,
            ]);

            $this->form->reset([
                "startDate",
                "endDate",
                "hoursPerDay",
                "maxCapacity",
                "price",
                // "workshopID",
                // "teacherID",
            ]);

            $this->toastSuccess(
                __("messages.offering_created"),
                options: [
                    "showCloseBtn" => true,
                    "customBtnText" => __("messages.show"),
                    // "customBtnLink" => route("workshops.update", $offering->id),
                ],
            );
        } catch (Exception $e) {
            $this->toastError($e->getMessage());
        }
    }

    public function render()
    {
        return view("livewire.offerings.create-workshop-offering");
    }
}

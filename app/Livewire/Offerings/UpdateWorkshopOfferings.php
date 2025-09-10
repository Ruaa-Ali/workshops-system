<?php

namespace App\Livewire\Offerings;

use App\Enums\LocalRole;
use App\Livewire\Forms\WorkshopOfferingForm;
use App\Models\User;
use App\Models\Workshop;
use App\Models\WorkshopOffering;
use App\Traits\ToastNotifications;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout("layouts.app")]
class UpdateWorkshopOfferings extends Component
{
    use ToastNotifications;
    public WorkshopOfferingForm $form;
    public WorkshopOffering $offering;
    public Workshop $workshop;
    public $workshops = [];
    public $teachers = [];

    public function mount(WorkshopOffering $offering)
    {
        $this->form->setOffering($offering);
        $this->offering = $offering;

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

    public function update()
    {
        try {
            $this->form->validate();

            $this->offering->start_date = $this->form->startDate;
            $this->offering->end_date = $this->form->endDate;
            $this->offering->hours_per_day = $this->form->hoursPerDay;
            $this->offering->max_capacity = $this->form->maxCapacity;
            $this->offering->price = $this->form->price;
            $this->offering->workshop_id = $this->form->workshopID;
            $this->offering->teacher_id = $this->form->teacherID;

            $this->offering->save();

            // Optional: Fire event
            // event(new WorkshopCreated($workshop));

            $this->toastSuccess(__("messages.offering_updated"));
        } catch (Exception $e) {
            $this->toastError($e->getMessage());
        }
    }

    public function render()
    {
        return view("livewire.offerings.update-workshop-offerings");
    }
}

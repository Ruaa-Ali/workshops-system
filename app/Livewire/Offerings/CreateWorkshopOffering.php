<?php

namespace App\Livewire\Offerings;

use App\Enums\LocalRole;
use App\Enums\PermissionsTypes;
use App\Livewire\Forms\WorkshopOfferingForm;
use App\Models\User;
use App\Models\OfferingSession;
use App\Models\Workshop;
use App\Models\WorkshopOffering;
use App\Traits\ToastNotifications;
use App\Traits\CalculateOfferingDates;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;

#[Layout("layouts.app")]
class CreateWorkshopOffering extends Component
{
    use ToastNotifications, CalculateOfferingDates;

    public WorkshopOfferingForm $form;
    public ?Workshop $workshop;
    public $estimatedEndDate;

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
        // dd($this->form->offDays);
        // $q = implode(",", $this->form->offDays);
        // dd($q);
        $this->form->validate();
        try {
            DB::beginTransaction();
            // 1. validate input

            // 2. create offering
            $q = implode(",", $this->form->offDays);
            $offering = WorkshopOffering::create([
                "start_date" => $this->form->startDate,
                "end_date" => $this->form->endDate,
                "hours_per_day" => $this->form->hoursPerDay,
                "max_capacity" => $this->form->maxCapacity,
                "price" => $this->form->price,
                "workshop_id" => $this->form->workshopID,
                "teacher_id" => $this->form->teacherID,
                "off_days" => implode(",", $this->form->offDays),
            ]);

            // 3. create offering sessions
            $businessDates = $this->getBusinessDatesByEndDate(
                Carbon::parse($this->form->startDate),
                Carbon::parse($this->form->endDate),
                $this->form->offDays,
            );
            // $businessDates = $this->getBusinessDatesByDuration(
            //     Carbon::parse($this->form->startDate),
            //     $this->workshop->duration_hours,
            //     $this->form->hoursPerDay,
            //     $this->form->offDays,
            // );

            foreach ($businessDates as $date) {
                OfferingSession::create([
                    "session_date" => $date,
                    "workshop_offering_id" => $offering->id,
                ]);
            }

            DB::commit();

            // 4. reset form
            $this->form->reset([
                "startDate",
                "endDate",
                "hoursPerDay",
                "maxCapacity",
                "price",
                "offDays",
                // "workshopID",
                // "teacherID",
            ]);

            // 5. show feedback
            $this->toastSuccess(
                __("messages.offering_created"),
                options: [
                    "showCloseBtn" => true,
                    "customBtnText" => __("messages.show"),
                    "customBtnLink" => route("offerings.show", $offering->id),
                ],
            );
        } catch (\Exception $e) {
            DB::rollBack();
            $this->toastError($e->getMessage());
        }
    }

    public function render()
    {
        return view("livewire.offerings.create-workshop-offering");
    }

    public function updatedFormStartDate($value)
    {
        $this->calculateEstimatedDate(
            $this->form->startDate,
            $this->workshop->duration_hours,
            $this->form->hoursPerDay,
            $this->form->offDays,
        );
    }

    public function updatedFormHoursPerDay($value)
    {
        $this->calculateEstimatedDate(
            $this->form->startDate,
            $this->workshop->duration_hours,
            $this->form->hoursPerDay,
            $this->form->offDays,
        );
    }

    public function calculateEstimatedDate($start, $total, $perDay, $offDays)
    {
        if ($perDay == "") {
            $perDay = 1;
        }
        $endDate = $this->calculateEndDate($start, $total, $perDay, $offDays);
        $this->estimatedEndDate = date("Y-m-d", strtotime($endDate));
        $this->form->endDate = $this->estimatedEndDate;
    }

    public function updated($propertyName, $value)
    {
        if (str_starts_with($propertyName, "form.offDays")) {
            $this->calculateEstimatedDate(
                $this->form->startDate,
                $this->workshop->duration_hours,
                $this->form->hoursPerDay,
                $this->form->offDays,
            );
        }
    }
}

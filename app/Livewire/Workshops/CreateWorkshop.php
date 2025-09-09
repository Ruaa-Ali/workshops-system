<?php

namespace App\Livewire\Workshops;

use App\Livewire\Forms\WorkshopForm;
use App\Models\Workshop;
use App\Traits\ToastNotifications;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

#[Layout("layouts.app")]
class CreateWorkshop extends Component
{
    use WithFileUploads, ToastNotifications;

    public WorkshopForm $form;

    public function save()
    {
        try {
            $this->form->validate();

            $fileName =
                Str::uuid()->toString() .
                "." .
                $this->form->image->getClientOriginalExtension();

            $this->form->image->storePubliclyAs(
                "images/workshops",
                $fileName,
                "public",
            );

            $this->form->image->delete();

            $workshop = Workshop::create([
                "title_en" => $this->form->titleEn,
                "title_ar" => $this->form->titleAr,
                "description_en" => $this->form->descriptionEn,
                "description_ar" => $this->form->descriptionAr,
                "duration_hours" => $this->form->durationHours,
                "initial_price" => $this->form->initialPrice,
                "image" => "images/workshops/$fileName",
                "created_by" => auth()->id(), // Current user ID
            ]);
            // Optional: Fire event
            // event(new WorkshopCreated($workshop));

            $this->form->reset([
                "titleEn",
                "titleAr",
                "descriptionEn",
                "descriptionAr",
                "durationHours",
                "initialPrice",
                "image",
            ]);

            $this->toastSuccess(
                __("messages.workshop_created"),
                options: [
                    "showCloseBtn" => true,
                    "customBtnText" => __("messages.show"),
                    "customBtnLink" => route("workshops.update", $workshop->id),
                ],
            );
        } catch (Exception $e) {
            $this->toastError($e->getMessage());
        }
    }

    public function render()
    {
        return view("livewire.workshops.create-workshop");
    }
}

<?php

namespace App\Livewire\Workshops;

use App\Enums\PermissionsTypes;
use App\Livewire\Forms\WorkshopForm;
use App\Models\Workshop;
use App\Traits\ToastNotifications;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

#[Layout("layouts.app")]
class UpdateWorkshop extends Component
{
    use WithFileUploads, ToastNotifications;

    public WorkshopForm $form;
    public Workshop $workshop;

    public function update()
    {
        try {
            $this->authorize(PermissionsTypes::MANAGE_WORKSHOPS);
            $this->form->validate();

            if ($this->form->image) {
                $fileName =
                    Str::uuid()->toString() .
                    "." .
                    $this->form->image->getClientOriginalExtension();

                $this->form->image->storePubliclyAs(
                    "images/workshops",
                    $fileName,
                    "public",
                );

                $this->workshop->image = "images/workshops/$fileName";
                $this->form->currentImage = "images/workshops/$fileName";
                // when removing the image using this line the temp url is deleted which throws an error

                // you have to figure out how to use the newly uploaded image and then delete it this one
                // $this->form->image->delete();
            }

            $this->workshop->title_en = $this->form->titleEn;
            $this->workshop->title_ar = $this->form->titleAr;
            $this->workshop->description_en = $this->form->descriptionEn;
            $this->workshop->description_ar = $this->form->descriptionAr;
            $this->workshop->duration_hours = $this->form->durationHours;
            $this->workshop->initial_price = $this->form->initialPrice;

            $this->workshop->save();

            // Optional: Fire event
            // event(new WorkshopCreated($workshop));

            $this->toastSuccess(__("messages.workshop_updated"));
        } catch (Exception $e) {
            $this->toastError($e->getMessage());
        }
    }

    public function mount(Workshop $workshop)
    {
        $this->form->setWorkshop($workshop);
        $this->workshop = $workshop;
    }

    public function render()
    {
        return view("livewire.workshops.update-workshop");
    }
}

<?php

namespace App\Livewire\Workshops;

use App\Imports\WorkshopsImport;
use App\Livewire\Forms\ExcelImportForm;
use App\Traits\ToastNotifications;
use LivewireUI\Modal\ModalComponent;
use Excel;
use Exception;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class UploadWorkshopsFromExcel extends ModalComponent
{
    use ToastNotifications, WithFileUploads;
    public ExcelImportForm $form;

    public function importFromExcel()
    {
        try {
            $this->form->validate();
            $result = Excel::import(new WorkshopsImport(), $this->form->file);

            $this->toastSuccess(__("messages.uploaded"));
            $this->dispatch("workshop-deleted");
            $this->closeModal();
        } catch (Exception $e) {
            $this->toastError($e->getMessage());
            $this->closeModal();
        }
    }

    public function render()
    {
        return view("livewire.workshops.upload-workshops-from-excel");
    }
}

<?php

namespace App\Livewire\Users;

use App\Imports\StudentsImport;
use App\Livewire\Forms\ExcelImportForm;
use App\Traits\ToastNotifications;
use LivewireUI\Modal\ModalComponent;
use Excel;
use Exception;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class UploadStudentsFromExcel extends ModalComponent
{
    use ToastNotifications, WithFileUploads;
    public ExcelImportForm $form;

    public function importFromExcel()
    {
        try {
            $this->form->validate();
            $result = Excel::import(new StudentsImport(), $this->form->file);

            $this->toastSuccess(__("messages.uploaded"));
            $this->dispatch("users-updated");
            $this->closeModal();
        } catch (Exception $e) {
            $this->toastError($e->getMessage());
            $this->closeModal();
        }
    }

    public function render()
    {
        return view("livewire.users.upload-students-from-excel");
    }
}

<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class ExcelImportForm extends Form
{
    #[Validate]
    public $file;

    protected function rules(): array
    {
        return [
            "file" => "required|mimes:xlsx,ods",
        ];
    }

    protected function messages(): array
    {
        return [
            "file.required" => __("messages.required_field"),
            "file.mimes" => __("messages.excel_type"),
        ];
    }
}

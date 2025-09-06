<?php

namespace App\Livewire\Forms;

use App\Models\Workshop;
use Livewire\Attributes\Validate;
use Livewire\Form;

class WorkshopForm extends Form
{
    public ?Workshop $workshop = null;

    #[Validate]
    public $titleEn = "";
    #[Validate]
    public $titleAr = "";
    #[Validate]
    public $descriptionEn = "";
    #[Validate]
    public $descriptionAr = "";
    #[Validate]
    public $durationHours = "";
    #[Validate]
    public $initialPrice = "";
    #[Validate]
    public $image;

    public function setWorkshop(Workshop $workshop): void
    {
        $this->workshop = $workshop;
        $this->titleEn = $workshop->titleEn;
        $this->titleAr = $workshop->titleAr;
        $this->descriptionEn = $workshop->descriptionEn;
        $this->descriptionAr = $workshop->descriptionAr;
        $this->durationHours = $workshop->durationHours;
        $this->initialPrice = $workshop->initialPrice;
        $this->image = $workshop->image;
    }

    protected function rules(): array
    {
        $rules = [
            "titleEn" => "required|string|max:255",
            "titleAr" => "required|string|max:255",
            "descriptionEn" => "required|string",
            "descriptionAr" => "required|string",
            "durationHours" => "required|integer|min:1",
            "initialPrice" => "required|integer|min:0",
            "image" => "image|mimes:jpeg,png,jpg,gif|max:10240", // 10 mb
        ];

        // if this class is accessed via the create component, then make the image required
        if ($this->workshop == null) {
            $rules["image"] .= "|required";
        }

        return $rules;
    }

    protected function messages(): array
    {
        return [
            "titleEn.required" => __("messages.required_field"),
            "titleEn.max" => __("messages.field_max"),

            "titleAr.required" => __("messages.required_field"),
            "titleAr.max" => __("messages.field_max"),

            "descriptionEn.required" => __("messages.required_field"),
            "descriptionAr.required" => __("messages.required_field"),

            "durationHours.required" => __("messages.required_field"),
            "durationHours.min" => __("messages.duration_min"),
            "durationHours.integer" => __("messages.int_type"),

            "initalPrice.required" => __("messages.required_field"),
            "initalPrice.integer" => __("messages.int_type"),
            "initalPrice.min" => __("messages.min_value"),

            "image.required" => __("messages.required_field"),
            "image.image" => __("messages.required_image"),
            "image.max" => __("messages.image_size"),
            "image.mimes" => __("messages.image_type"),
        ];
    }
}

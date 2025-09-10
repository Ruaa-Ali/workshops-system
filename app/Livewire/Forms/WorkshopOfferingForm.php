<?php

namespace App\Livewire\Forms;

use App\Models\WorkshopOffering;
use Livewire\Attributes\Validate;
use Livewire\Form;

class WorkshopOfferingForm extends Form
{
    public ?WorkshopOffering $offering = null;

    #[Validate]
    public $startDate = "";
    #[Validate]
    public $endDate = "";
    #[Validate]
    public $hoursPerDay = "3";
    #[Validate]
    public $maxCapacity = "";
    #[Validate]
    public $price = "";
    #[Validate]
    public $workshopID = "";
    #[Validate]
    public $teacherID = "";

    public function setOffering(WorkshopOffering $offering): void
    {
        $this->startDate = date("Y-m-d", strtotime($offering->start_date));
        $this->endDate = date("Y-m-d", strtotime($offering->end_date));
        $this->hoursPerDay = $offering->hours_per_day;
        $this->maxCapacity = $offering->max_capacity;
        $this->price = $offering->price;
        $this->workshopID = $offering->workshop_id;
        $this->teacherID = $offering->teacher_id;
    }

    protected function rules(): array
    {
        $rules = [
            "startDate" => "required|date|before:endDate",
            "endDate" => "required|date|after:startDate",
            "hoursPerDay" => "required|integer|min:1",
            "maxCapacity" => "required|integer|min:1",
            "price" => "required|integer|min:1",
            "workshopID" => "required|exists:workshops,id",
            "teacherID" => "required|exists:users,id",
        ];

        return $rules;
    }

    protected function messages(): array
    {
        return [
            "startDate.required" => __("messages.required_field"),
            "startDate.date" => __("messages.date_field"),
            "startDate.before" => __("messages.before_end_date"),

            "endDate.required" => __("messages.required_field"),
            "endDate.date" => __("messages.date_field"),
            "endDate.after" => __("messages.after_start_date"),

            "hoursPerDay.required" => __("messages.required_field"),
            "hoursPerDay.integer" => __("messages.int_type"),
            "hoursPerDay.min" => __("messages.duration_min"),

            "maxCapacity.required" => __("messages.required_field"),
            "maxCapacity.integer" => __("messages.int_type"),
            "maxCapacity.min" => __("messages.min_value"),

            "price.required" => __("messages.required_field"),
            "price.integer" => __("messages.int_type"),
            "price.min" => __("messages.min_value"),

            "workshopID.required" => __("messages.required_field"),
            "workshopID.exists" => __("messages.exists"),
            "teacherID.required" => __("messages.required_field"),
            "teacherID.exists" => __("messages.exists"),
        ];
    }
}

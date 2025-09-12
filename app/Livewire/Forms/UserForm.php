<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class UserForm extends Form
{
    public ?User $user = null;

    #[Validate]
    public $name = "";
    #[Validate]
    public $email = "";
    #[Validate]
    public $password = "";

    public function setUser(User $user): void
    {
        $this->name = $user->name;
        $this->email = $user->email;
    }

    protected function rules(): array
    {
        $rules = [
            "name" => "required",
            "email" => [
                "required",
                "string",
                "lowercase",
                "email",
                Rule::unique(User::class),
            ],
            "password" => ["required", Password::defaults()],
        ];

        return $rules;
    }

    protected function messages(): array
    {
        return [
            "name.required" => __("messages.required_field"),

            "email.required" => __("messages.required_field"),
            "email.string" => __("messages.string_field"),
            "email.email" => __("messages.email_field"),
            "email.lowercase" => __("messages.email_lowercase_field"),
            "email.unique" => __("messages.email_unique_field"),

            "password.required" => __("messages.required_field"),
        ];
    }
}

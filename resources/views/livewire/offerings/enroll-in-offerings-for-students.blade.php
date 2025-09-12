<div class="my-3 {{ app()->getLocale() === "ar" ? 'text-right' : 'text-left' }}">

    <p class="text-lg font-bold mx-5 mb-3">{{ __('messages.confirm_enroll', ['item' => $title ]) }}</p>
    <hr>
    <p class="mx-5 mt-3">{{ __('messages.enroll_msg', ['item' => $title, 'date' => $date]) }}</p>


    <div class="mt-3 mx-5 gap-3 flex justify-end">
        <x-primary-button class="bg-gren-800 dark:bg-green-500" wire:click="enroll">
            {{ __('messages.enroll') }}
        </x-primary-button>

        <x-secondary-button wire:click="$dispatch('closeModal')">
            {{ __('messages.cancel') }}
        </x-secondary-button>
    </div>
</div>

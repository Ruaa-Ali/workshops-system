<div class="my-3 {{ app()->getLocale() === "ar" ? 'text-right' : 'text-left' }}">

    <p class="text-lg font-bold mx-5 mb-3">{{ __('messages.suspended_warning_heading', ['item' => $user->name ]) }}</p>
    <hr>
    <p class="mx-5 mt-3">{{ __('messages.suspended_warning') }}</p>


    <div class="mt-3 mx-5 gap-3 flex justify-end">
        <x-primary-button class="bg-red-800 dark:bg-red-500" wire:click="suspend">
            {{ __('messages.suspend') }}
        </x-primary-button>

        <x-secondary-button wire:click="$dispatch('closeModal')">
            {{ __('messages.cancel') }}
        </x-secondary-button>
    </div>
</div>

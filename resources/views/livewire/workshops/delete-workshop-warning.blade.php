<div class="my-3">

    <p class="text-lg font-bold mx-5 mb-3">{{ __('messages.deleting_warning_heading', ['item' => $title ]) }}</p>
    <hr>
    <p class="mx-5 mt-3">{{ __('messages.delete_warning') }}</p>


    <div class="mt-3 mx-5 gap-3 flex justify-end">
        <x-primary-button class="bg-red-800 dark:bg-red-500" wire:click="delete">
            {{ __('messages.delete') }}
        </x-primary-button>

        <x-secondary-button wire:click="$dispatch('closeModal')">
            {{ __('messages.cancel') }}
        </x-secondary-button>
    </div>
</div>

<div class="my-3">

    <p class="text-lg font-bold mx-5 mb-3">
        {{ __('messages.archiving_warning_heading', ['item' => $title ]) }}
    </p>
    <hr>
    <p class="mx-5 mt-3">{{ __('messages.archive_workshop_msg') }}</p>


    <div class="mt-3 mx-5 gap-3 flex justify-end">
        <x-primary-button class="bg-red-800 dark:bg-red-500" wire:click="archive">
            {{ __('messages.archive') }}
        </x-primary-button>

        <x-secondary-button wire:click="$dispatch('closeModal')">
            {{ __('messages.cancel') }}
        </x-secondary-button>
    </div>
</div>

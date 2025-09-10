<div class="my-3">

    <p class="text-lg font-bold mx-5 mb-3">
        {{ __('messages.restore_warning_heading', ['item' => $workshop->getTitleAttribute() ]) }}
    </p>
    <hr>
    <p class="mx-5 mt-3">{{ __('messages.restore_workshop_msg') }}</p>


    <div class="mt-3 mx-5 gap-3 flex justify-end">
        <x-primary-button class="bg-green-800 dark:bg-green-500" wire:click="restore">
            {{ __('messages.restore') }}
        </x-primary-button>

        <x-secondary-button wire:click="$dispatch('closeModal')">
            {{ __('messages.cancel') }}
        </x-secondary-button>
    </div>
</div>

<div class="my-3 {{ app()->getLocale() === "ar" ? 'text-right' : 'text-left' }}">

    <p class="text-lg font-bold mx-5 mb-3">{{ __('messages.import_from_excel', ) }}</p>
    <hr>
    <form method="post" wire:submit="importFromExcel" enctype="multipart/form-data" class="flex gap-3 flex-col mx-5 mt-3">
      @csrf
      <x-input-label for="file" :value="__('messages.excelFile')" />
      <x-text-input id="file" class="block mt-1 w-full"
      type="file"
      wire:model="form.file"
      />
      <x-input-error :messages="$errors->get('form.file')" class="mt-2" />

      <div class="flex items-center justify-end mt-4">
        <x-primary-button >
          {{ __('messages.upload') }}
        </x-primary-button>
      </div>
    </form>
</div>

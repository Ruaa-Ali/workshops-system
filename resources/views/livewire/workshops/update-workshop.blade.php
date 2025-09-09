    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">

              <form method="post" wire:submit="update" enctype="multipart/form-data" class="flex gap-3 flex-col">
                @csrf

                <div class="flex flex-col md:flex-row justify-center gap-2 ">
                    <div class="flex-1">
                        <x-input-label for="titleAr" :value="__('messages.title_ar')" />
                        <x-text-input id="titleAr" class="block mt-1 w-full"
                        type="text"
                        wire:model="form.titleAr"
                        />
                        <x-input-error :messages="$errors->get('form.titleAr')" class="mt-2" />
                    </div>

                    <div class="flex-1">
                        <x-input-label for="titleEn" :value="__('messages.title_en')" />
                        <x-text-input id="titleEn" class="block mt-1 w-full"
                        type="text"
                        wire:model="form.titleEn"
                        />
                        <x-input-error :messages="$errors->get('form.titleEn')" class="mt-2" />
                    </div>
                </div>




                <x-input-label for="descriptionAr" :value="__('messages.description_ar')" />
                <x-textarea-input id="descriptionAr" class="block mt-1 w-full"
                type="text"
                wire:model="form.descriptionAr"
                > </x-textarea-input>
                <x-input-error :messages="$errors->get('form.descriptionAr')" class="mt-2" />



                <x-input-label for="descriptionEn" :value="__('messages.description_en')" />
                <x-textarea-input id="descriptionEn" class="block mt-1 w-full"
                type="text"
                wire:model="form.descriptionEn"
                > </x-textarea-input>
                <x-input-error :messages="$errors->get('form.descriptionEn')" class="mt-2" />


                <div class="flex flex-col md:flex-row justify-center gap-2">
                    <div class="flex-1">
                        <x-input-label for="initialPrice" :value="__('messages.initial_price')" />
                        <x-text-input id="initialPrice" class="block mt-1 w-full"
                        type="number"
                        wire:model="form.initialPrice"
                        />
                        <x-input-error :messages="$errors->get('form.initialPrice')" class="mt-2" />
                    </div>


                    <div class="flex-1">
                        <x-input-label for="durationHours" :value="__('messages.duration_hours')" />
                        <x-text-input id="durationHours" class="block mt-1 w-full"
                        type="number"
                        wire:model="form.durationHours"
                        />

                        <x-input-error :messages="$errors->get('form.durationHours')" class="mt-2" />
                    </div>

                </div>

                <x-input-label for="image" :value="__('messages.display_image')" />
                {{-- <x-input-file class="mt-4" name="image" x-data="fileInput" @change="updateFileName" /> --}}
                <x-text-input id="image" class="block mt-1 w-full"
                type="file"
                wire:model="form.image"
                />
                <x-input-error :messages="$errors->get('form.image')" class="mt-2" />

                @if ($form->image)
                    <img width="400px" src="{{ $form->image->temporaryUrl() }}">
                @elseif($form->currentImage != null)
                    <img width="400px" src="{{ asset(url( Storage::url($form->currentImage))) }}">
                @endif

                <div class=" mt-4">
                  <x-primary-button class='justify-center w-full' >
                    {{ __('messages.edit') }}
                  </x-primary-button>
                </div>
            </form>

          </div>
        </div>
      </div>
    </div>

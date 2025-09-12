{{-- <x-app-layout> --}}
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">


              <p class="text-2xl mb-5">{{ __('messages.creating') }} <span class="font-extrabold">{{ __("messages.$role") }}</span></p>
              <form method="post" wire:submit="save" class="flex gap-3 flex-col">
                @csrf

                    <x-input-label for="name" :value="__('messages.name')" />
                    <x-text-input id="name" class="block mt-1 w-full"
                    type="text"
                    wire:model="form.name"
                    />
                    <x-input-error :messages="$errors->get('form.name')" class="mt-2" />


                    <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
                    <x-input-label for="email" :value="__('messages.email')" />
                    <x-text-input id="email" class="block mt-1 w-full"
                    type="email"
                    wire:model="form.email"
                    />
                    <x-input-error :messages="$errors->get('form.email')" class="mt-2" />


                    <x-input-label for="password" :value="__('messages.password')" />
                    <x-text-input id="password" class="block mt-1 w-full"
                    type="password"
                    wire:model="form.password"
                    />
                    <x-input-error :messages="$errors->get('form.password')" class="mt-2" />


                {{-- <button type="submit">{{ __('messages.add') }}</button> --}}
                <div class=" mt-4">
                  <x-primary-button class='justify-center w-full' >
                    {{ __('messages.create') }}
                  </x-primary-button>
                </div>
            </form>

          </div>
        </div>
      </div>
    </div>
{{-- </x-app-layout> --}}

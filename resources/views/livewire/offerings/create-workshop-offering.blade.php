{{-- <x-app-layout> --}}
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

          <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-5">
            <div class="p-6 text-gray-900 dark:text-gray-100">

                <p class="text-lg font-bold mb-3">{{ __('messages.workshop_details') }}</p>

                @if($workshop)
                    <table class="styled-table">
                        <tbody>
                            <tr>
                                <th>{{ __('messages.title') }}</th>
                                <td>{{ $workshop->getTitleAttribute() }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('messages.desc') }}</th>
                                <td>{{ $workshop->getDescriptionAttribute() }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('messages.duration_hours') }}</th>
                                <td>{{ $workshop->duration_hours }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('messages.initial_price') }}</th>
                                <td>{{ $workshop->initial_price }}</td>
                            </tr>
                            <tr>
                                <th>{{ __('messages.display_image') }}</th>
                                <td><img src="{{ asset(url(Storage::url($workshop->image))) }}" width="200px" /></td>
                            </tr>

                        </tbody>
                    </table>
                @else
                    <p>{{ __('messages.unable_to_find_workshop') }}</p>
                @endif

            </div>
          </div>



        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">

              <form method="post" wire:submit="save" class="flex gap-3 flex-col">
                @csrf


                <x-input-label for="workshopID" :value="__('messages.workshop')" />
                <x-select-input id="workshopID" class="block mt-1 w-full"
                wire:model.live="form.workshopID"
                >
                    @foreach ($workshops as $w)
                        <option value="{{ $w->id }}">{{ $w->getTitleAttribute() }}</option>
                    @endforeach
                </x-select-input>
                <x-input-error :messages="$errors->get('form.workshopID')" class="mt-2" />



                <x-input-label for="teacherID" :value="__('messages.teacher')" />
                <x-select-input id="teacherID" class="block mt-1 w-full"
                wire:model="form.teacherID"
                >
                    @foreach ($teachers as $t)
                        <option value="{{ $t->id }}">{{ $t->name }}</option>
                    @endforeach
                </x-select-input>
                <x-input-error :messages="$errors->get('form.teacherID')" class="mt-2" />

                <div class="flex flex-col md:flex-row justify-center gap-2 ">
                    <div class="flex-1">
                        <x-input-label for="startDate" :value="__('messages.start_date')" />
                        <x-text-input id="startDate" class="block mt-1 w-full"
                        type="date"
                        wire:model="form.startDate"
                        />
                        <x-input-error :messages="$errors->get('form.startDate')" class="mt-2" />
                    </div>

                    <div class="flex-1">
                        <x-input-label for="endDate" :value="__('messages.end_date')" />
                        <x-text-input id="endDate" class="block mt-1 w-full"
                        type="date"
                        wire:model="form.endDate"
                        />
                        <x-input-error :messages="$errors->get('form.endDate')" class="mt-2" />
                    </div>
                </div>


                <x-input-label for="price" :value="__('messages.price')" />
                <x-text-input id="price" class="block mt-1 w-full"
                type="number"
                min='1'
                wire:model="form.price"
                />
                <x-input-error :messages="$errors->get('form.price')" class="mt-2" />



                <x-input-label for="hoursPerDay" :value="__('messages.hours_per_day')" />
                <x-text-input id="hoursPerDay" class="block mt-1 w-full"
                type="number"
                min='1'
                wire:model="form.hoursPerDay"
                />
                <x-input-error :messages="$errors->get('form.hoursPerDay')" class="mt-2" />



                <x-input-label for="maxCapacity" :value="__('messages.max_capacity')" />
                <x-text-input id="maxCapacity" class="block mt-1 w-full"
                type="number"
                min='1'
                wire:model="form.maxCapacity"
                />
                <x-input-error :messages="$errors->get('form.maxCapacity')" class="mt-2" />


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

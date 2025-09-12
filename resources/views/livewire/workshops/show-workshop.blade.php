<div class="flex flex-col">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg my-5 mx-2">
      <div class="p-6 text-gray-900 dark:text-gray-100">

          <div class="flex items-center justify-between">
              <p class="text-xl font-bold mb-3">{{ __('messages.workshop_details') }}</p>


              <div>
              <x-link-button href="{{ route('workshops.update', $workshop->id) }}">
                  {{ __('messages.edit') }}
              </x-link-button>
              @if(count($workshop->offerings) == 0)
              <x-primary-button
                  class="bg-red-800 dark:bg-red-500"
                  wire:click="
                  $dispatch(
                      'openModal',
                      {
                          component: 'workshops.delete-workshop-warning',
                          arguments: {
                              id: {{ $workshop->id }},
                              leavePage: true,
                          }
                      }
                  )"
              >
                  {{ __('messages.delete') }}
              </x-primary-button>
              {{-- @else
              <x-primary-button
                  class="bg-yellow-800 dark:bg-yellow-500"
                  wire:click="
                  $dispatch(
                      'openModal',
                      {
                          component: 'workshops.archive-workshop-warning',
                          arguments: {
                              workshop: {{ $workshop->id }},
                              leavePage: true,
                          }
                      }
                  )"
              >
                  {{ __('messages.archive') }}
              </x-primary-button> --}}
              @endif
              </div>
          </div>

          @if($workshop)
              <table class="styled-table">
                  <tbody>
                      <tr>
                          <th>{{ __('messages.title') }}</th>
                          <td>{{ $workshop->title_ar }}</td>
                          <td>{{ $workshop->title_en }}</td>
                      </tr>
                      <tr>
                          <th>{{ __('messages.desc') }}</th>
                          <td>{{ $workshop->description_ar }}</td>
                          <td>{{ $workshop->description_en }}</td>
                      </tr>
                      <tr>
                          <th>{{ __('messages.duration_hours') }}</th>
                          <td>{{ $workshop->duration_hours }}</td>
                          <td></td>
                      </tr>
                      <tr>
                          <th>{{ __('messages.initial_price') }}</th>
                          <td>{{ $workshop->initial_price }}</td>
                          <td></td>
                      </tr>
                      <tr>
                          <th>{{ __('messages.display_image') }}</th>
                          <td><img src="{{ asset(url(Storage::url($workshop->image))) }}" width="200px" /></td>
                          <td></td>
                      </tr>
                      <tr>
                          <th>{{ __('messages.created_by') }}</th>
                          <td>{{ $workshop->creator->name }}</td>
                          <td></td>
                      </tr>

                  </tbody>
              </table>
          @else
              <p>{{ __('messages.unable_to_find_workshop') }}</p>
          @endif

      </div>
    </div>

    <div class="overflow-x-auto mx-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg pb-2 p-6">
        <p class="text-xl font-bold">{{ __('messages.workshop_offerings') }} ({{ count($workshop->offerings) }})</p>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>ID</th>
                    {{-- <th>{{ __('messages.title') }}</th> --}}
                    <th>{{ __('messages.start_date') }}</th>
                    <th>{{ __('messages.end_date') }}</th>
                    <th>{{ __('messages.hours_per_day') }}</th>
                    <th>{{ __('messages.price') }}</th>
                    <th>{{ __('messages.max_capacity') }}</th>
                    <th>{{ __('messages.teacher') }}</th>
                    <th>{{ __('messages.created_at') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($workshop->offerings as $o)
                <tr>
                    <td> <a class="underline" href="{{ route('offerings.update', $o->id)}}" >{{ $o->id }}</a> </td>
                    {{-- <td> <a
                        href="{{ route('workshops.update', $o->workshop->id) }}"
                        class="underline">
                            {{ $o->workshop->getTitleAttribute() }}</a> </td> --}}
                    <td> <p>{{ $o->start_date }}</p> </td>
                    <td> <p>{{ $o->end_date }}</p> </td>
                    <td> <p>{{ $o->hours_per_day }}</p> </td>
                    <td> <p>{{ $o->price }}</p> </td>
                    <td> <p>{{ $o->max_capacity }}</p> </td>
                    <td> <p>{{ $o->teacher->name }}</p> </td>
                    <td> <p>{{ $o->created_at }}</p> </td>
                    <td>
                        <div class="flex flex-col gap-2 items-center">
                            <x-link-button href="{{ route('offerings.update', $o->id) }}">
                                {{ __('messages.edit') }}
                            </x-link-button>

                            <x-primary-button
                                class="bg-red-800 dark:bg-red-500"
                                wire:click="
                                $dispatch(
                                    'openModal',
                                    {
                                        component: 'offerings.delete-workshop-offering-warning',
                                        arguments: {
                                            id: {{ $o->id }}
                                        }
                                    }
                                )"
                            >
                                {{ __('messages.delete') }}
                            </x-primary-button>
                        </div>
                    </td>
                </tr>


                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4 mx-2">
        {{-- {{ $workshop->offerings->links() }} --}}
    </div>
</div>

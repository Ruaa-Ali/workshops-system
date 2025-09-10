<div class="flex flex-col">



    <x-link-button href="{{ route('workshops.create') }}" class="self-end mt-5 mx-2">
        {{ __('messages.create_workshop') }}
    </x-link-button>

    <div class="overflow-x-auto mx-2 ">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>{{ __('messages.title') }}</th>
                    <th class="hidden md:table-cell">{{ __('messages.desc') }}</th>
                    <th>{{ __('messages.initial_price') }}</th>
                    <th>{{ __('messages.duration_hours') }}</th>
                    <th  class="hidden md:table-cell">{{ __('messages.display_image') }}</th>
                    {{-- TODO: maybe show how many offerings of that workshop --}}
                    <th>{{ __('messages.created_at') }}</th>
                    <th>{{ __('messages.created_by') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($workshops as $w)
                <tr>
                    <td>
                        <p>{{ $w->title_ar }}</p>
                        <br>
                        <p>{{ $w->title_en }}</p>
                    </td>
                    <td class="hidden md:table-cell ">
                        <p class="text-ellipsis">{{ $w->description_ar }}</p>
                        <br>
                        <p class="text-ellipsis">{{ $w->description_en }}</p>
                    </td>
                    <td>{{ $w->initial_price }}</td>
                    <td>{{ $w->duration_hours }}</td>
                    <td>
                        <img width="100px" src="{{ asset( url(Storage::url( $w->image)) ) }}" alt="">
                    </td>
                    <td>{{ $w->created_at }}</td>
                    {{-- TODO: must be able to open admin's details page --}}
                    <td>{{ $w->creator->name }}</td>
                    <td>
                        <div class="flex flex-col gap-2 items-center">
                            <x-link-button href="{{ route('workshops.update', $w->id) }}">
                                {{ __('messages.edit') }}
                            </x-link-button>

                            <x-primary-button
                                class="bg-red-800 dark:bg-red-500"
                                {{-- wire:confirm="{{ __('Are you sure you want to delete this workshop?') }}" --}}
                                wire:click="
                                $dispatch(
                                    'openModal',
                                    {
                                        component: 'workshops.delete-workshop-warning',
                                        arguments: {
                                            id: {{ $w->id }}
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
        {{ $workshops->links() }}
    </div>
</div>

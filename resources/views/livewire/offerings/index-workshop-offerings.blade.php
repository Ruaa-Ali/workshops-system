<div class="flex flex-col">
    <x-link-button href="{{ route('offerings.create') }}" class="self-end my-5 mx-2">
        {{ __('messages.create_offering') }}
    </x-link-button>

    <div class="overflow-x-auto mx-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-2 pb-2">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>{{ __('messages.title') }}</th>
                    <th>{{ __('messages.start_date') }}</th>
                    <th>{{ __('messages.end_date') }}</th>
                    <th>{{ __('messages.hours_per_day') }}</th>
                    <th>{{ __('messages.price') }}</th>
                    <th>{{ __('messages.max_capacity') }}</th>
                    <th>{{ __('messages.teacher') }}</th>
                    <th>{{ __('messages.status') }}</th>
                    <th>{{ __('messages.created_at') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($offerings as $o)
                <tr>
                    <td> <p>{{ $o->id }}</p> </td>

                    <td>
                    @if($o->workshop != null)
                        <a
                        href="{{ route('workshops.update', $o->workshop->id) }}"
                        class="underline">
                            {{ $o->workshop->getTitleAttribute() }}</a>
                        @else
                        {{ $o->workshop_id }} <span class="text-sm">({{__('messages.archived')}})</span>
                   @endif
                    </td>

                    <td> <p>{{ $o->start_date }}</p> </td>
                    <td> <p>{{ $o->end_date }}</p> </td>
                    <td> <p>{{ $o->hours_per_day }}</p> </td>
                    <td> <p>{{ $o->price }}</p> </td>
                    <td> <p>{{ $o->max_capacity }}</p> </td>
                    <td> <p>{{ $o->teacher->name }}</p> </td>
                    @php
                        $status = count($o->students) >= $o->max_capacity ? 'full' : 'available';

                        $statusConfig = [
                            'full' => ['text' => __('messages.full'), 'class' => 'bg-gray-100 text-gray-800'],
                            'available' => ['text' => __('messages.available'), 'class' => 'bg-green-100 text-blue-800'],
                        ];
                    @endphp

                    <td> <span class="px-3 py-1 text-xs font-bold rounded-full {{ $statusConfig[$status]['class'] }}">
                        {{ $statusConfig[$status]['text'] }}
                    </span> </td>
                    <td> <p>{{ $o->created_at }}</p> </td>
                    <td>
                        <div class="flex flex-col gap-2 items-center">
                            <x-link-button href="{{ route('offerings.show', $o->id) }}">
                                {{ __('messages.show') }}
                            </x-link-button>

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
        {{ $offerings->links() }}
    </div>
</div>

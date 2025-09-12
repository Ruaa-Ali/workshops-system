<div class="flex flex-col">



    {{-- href="{{ route('workshops.create') }}" --}}
    <x-link-button  class="self-end my-5 mx-2">
        {{ __('messages.add_teacher') }}
    </x-link-button>

    <div class="overflow-x-auto mx-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-2 pb-2">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>{{ __('messages.name') }}</th>
                    <th>{{ __('messages.email') }}</th>
                    <th>{{ __('messages.created_at') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($teachers as $t)
                <tr class="{{ $t->deleted_at !=  null ? 'deleted-row' : ''}}">
                    <td>{{ $t->id }}</td>
                    <td>{{ $t->name }}</td>
                    <td>{{ $t->email }}</td>
                    <td>{{ $t->created_at }}</td>
                    <td>
                        <div class="flex flex-col gap-2 items-center">
                            @if($t->deleted_at == null)
                             {{-- href="{{ route('workshops.update', $t->id) }}" --}}
                            <x-link-button>
                                {{ __('messages.edit') }}
                            </x-link-button>

                            <x-primary-button
                                class="bg-yellow-800 dark:bg-yellow-500"
                                wire:click="
                                $dispatch(
                                    'openModal',
                                    {
                                        component: 'teachers.suspend-teachers-warning',
                                        arguments: {
                                            teacher: {{ $t->id }}
                                        }
                                    }
                                )"
                            >
                                {{ __('messages.suspend') }}
                            </x-primary-button>


                            @else
                            <x-secondary-button
                                wire:click="
                                $dispatch(
                                    'openModal',
                                    {
                                        component: 'teachers.activate-teachers-warning',
                                        arguments: {
                                            id: {{ $t->id }}
                                        }
                                    }
                                )"
                            >
                                {{ __('messages.activate') }}
                            </x-secondary-button>

                            @endif
                        </div>
                    </td>
                </tr>


                @endforeach
            </tbody>
        </table>
        <div class="mt-4 mx-2">
            {{ $teachers->links() }}
        </div>
    </div>

</div>

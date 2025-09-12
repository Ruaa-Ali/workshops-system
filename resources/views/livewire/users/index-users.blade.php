<div class="flex flex-col">




    <x-link-button href="{{ route('users.create', 'role=teacher') }}" class="self-end my-5 mx-2">
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
                @foreach ($users as $u)
                <tr class="{{ $u->deleted_at !=  null ? 'deleted-row' : ''}}">
                    <td>{{ $u->id }}</td>
                    <td>{{ $u->name }} {{ $currentID == $u->id ? __('messages.you') : '' }}</td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->created_at }}</td>
                    <td>
                        @if($currentID != $u->id)
                        <div class="flex flex-col gap-2 items-center">
                            @if($u->deleted_at == null)
                             {{-- href="{{ route('workshops.update', $u->id) }}" --}}
                            <x-link-button>
                                {{ __('messages.edit') }}
                            </x-link-button>

                            <x-primary-button
                                class="bg-yellow-800 dark:bg-yellow-500"
                                wire:click="
                                $dispatch(
                                    'openModal',
                                    {
                                        component: 'users.suspend-user-warning',
                                        arguments: {
                                            user: {{ $u->id }}
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
                                        component: 'users.activate-user-warning',
                                        arguments: {
                                            id: {{ $u->id }}
                                        }
                                    }
                                )"
                            >
                                {{ __('messages.activate') }}
                            </x-secondary-button>

                            @endif
                        </div>
                        @endif
                    </td>
                </tr>


                @endforeach
            </tbody>
        </table>
        <div class="mt-4 mx-2">
            {{ $users->links() }}
        </div>
    </div>

</div>

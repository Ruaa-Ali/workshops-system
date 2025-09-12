<div class="flex flex-col">
    <div class="overflow-x-auto mt-5 mx-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-2 pb-2">
        <x-input-label for="search" :value="__('messages.search')" class="mt-3"/>
        <x-text-input id="search" class="block mt-1 w-full"
        type="text"
        min='1'
        wire:model.live="search"
        />
        {{-- .debounce.500ms --}}
        <table class="styled-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>{{ __('messages.enrolled_at') }}</th>
                    <th>{{ __('messages.workshop') }}</th>
                    <th>{{ __('messages.student_name') }}</th>
                </tr>
            </thead>
            <tbody>
                {{-- `workshop_offering_id`,
                    `student_id`, --}}
                @foreach ($entollments as $e)
                <tr>
                    <td>{{ $e->id }}</td>
                    <td>{{ $e->created_at }}</td>
                    {{-- TODO: must go to show page not update --}}
                    <td><a href="{{ route('offerings.update', $e->class) }}" class="underline">{{ $e->class->workshop->title_en }}</a></td>
                    {{-- TODO: must go to student page --}}
                    <td>{{ $e->student->name }}</td>
                </tr>


                @endforeach
            </tbody>
        </table>
        <div class="mt-4 mx-2">
            {{ $entollments->links() }}
        </div>
    </div>

</div>

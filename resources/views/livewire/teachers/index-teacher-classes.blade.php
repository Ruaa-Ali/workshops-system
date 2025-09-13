<div class="flex flex-col">
    <div class="overflow-x-auto mx-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-2 pb-2 mt-5 ">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>{{ __('messages.title') }}</th>
                    {{-- <th>{{ __('messages.teacher') }}</th> --}}
                    {{-- <th>{{ __('messages.enrollment_date') }}</th> --}}
                    <th>{{ __('messages.start_date') }}</th>
                    <th>{{ __('messages.end_date') }}</th>
                    <th>{{ __('messages.hours_per_day') }}</th>
                    <th>{{ __('messages.duration_hours') }}</th>
                    <th>{{ __('messages.class_status') }}</th>
                    <th>{{ __('messages.display_image') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($classes as $e)
                <tr>
                    {{-- <td> <p>{{ $e->id }}</p> </td> --}}
                    <td> <p>{{ $e->id }}</p> </td>
                    <td> <p>{{ $e->workshop->getTitleAttribute() }}</p> </td>
                    {{-- <td> <p>{{ $e->teacher->name }}</p> </td> --}}
                    {{-- <td> <p>{{ $e->created_at->locale(app()->getLocale())->translatedFormat('l، j F Y') }}</p> </td> --}}
                    <td> <p>{{ $e->start_date->locale(app()->getLocale())->translatedFormat('l، j F Y') }}</p> </td>
                    <td> <p>{{ $e->end_date->locale(app()->getLocale())->translatedFormat('l، j F Y') }}</p> </td>
                    <td> <p>{{ $e->hours_per_day }}</p> </td>
                    <td> <p>{{ $e->workshop->duration_hours }}</p> </td>

                    @php
                        $status = $e->end_date->isPast() ? 'completed' :
                                 (Today()->between($e->start_date, $e->end_date) ? 'in-progress' : 'upcoming');

                        $statusConfig = [
                            'completed' => ['text' => __('Completed'), 'class' => 'bg-gray-100 text-gray-800'],
                            'in-progress' => ['text' => __('In Progress'), 'class' => 'bg-blue-100 text-blue-800'],
                            'upcoming' => ['text' => __('Upcoming'), 'class' => 'bg-green-100 text-green-800'],
                        ];
                    @endphp

                    <td>
                        <span class="px-3 py-1 text-xs font-bold rounded-full {{ $statusConfig[$status]['class'] }}">
                            {{ $statusConfig[$status]['text'] }}
                        </span>
                    </td>

                    <td> <img src="{{asset( url(Storage::url( $e->workshop->image))) }}" width="100px" /> </td>
                    <td class="flex flex-col gap-2 items-center content-center">
                        @if($status == 'in-progress')
                            <x-link-button href="">{{ __('messages.mark_attendance') }}</x-link-button>
                        @endif
                            <x-link-button href="">{{ __('messages.show') }}</x-link-button>
                    </td>
                </tr>


                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4 mx-2">
        {{ $classes->links() }}
    </div>
</div>

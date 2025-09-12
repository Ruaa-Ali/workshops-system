<div class="flex flex-col">
    <div class="overflow-x-auto mx-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-2 pb-2 mt-5 ">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>{{ __('messages.title') }}</th>
                    <th>{{ __('messages.teacher') }}</th>
                    <th>{{ __('messages.enrollment_date') }}</th>
                    <th>{{ __('messages.start_date') }}</th>
                    <th>{{ __('messages.price') }}</th>
                    <th>{{ __('messages.duration_hours') }}</th>
                    <th>{{ __('messages.class_status') }}</th>
                    <th>{{ __('messages.display_image') }}</th>
                    {{-- <th></th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($enrollments as $e)
                <tr>
                    {{-- <td> <p>{{ $e->id }}</p> </td> --}}
                    <td> <p>{{ $e->id }}</p> </td>
                    <td> <p>{{ $e->class->workshop->getTitleAttribute() }}</p> </td>
                    <td> <p>{{ $e->class->teacher->name }}</p> </td>
                    <td> <p>{{ $e->created_at->locale(app()->getLocale())->translatedFormat('l، j F Y') }}</p> </td>
                    <td> <p>{{ $e->class->start_date->locale(app()->getLocale())->translatedFormat('l، j F Y') }}</p> </td>
                    <td> <p>${{ $e->class->price }}</p> </td>
                    <td> <p>{{ $e->class->workshop->duration_hours }}</p> </td>

                    @php
                        $status = $e->class->end_date->isPast() ? 'completed' :
                                 (Today()->between($e->class->start_date, $e->class->end_date) ? 'in-progress' : 'upcoming');

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

                    <td> <img src="{{asset( url(Storage::url( $e->class->workshop->image))) }}" width="100px" /> </td>
                    {{-- <td></td> --}}
                </tr>


                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4 mx-2">
        {{ $enrollments->links() }}
    </div>
</div>

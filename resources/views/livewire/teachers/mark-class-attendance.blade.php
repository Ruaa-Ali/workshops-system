<div class="flex flex-col">
    <div class="overflow-x-auto mt-5 mx-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg px-2 py-2">
        @if(count($session) == 0)
            <p class="text-center my-4 text-lg font-bold">{{ __('messages.no_session') }}</p>

        @elseif($session[0]->status == 'off')
        <p class="text-center my-4 text-lg font-bold">{{ __('messages.off_day') }}</p>

        @else


        @if($session[0]->status == 'completed')
        <p class="text-center my-4 text-lg font-bold">{{ __('messages.attendance_complete', ['item'=>$session[0]->session_date]) }}</p>
        @endif

        @if($session[0]->status == 'scheduled')
        <div class="flex justify-between">
            <p class="my-4 text-lg font-bold">{{ $session[0]->session_date }}</p>
            <div class="flex flex-col items-end gap-4">
                <x-primary-button wire:click='endSession'>
                    {{ __('messages.end_session') }}
                </x-primary-button>
                <div>
                    <span class="text-center text-md">{{ __('messages.taking_day_off', ['item'=>$session[0]->session_date]) }}</span>
                    <x-primary-button wire:click='skipSession' class="dark:bg-red-300 bg-red-500">
                        {{ __('messages.skip_attendance') }}
                    </x-primary-button>
                </div>

            </div>
        </div>
        @endif


        {{-- {{$session[0]}} --}}
        <table class="styled-table">
            <thead>
                <tr>
                    <th>ID</th>
                    {{-- <th>{{ __('messages.enrolled_at') }}</th> --}}
                    <th>{{ __('messages.student_name') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $s)
                <tr>
                    {{-- <td>{{ $s }}</td> --}}
                    <td>{{ $s->student->id }}</td>
                    {{-- <td>{{ $s->pivot->created_at->locale(app()->getLocale())->translatedFormat('l، j F Y') }}</td> --}}
                    <td>{{ $s->student->name }}</td>
                    <td>
                        @if(!$session[0]->attendances->contains('student_id', $s->student->id) && $session[0]->status != 'completed' )
                        <x-primary-button wire:click='present({{ $s->student->id }},{{ $s->id }})' class="dark:bg-green-300 bg-green-500">
                            {{ __('messages.present') }}
                        </x-primary-button>
                        <x-primary-button wire:click='absent({{ $s->student->id }},{{ $s->id }})' class="dark:bg-red-300 bg-red-500">
                            {{ __('messages.absent') }}
                        </x-primary-button>
                        @else

                        @php
                            $attendance = $session[0]->attendances->firstWhere('student_id', $s->student->id);
                        @endphp
                        <span class="mx-5 font-bold {{ $attendance->status == 'present' ? 'dark:bg-green-300 bg-green-500' : 'dark:bg-red-300 bg-red-500' }} text-black px-2 py-1 rounded-lg">{{ $attendance->status }}</span>

                        @if($session[0]->status != 'completed')
                        <x-secondary-button wire:click='undo({{ $s->student->id }})' >
                            {{ __('messages.undo') }}
                        </x-secondary-button>

                        @endif
                        @endif

                    </td>
                </tr>


                @endforeach
            </tbody>
        </table>

        @endif
    </div>

</div>

{{-- {
  "id": 1,
  "session_date": "2025-09-14",
  "status": "scheduled",
  "workshop_offering_id": 13,
  "created_at": "2025-09-14T00:05:04.000000Z",
  "updated_at": "2025-09-14T00:05:04.000000Z",
  "attendances": [
    {
      "id": 1,
      "status": "present",
      "student_id": 3,
      "session_id": 1,
      "enrollment_id": 5,
      "created_at": "2025-09-14T02:58:42.000000Z",
      "updated_at": "2025-09-14T02:58:42.000000Z",
    }
  ]
} --}}


{{-- {
  "id": 5,
  "workshop_offering_id": 13,
  "student_id": 3,
  "created_at": "2025-09-13T02:39:53.000000Z",
  "updated_at": "2025-09-13T02:39:53.000000Z",
  "student": {
    "id": 3,
    "name": "stu",
    "email": "stu@gmail.com",
    "email_verified_at": null,
    "created_at": "2025-09-03T23:40:30.000000Z",
    "updated_at": "2025-09-03T23:40:30.000000Z",
    "deleted_at": null
  }
} --}}

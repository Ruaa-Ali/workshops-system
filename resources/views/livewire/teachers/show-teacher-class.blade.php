<div class="flex flex-col">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg my-5 mx-2">
      <div class="p-6 text-gray-900 dark:text-gray-100">

          <div class="flex items-center justify-between">
            <p class="text-xl font-bold mb-3">{{ __('messages.offering_details') }}</p>
            <x-link-button href="">
                {{ __('messages.mark_attendance') }}
            </x-link-button>
          </div>

          @if($offering)
              <table class="styled-table">
                  <tbody>
                      <tr>
                          <th>{{ __('messages.title') }}</th>
                          <td>{{ $offering->workshop->getTitleAttribute() }}</td>
                      </tr>
                      <tr>
                          <th>{{ __('messages.desc') }}</th>
                          <td>{{ $offering->workshop->getDescriptionAttribute() }}</td>
                      </tr>
                      <tr>
                          <th>{{ __('messages.start_date') }}</th>
                          <td>{{ $offering->start_date }}</td>
                      </tr>
                      <tr>
                          <th>{{ __('messages.end_date') }}</th>
                          <td>{{ $offering->end_date }}</td>
                      </tr>
                      <tr>
                          <th>{{ __('messages.hours_per_day') }}</th>
                          <td>{{ $offering->hours_per_day }}</td>
                      </tr>
                      <tr>
                          <th>{{ __('messages.price') }}</th>
                          <td>${{ $offering->price }}</td>
                      </tr>
                      <tr>
                          <th>{{ __('messages.teacher') }}</th>
                          <td>{{ $offering->teacher->name }}</td>
                      </tr>
                      <tr>
                          <th>{{ __('messages.created_at') }}</th>
                          <td>{{ $offering->created_at }}</td>
                      </tr>

                  </tbody>
              </table>
          @else
              <p>{{ __('messages.unable_to_find_workshop') }}</p>
          @endif

      </div>
    </div>

    <div class="overflow-x-auto mx-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg pb-2 p-6">
        <p class="text-xl font-bold">{{ __('messages.students') }} ({{ count($offering->students) }})</p>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>{{ __('messages.student') }}</th>
                    <th>{{ __('messages.enrollment_date') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($offering->students as $s)
                <tr>
                    <td> <p>{{ $s->id }}</p> </td>
                    <td> <p>{{ $s->name }}</p> </td>
                    <td> <p>{{ $s->created_at }}</p> </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

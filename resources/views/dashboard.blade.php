<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                    <p>hello
                    @role(App\Enums\LocalRole::ADMIN)
                        Admin
                    @elserole(App\Enums\LocalRole::TEACHER)
                        Teacher
                    @else
                        Student
                    @endrole
                    </p>


                    @role(App\Enums\LocalRole::ADMIN)
                    <div class="flex flex-col">
                        <a href="{{ route('workshops.create') }}">add workshop</a>
                        <a href="{{ route('workshops.index') }}">view workshops</a>
                        <a href="{{ route('offerings.create') }}">add offering</a>
                    </div>
                    @endrole

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

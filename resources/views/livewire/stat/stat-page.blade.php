<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">

                <div style="width:50%;">
                    <x-chartjs-component :chart="$workshopChart" />
                </div>


                @role(App\Enums\LocalRole::ADMIN)
                <div style="width:50%;">
                    <x-chartjs-component :chart="$studentChart" />
                </div>
                @endrole

                <div style="width:50%;">
                    <x-chartjs-component :chart="$bestStudents" />
                </div>

                {{-- {{$best}} --}}
            </div>
        </div>
    </div>
</div>

<div class="flex flex-col">
    <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-6 p-4 my-5">
        @foreach($offerings as $o)
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 flex flex-col h-full">
                <!-- Course Image -->
                <img src="{{ asset( url(Storage::url($o->workshop->image))) }}" alt="{{ $o->workshop->getTitleAttribute() }}" class="w-full h-48 object-cover">

                <!-- Course Content -->
                <div class="p-6 flex flex-col flex-grow">
                    <div class="flex-grow mb-4">
                        <h3 class="text-2xl font-bold mb-2">{{ $o->workshop->getTitleAttribute() }}</h3>
                        <h3 class="text-sm mb-2">{{ __('messages.with_eng') }} <span class="font-bold text-lg">{{ $o->teacher->name }}</span></h3>
                        <p class="text-gray-600 dark:text-gray-300 text-sm min-h-[60px]">
                            {{ $o->workshop->getDescriptionAttribute() }}
                        </p>
                    </div>
                    <div class="mt-auto">
                        <div class="flex items-center justify-between mb-3">
                            <div>
                                <p class="text-sm">
                                    {{ __('messages.starts_on') }}
                                    <span class="font-semibold text-lg">{{ $o->start_date->locale(app()->getLocale())->translatedFormat('l، j F Y') }}</span>
                                </p>
                            <p class="text-blue-600 font-semibold">${{ number_format($o->price, 2) }}</p>
                            </div>
                            <div class="flex flex-col items-end">
                                <span class="text-sm text-gray-500">{{ __('messages.class_hours', ['item'=>$o->workshop->duration_hours]) }}</span>
                                <span class="text-sm text-gray-500">{{ __('messages.hour_a_day', ['item'=>$o->hours_per_day]) }}</span>
                            </div>
                        </div>

                        <x-primary-button class="w-full justify-center">
                            {{ __('messages.enroll_now') }}
                        </x-primary-button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="m-4">
        {{ $offerings->links() }}
    </div>
</div>

@props(['active'])

<div
    x-data="{ open: false }"
>
    <!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
    <div x-show="open" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-40 bg-gray-600 bg-opacity-75 md:hidden"></div>

    <div x-show="open" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="fixed inset-y-0 z-40 flex flex-col md:hidden">
        <!-- Sidebar content -->

    </div>

    <!-- Static sidebar for desktop -->
    <div class="hidden md:flex md:flex-shrink-0 absolute h-full">
        <div class="flex flex-col w-64">
            <div class="flex flex-col flex-1 h-0 bg-white dark:bg-gray-800 {{app()->getLocale() == 'en' ? 'border-r' : 'border-l' }}  border-gray-200 dark:border-gray-700">
                <div class="flex items-center h-16 px-4">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>
                <nav class="flex-1 space-y-1 py-4">
                    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('messages.dashboard') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('workshops.index')" :active="request()->routeIs('workshops.index')">
                        {{ __('messages.workshops') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('offerings.index')" :active="request()->routeIs('offerings.index')">
                        {{ __('messages.workshop_offerings') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('enrollments.index')" :active="request()->routeIs('enrollments.index')">
                        {{ __('messages.enrollments') }}
                    </x-responsive-nav-link>
                    <!-- Add other navigation links here -->
                </nav>
            </div>
        </div>
    </div>

    <!-- Toggle button for mobile -->
    {{-- <button @click="open = true" class="fixed bottom-4 left-4 z-50 p-2 rounded-md text-gray-500 bg-white dark:bg-gray-800 md:hidden">
        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button> --}}
</div>

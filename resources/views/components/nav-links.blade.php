{{-- <nav class="flex-1 space-y-1 py-4"> --}}
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

    <x-responsive-nav-link :href="route('users.index', 'role=teacher')" :active="request()->routeIs('users.index') && request()->query('role') == App\Enums\LocalRole::TEACHER->value">
        {{ __('messages.teachers') }}
    </x-responsive-nav-link>

    <x-responsive-nav-link :href="route('users.index', 'role=student')" :active="request()->routeIs('users.index') && request()->query('role') == App\Enums\LocalRole::STUDENT->value">
        {{ __('messages.students') }}
    </x-responsive-nav-link>

    <x-responsive-nav-link :href="route('users.index', 'role=admin')" :active="request()->routeIs('users.index') && request()->query('role') == App\Enums\LocalRole::ADMIN->value">
        {{ __('messages.admins') }}
    </x-responsive-nav-link>
    <!-- Add other navigation links here -->
{{-- </nav> --}}

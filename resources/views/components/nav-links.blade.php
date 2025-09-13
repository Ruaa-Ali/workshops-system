{{-- <nav class="flex-1 space-y-1 py-4"> --}}


    @can(App\Enums\PermissionsTypes::VIEW_STATS)
    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
        {{ __('messages.dashboard') }}
    </x-responsive-nav-link>
    @endcan


    @role(App\Enums\LocalRole::ADMIN)
    <x-responsive-nav-link :href="route('workshops.index')" :active="request()->routeIs('workshops.index')">
        {{ __('messages.workshops') }}
    </x-responsive-nav-link>
    @endrole

    @can(App\Enums\PermissionsTypes::MANAGE_OFFERINGS)
    <x-responsive-nav-link :href="route('offerings.index')" :active="request()->routeIs('offerings.index')">
        {{ __('messages.workshop_offerings') }}
    </x-responsive-nav-link>
    @endcan

    @can(App\Enums\PermissionsTypes::MANAGE_OWN_OFFERINGS)
    <x-responsive-nav-link :href="route('teacher.offerings.index')" :active="request()->routeIs('teacher.offerings.index')">
        {{ __('messages.my_classes') }}
    </x-responsive-nav-link>
    @endcan

    @can(App\Enums\PermissionsTypes::VIEW_ENROLLMENTS)
    <x-responsive-nav-link :href="route('enrollments.index')" :active="request()->routeIs('enrollments.index')">
        {{ __('messages.enrollments') }}
    </x-responsive-nav-link>
    @endcan

    @role(App\Enums\LocalRole::ADMIN)
    <x-responsive-nav-link :href="route('users.index', 'role=teacher')" :active="request()->routeIs('users.index') && request()->query('role') == App\Enums\LocalRole::TEACHER->value">
        {{ __('messages.teachers') }}
    </x-responsive-nav-link>

    <x-responsive-nav-link :href="route('users.index', 'role=student')" :active="request()->routeIs('users.index') && request()->query('role') == App\Enums\LocalRole::STUDENT->value">
        {{ __('messages.students') }}
    </x-responsive-nav-link>

    <x-responsive-nav-link :href="route('users.index', 'role=admin')" :active="request()->routeIs('users.index') && request()->query('role') == App\Enums\LocalRole::ADMIN->value">
        {{ __('messages.admins') }}
    </x-responsive-nav-link>
    @endrole

    @role(App\Enums\LocalRole::STUDENT)
    <x-responsive-nav-link :href="route('classes.index')" :active="request()->routeIs('classes.index')">
        {{ __('messages.available_classes') }}
    </x-responsive-nav-link>

    <x-responsive-nav-link :href="route('students.classes.index')" :active="request()->routeIs('students.classes.index')">
        {{ __('messages.my_classes') }}
    </x-responsive-nav-link>
    @endrole
    <!-- Add other navigation links here -->
{{-- </nav> --}}

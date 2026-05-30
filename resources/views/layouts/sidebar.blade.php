<div>
    <div class="hidden md:flex md:flex-shrink-0 absolute min-h-screen">
        <div class="flex flex-col w-64">
            <div class="flex flex-col flex-1 h-0 bg-white dark:bg-gray-800 {{app()->getLocale() == 'en' ? 'border-r' : 'border-l' }}  border-gray-200 dark:border-gray-700">
                <div class="flex items-center h-16 px-4">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>
                <nav class="flex-1 space-y-1 py-4">
                    @include('components/nav-links')
                </nav>
            </div>
        </div>
    </div>
</div>

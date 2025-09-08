<button
    type="button"
     class=" rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
     x-on:click="$store.theme.toggle()"
>
    <!-- Sun icon (light mode) -->
    <svg class="light-icon w-5 h-5 theme-icon-colors" x-show="$store.theme.current === 'light'" fill="none" stroke="currentColor" viewBox="0 0 24 24" >
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
    </svg>

    <!-- Moon icon (dark mode) -->
    <svg class="dark-icon w-5 h-5 theme-icon-colors" x-show="$store.theme.current === 'dark'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
    </svg>
</button>

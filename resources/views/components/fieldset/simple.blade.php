@props(['title' => null])

<div {{$attributes->merge(['class' => 'border border-gray-300 dark:border-gray-700 rounded-xl p-4 relative'])}}>
    @if($title)
        <span class="absolute -top-3 left-4 bg-white dark:bg-gray-900 px-2 text-sm font-medium text-gray-600 dark:text-gray-300">
            {{ $title }}
        </span>
    @endif

    {{ $slot }}
</div>
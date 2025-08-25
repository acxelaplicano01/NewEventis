@props(['active'])

@php
    // Si no se proporciona el estado "active", mantener el comportamiento existente
    $isActive = $active ?? false;
@endphp

<a {{ $attributes->merge(['class' =>
    ($isActive  ? 'bg-yellow-400 flex transition duration-100 ease-in-out dark:bg-white/[7%] items-center p-1 text-white rounded-lg dark:text-yellow-400 border-yellow-200 border dark:border-stone-800  dark:hover:text-yellow-400 dark:hover:bg-white/[7%] group' 
    : 'bg-stone-0 flex transition duration-100 ease-in-out items-center p-1 text-stone-500 hover:text-stone-800 rounded-lg dark:text-stone-400 dark:hover:text-stone-300 hover:bg-stone-800/5 dark:hover:bg-white/[7%] group')]) }}>
    {{ $slot }}
</a>
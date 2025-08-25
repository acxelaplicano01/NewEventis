@props(['disabled' => false, 'error' => false])

<textarea {{ $disabled ? 'disabled' : '' }} 
    {!! $attributes->merge([
        'class' => 'border-stone-300 dark:border-stone-700 dark:bg-stone-800 dark:text-stone-300 focus:border-yellow-500 dark:focus:border-yellow-600 focus:ring-yellow-500 dark:focus:ring-yellow-600 rounded-md shadow-sm w-full' . 
        ($error ? ' border-red-500 dark:border-red-600 focus:border-red-500 dark:focus:border-red-600 focus:ring-red-500 dark:focus:ring-red-600' : '')
    ]) !!}
></textarea>
@props([
    'loadingTarget' => null,
    'loadingText' => 'Cargando...',
    'type' => 'button',
    'disabled' => false,
    'icon' => null, // Slot para el icono
])

@php
    $classes = 'inline-flex items-center px-4 py-2 bg-white dark:bg-stone-800 border border-stone-300 dark:border-stone-600 rounded-md font-semibold text-xs text-stone-700 dark:text-stone-300 uppercase tracking-widest shadow-sm hover:bg-stone-50 dark:hover:bg-stone-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 dark:focus:ring-stone-500 dark:focus:ring-offset-stone-800 disabled:opacity-25 transition ease-in-out duration-150 disabled:cursor-not-allowed';
@endphp

<button 
    {{ $attributes->merge([
        'type' => $type,
        'class' => $classes,
        'wire:loading.attr' => $loadingTarget ? 'disabled' : null
    ]) }}
    @if($disabled) disabled @endif
>
    @if($loadingTarget)
        <!-- Estado normal - oculto durante loading -->
        <span wire:loading.remove wire:target="{{ $loadingTarget }}" class="flex flex-row items-center">
            @if($icon)
                <!-- Icono personalizado -->
                {{ $icon }}
            @endif
            {{ $slot }}
        </span>
        
        <!-- Estado loading - visible durante loading -->
        <span wire:loading wire:target="{{ $loadingTarget }}" class="flex flex-row items-center">
            <!-- Spinner reemplaza al icono -->
            
            <!-- Texto de carga -->
            {{ $loadingText }}
        </span>
    @else
        <!-- Sin loading target, mostrar contenido normal -->
        <span class="flex flex-row items-center">
            @if($icon)
                {{ $icon }}
            @endif
            {{ $slot }}
        </span>
    @endif
</button>

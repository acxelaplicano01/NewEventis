<x-dialog-modal wire:model="isOpen" maxWidth="md">
    <x-slot name="title">
        {{ $nacionalidad_id ? 'Editar Nacionalidad' : 'Nueva Nacionalidad' }}
    </x-slot>

    <x-slot name="content">
        <form wire:submit.prevent="store">
            <div class="mb-4">
                <label class="block text-sm font-medium text-stone-700 dark:text-stone-200 mb-2">
                    Nombre de la nacionalidad
                </label>
                <input type="text" wire:model="nombreNacionalidad"
                    class="w-full px-3 py-2 border border-stone-300 dark:border-stone-600 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 dark:bg-stone-700 dark:text-stone-100 transition duration-200"
                    placeholder="Ingrese el nombre de la nacionalidad" required />
                @error('nombreNacionalidad')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>
        </form>
    </x-slot>

    <x-slot name="footer">
        <x-spinner-secondary-button wire:click="closeModal" type="button" loadingTarget="closeModal" loadingText="Cerrando...">
            {{ __('Cancelar') }}
        </x-spinner-secondary-button>
        
        <x-spinner-button type="submit" wire:click="store" loadingTarget="store" :loadingText="$nacionalidad_id ? 'Actualizando...' : 'Creando...'">
            {{ $nacionalidad_id ? __('Actualizar') : __('Crear') }} {{ __('Nacionalidad') }}
        </x-spinner-button>
    </x-slot>
</x-dialog-modal>
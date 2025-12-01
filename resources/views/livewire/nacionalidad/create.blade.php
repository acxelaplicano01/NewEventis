<div>
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
                    <input 
                        type="text" 
                        wire:model="nombreNacionalidad" 
                        class="w-full px-3 py-2 border border-stone-300 dark:border-stone-600 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-stone-700 dark:text-stone-100 transition duration-200" 
                        placeholder="Ingrese el nombre de la nacionalidad"
                        required 
                    />
                    @error('nombreNacionalidad') 
                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> 
                    @enderror
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <button 
                type="button" 
                wire:click="closeModal" 
                class="px-4 py-2 bg-stone-300 hover:bg-stone-400 dark:bg-stone-600 dark:hover:bg-stone-500 text-stone-800 dark:text-stone-100 rounded-md transition duration-200 mr-2"
            >
                Cancelar
            </button>
            <button 
                type="button" 
                wire:click="store" 
                class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-md transition duration-200 font-medium shadow-sm"
            >
                {{ $nacionalidad_id ? 'Actualizar' : 'Guardar' }}
            </button>
        </x-slot>
    </x-dialog-modal>
</div>
<x-dialog-modal wire:model="isOpen">
    <x-slot name="title">
        {{ isset($conferencia_id) && $conferencia_id ? 'Editar Conferencia' : 'Nueva Conferencia' }}
    </x-slot>
    <x-slot name="content">
        <form wire:submit.prevent="store">
            <div class="mb-4">
                <label for="evento" class="block text-stone-700 text-sm font-bold mb-2 dark:text-white">Evento:</label>
                <input wire:model.live="inputSearchEvento"
                    class="shadow bg-stone-50 border border-stone-300 text-stone-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-stone-700 dark:border-stone-600 dark:placeholder-stone-400 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500"
                    type="text" placeholder="Buscar evento..." readonly>
                @error('IdEvento') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label for="foto" class="block text-stone-700 text-sm font-bold mb-2 dark:text-white">Imagen:</label>
                <input type="file" wire:model="foto"
                    class="block w-full text-sm text-stone-900 bg-stone-50 rounded-lg border border-stone-300 cursor-pointer dark:bg-stone-700 dark:border-stone-600 dark:placeholder-stone-400 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500">
                @if ($foto)
                    <img src="{{ $foto->temporaryUrl() }}" class="mt-2 w-20 h-20 object-cover rounded-full">
                @endif
            </div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="mb-4">
                    <label for="nombre" class="block text-stone-700 text-sm font-bold mb-2 dark:text-white">Nombre de la Conferencia:</label>
                    <input type="text"
                        class="shadow bg-stone-50 border border-stone-300 text-stone-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-stone-700 dark:border-stone-600 dark:placeholder-stone-400 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500"
                        id="nombre" placeholder="Nombre de la Conferencia" wire:model="nombre">
                    @error('nombre') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
                <div class="mb-4">
                    <label for="descripcion" class="block text-stone-700 text-sm font-bold mb-2 dark:text-white">Descripción:</label>
                    <textarea
                        class="shadow bg-stone-50 border border-stone-300 text-stone-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-stone-700 dark:border-stone-600 dark:placeholder-stone-400 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500"
                        id="descripcion" placeholder="Descripción" wire:model="descripcion"></textarea>
                    @error('descripcion') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="mb-4">
                    <label for="fecha" class="block text-stone-700 text-sm font-bold mb-2 dark:text-white">Fecha:</label>
                    <input type="date"
                        class="shadow bg-stone-50 border border-stone-300 text-stone-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-stone-700 dark:border-stone-600 dark:placeholder-stone-400 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500"
                        id="fecha" wire:model="fecha">
                    @error('fecha') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
                <div class="mb-4">
                    <label for="lugar" class="block text-stone-700 text-sm font-bold mb-2 dark:text-white">Lugar:</label>
                    <textarea
                        class="shadow bg-stone-50 border border-stone-300 text-stone-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-stone-700 dark:border-stone-600 dark:placeholder-stone-400 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500"
                        id="lugar" placeholder="Lugar" wire:model="lugar"></textarea>
                    @error('lugar') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="mb-4">
                    <label for="horaInicio" class="block text-stone-700 text-sm font-bold mb-2 dark:text-white">Hora Inicio:</label>
                    <input type="time"
                        class="shadow bg-stone-50 border border-stone-300 text-stone-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-stone-700 dark:border-stone-600 dark:placeholder-stone-400 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500"
                        id="horaInicio" wire:model="horaInicio">
                    @error('horaInicio') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
                <div class="mb-4">
                    <label for="horaFin" class="block text-stone-700 text-sm font-bold mb-2 dark:text-white">Hora Fin:</label>
                    <input type="time"
                        class="shadow bg-stone-50 border border-stone-300 text-stone-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-stone-700 dark:border-stone-600 dark:placeholder-stone-400 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500"
                        id="horaFin" wire:model="horaFin">
                    @error('horaFin') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="mb-4 col-span-2">
                <label for="linkreunion" class="block text-stone-700 text-sm font-bold mb-2 dark:text-white">Link Reunion:</label>
                <input type="url"
                    class="shadow bg-stone-50 border border-stone-300 text-stone-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-stone-700 dark:border-stone-600 dark:placeholder-stone-400 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500"
                    id="linkreunion" placeholder="Link Reunion" wire:model="linkreunion">
                @error('linkreunion') <span class="text-red-500">{{ $message }}</span>@enderror
            </div>
            <div class="mb-4 col-span-2">
                <label for="conferencistaSearch" class="block text-stone-700 text-sm font-bold mb-2 dark:text-white">Conferencista:</label>
                <input type="text" wire:model.live="inputSearchConferencista"
                    class="shadow bg-stone-50 border border-stone-300 text-stone-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-stone-700 dark:border-stone-600 dark:placeholder-stone-400 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500"
                    id="conferencistaSearch" placeholder="Buscar conferencista...">
                @if (count($searchConferencistas) > 0)
                    <ul class="mt-2 bg-white border border-stone-300 rounded-lg shadow-lg dark:bg-stone-800 dark:border-stone-700">
                        @foreach($searchConferencistas as $conferencista)
                            <li wire:click="selectConferencista({{ $conferencista->id }})"
                                class="cursor-pointer px-4 py-2 hover:bg-stone-100 dark:hover:bg-stone-600 dark:hover:text-white">
                                {{ $conferencista->user->nombre }} {{ $conferencista->user->apellido }}
                            </li>
                        @endforeach
                    </ul>
                @endif
                @error('idConferencista') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-stone-700 dark:text-stone-300">Estado:</label>
                <select class="focus:ring-yellow-500 focus:border-yellow-500 mt-1 block w-full rounded-md border-stone-300 shadow-sm dark:bg-stone-700 dark:border-stone-600 dark:text-stone-300"
                    id="estado" name="estado" wire:model.live="estado" required>
                    <option value="" >Seleccione estado</option>
                    <option value="Gratis">Gratis</option>
                    <option value="Pagado">Pagado</option>
                </select>
                @error('estado') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            @if($estado == 'Pagado') 
                <div class="mb-4">
                    <label for="precio" class="block text-stone-700 text-sm font-bold mb-2 dark:text-white">Precio:</label>
                    <input type="number" wire:model="precio"
                        class="shadow bg-stone-50 border border-stone-300 text-stone-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-stone-700 dark:border-stone-600 dark:placeholder-stone-400 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500"
                        id="precio" placeholder="Precio" step="0.01" min="0">
                    @error('precio') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
            @endif
        </form>
    </x-slot>
    <x-slot name="footer">
        <x-spinner-secondary-button wire:click="closeModal" type="button" loadingTarget="closeModal" loadingText="Cerrando...">
            {{ __('Cancelar') }}
        </x-spinner-secondary-button>
        
        <x-spinner-button type="submit" wire:click="store" loadingTarget="store" :loadingText="$conferencia_id ? 'Actualizando...' : 'Creando...'">
            {{ $conferencia_id ? __('Actualizar') : __('Crear') }} {{ __('Conferencia') }}
        </x-spinner-button>
    </x-slot>
</x-dialog-modal>

<x-dialog-modal wire:model="isOpen" maxWidth="2xl">
    <x-slot name="title">
        {{ $evento_id ? 'Editar Evento' : 'Crear Evento' }}
    </x-slot>

    <x-slot name="content">
        <form wire:submit.prevent="store">
                        <div class="mb-4">
                            <label for="nombreevento"
                                class="block text-stone-700 text-sm font-bold mb-2 dark:text-white">Nombre del Evento:</label>
                            <input type="text"
                                class="shadow bg-stone-50 border border-stone-300 text-stone-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-stone-700 dark:border-stone-600 dark:placeholder-stone-400 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500"
                                id="nombreevento" placeholder="Nombre Evento" wire:model="nombreevento">
                            @error('nombreevento') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="logo" class="block text-stone-700 text-sm font-bold mb-2 dark:text-white">Foto:</label>
                            <input type="file" wire:model="logo"
                                class="block w-full text-sm text-stone-900 bg-stone-50 rounded-lg border border-stone-300 cursor-pointer dark:bg-stone-700 dark:border-stone-600 dark:placeholder-stone-400 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500">
                                @if ($logo instanceof \Illuminate\Http\UploadedFile)
                                    <img src="{{ $logo->temporaryUrl() }}" class="mt-2 w-20 h-20 object-cover rounded-full">
                                @else
                                    <p></p>
                                @endif
                        </div>
                        <div class="mb-4">
                            <label for="descripcion"
                                class="block text-stone-700 text-sm font-bold mb-2 dark:text-white">Descripción:</label>
                            <textarea
                                class="shadow bg-stone-50 border border-stone-300 text-stone-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-stone-700 dark:border-stone-600 dark:placeholder-stone-400 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500"
                                id="descripcion" placeholder="Descripción" wire:model="descripcion"></textarea>
                            @error('descripcion') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="organizador"
                                class="block text-stone-700 text-sm font-bold mb-2 dark:text-white">Organizador:</label>
                            <input type="text"
                                class="shadow bg-stone-50 border border-stone-300 text-stone-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-stone-700 dark:border-stone-600 dark:placeholder-stone-400 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500"
                                id="organizador" placeholder="Organizador" wire:model="organizador">
                            @error('organizador') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div class="mb-4">
                                <label for="fechainicio"
                                    class="block text-stone-700 text-sm font-bold mb-2 dark:text-white">Fecha Inicio:</label>
                                <input type="date"
                                    class="shadow bg-stone-50 border border-stone-300 text-stone-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-stone-700 dark:border-stone-600 dark:placeholder-stone-400 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500"
                                    id="fechainicio" wire:model="fechainicio">
                                @error('fechainicio') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                            <div class="mb-4">
                                <label for="fechafinal"
                                    class="block text-stone-700 text-sm font-bold mb-2 dark:text-white">Fecha Fin:</label>
                                <input type="date"
                                    class="shadow bg-stone-50 border border-stone-300 text-stone-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-stone-700 dark:border-stone-600 dark:placeholder-stone-400 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500"
                                    id="fechafinal" wire:model="fechafinal">
                                @error('fechafinal') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div class="mb-4">
                                <label for="horainicio"
                                    class="block text-stone-700 text-sm font-bold mb-2 dark:text-white">Hora Inicio:</label>
                                <input type="time"
                                    class="shadow bg-stone-50 border border-stone-300 text-stone-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-stone-700 dark:border-stone-600 dark:placeholder-stone-400 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500"
                                    id="horainicio" wire:model="horainicio">
                                @error('horainicio') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                            <div class="mb-4">
                                <label for="horafin"
                                    class="block text-stone-700 text-sm font-bold mb-2 dark:text-white">Hora Fin:</label>
                                <input type="time"
                                    class="shadow bg-stone-50 border border-stone-300 text-stone-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-stone-700 dark:border-stone-600 dark:placeholder-stone-400 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500"
                                    id="horafin" wire:model="horafin">
                                @error('horafin') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="mb-4">
                        <label class="block text-sm mb-2 font-medium text-stone-700 dark:text-stone-300">Estado:</label>
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
                        </div>
                    @endif

                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div class="mb-4">
                                <label for="modalidadSelect"
                                    class="block text-stone-700 text-sm font-bold mb-2 dark:text-white">Modalidad:</label>
                                <select id="modalidadSelect"
                                    class="shadow bg-stone-50 border border-stone-300 text-stone-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-stone-700 dark:border-stone-600 dark:placeholder-stone-400 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500"
                                    wire:model="idmodalidad">
                                    <option value="">Seleccione una Modalidad</option>
                                    @foreach($modalidades as $modalidad)
                                        <option value="{{ $modalidad->id }}">{{ $modalidad->modalidad }}</option>
                                    @endforeach
                                </select>
                                @error('idmodalidad') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                            <div class="mb-4">
                                <label for="localidadSelect"
                                    class="block text-stone-700 text-sm font-bold mb-2 dark:text-white">Localidad:</label>
                                <select id="localidadSelect"
                                    class="shadow bg-stone-50 border border-stone-300 text-stone-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-stone-700 dark:border-stone-600 dark:placeholder-stone-400 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500"
                                    wire:model="idlocalidad">
                                    <option value="">Seleccione una Localidad</option>
                                    @foreach($localidades as $localidad)
                                        <option value="{{ $localidad->id }}">{{ $localidad->localidad }}</option>
                                    @endforeach
                                </select>
                                @error('idlocalidad') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                            <div class="mb-4">
                                <label for="diplomasSelect"
                                    class="block text-stone-700 text-sm font-bold mb-2 dark:text-white">Plantilla del diploma:</label>
                                <select id="diplomasSelect"
                                    class="shadow bg-stone-50 border border-stone-300 text-stone-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-stone-700 dark:border-stone-600 dark:placeholder-stone-400 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500"
                                    wire:model="IdDiploma">
                                    <option value="">Plantilla del diploma</option>
                                    @foreach($diplomas as $diploma)
                                        <option value="{{ $diploma->id }}">Plantilla Diploma: {{ $diploma->Nombre }}</option>
                                    @endforeach
                                </select>
                                @error('IdDiploma') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>
        </form>
    </x-slot>

    <x-slot name="footer">
        <x-secondary-button wire:click="closeModal()" wire:loading.attr="disabled">
            {{ __('Cancelar') }}
        </x-secondary-button>

        <x-button class="ms-3" wire:click="store()" wire:loading.attr="disabled">
            {{ __('Guardar') }}
        </x-button>
    </x-slot>
</x-dialog-modal>

<div class="fixed z-50 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-stone-500 opacity-75"></div>
        </div>

        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full dark:bg-stone-900"
            role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <form wire:submit.prevent="storEvento">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 dark:bg-stone-900">
                    <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-stone-600">
                        <h3 class="text-lg font-semibold text-stone-900 dark:text-white">
                            {{ $evento_id ? 'Editar Evento' : 'Crear Evento' }}
                        </h3>
                        <button wire:click="closeModal" type="button"
                            class="text-stone-400 bg-transparent hover:bg-stone-200 hover:text-stone-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-stone-600 dark:hover:text-white">
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <div class="">
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
                    </div>
                </div>

                <div class="bg-stone-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse dark:bg-stone-700">
                    <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                        <button type="submit"
                            class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-yellow-500 text-base leading-6 font-medium text-white shadow-sm hover:bg-yellow-600 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Crear evento
                        </button>
                    </span>
                    <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                        <button wire:click="closeModal" type="button"
                            class="inline-flex justify-center w-full rounded-md border border-stone-300 px-4 py-2 bg-white text-base leading-6 font-medium text-stone-700 shadow-sm hover:text-stone-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Cancelar
                        </button>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>

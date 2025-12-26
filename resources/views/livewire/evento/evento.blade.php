<div>
    <div class=" dark:bg-stone-900">
        <div class="">
            <div
                class="bg-white overflow-hidden sm:rounded-lg px-4 py-4 dark:bg-stone-800  dark:text-stone-400 group-hover:text-stone-900 dark:group-hover:text-white">
                @if (session()->has('message'))
                    <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3"
                        role="alert">
                        <div class="flex">
                            <div>
                                <p class="text-sm">{{ session('message') }}</p>
                            </div>
                        </div>
                    </div>
                @endif




                @if($isOpen)
                    @include('livewire.evento.create')
                @endif


                <div class="mb-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4">
                        <h2 class="text-xl font-semibold text-stone-800 dark:text-stone-200">
                            {{ __('Administración de Eventos') }}
                        </h2>

                        <div class="flex flex-col sm:flex-row w-full sm:w-auto space-y-3 sm:space-y-0 sm:space-x-2">
                            <div class="relative w-full sm:w-auto">
                                <x-input wire:model.live="search" type="text" placeholder="Buscar eventos..."
                                    class="w-full pl-10 pr-4 py-2" />
                                <div class="absolute left-3 top-2.5">
                                    <svg class="h-5 w-5 text-stone-500 dark:text-stone-400"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="w-full sm:w-auto">
                                <x-select id="perPage" wire:model.live="perPage" :options="[
                                    ['value' => '10', 'text' => '10 por página'],
                                    ['value' => '25', 'text' => '25 por página'],
                                    ['value' => '50', 'text' => '50 por página'],
                                    ['value' => '100', 'text' => '100 por página'],
                                ]"        class="w-full" />
                            </div>
                            @can('configuracion.usuarios.crear')
                                <x-spinner-button wire:click="create()" loadingTarget="create()"
                                    :loadingText="__('Abriendo...')">
                                    <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    {{ __('Nuevo Evento') }}
                                </x-spinner-button>
                            @endcan
                        </div>
                    </div>
                </div>

                <x-table :columns="[
                        ['key' => 'id', 'label' => 'No.'],
                        ['key' => 'nombreevento', 'label' => 'Nombre Evento'],
                        ['key' => 'logo', 'label' => 'Logo'],
                        ['key' => 'modalidad', 'label' => 'Modalidad'],
                        ['key' => 'localidad', 'label' => 'Localidad'],
                        ['key' => 'plantilla', 'label' => 'Plantilla Diploma'],
                        ['key' => 'acciones', 'label' => 'Acciones', 'class' => 'text-right'],
                    ]"
                    empty-message="No se encontraron eventos" class="mt-6">
                    <x-slot name="desktop">
                        @forelse($eventos as $nombreevento)
                            <tr class="hover:bg-stone-50 dark:hover:bg-stone-700 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-stone-900 dark:text-stone-300">
                                    {{ $nombreevento->id }}</td>
                                <td class="px-6 py-4 text-stone-900 dark:text-stone-300">{{ $nombreevento->nombreevento }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($nombreevento->logo)
                                        <img src="{{ asset('storage/' . $nombreevento->logo) }}" alt="Logo del Evento"
                                            class="w-12 h-12 object-cover rounded">
                                    @else
                                        <span class="text-stone-400 dark:text-stone-500 text-sm">Sin foto</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-stone-900 dark:text-stone-300">
                                    {{ $nombreevento->modalidad->modalidad }}</td>
                                <td class="px-6 py-4 text-stone-900 dark:text-stone-300">
                                    {{ $nombreevento->localidad->localidad }}</td>
                                <td class="px-6 py-4">
                                    @if($nombreevento->diploma->Plantilla)
                                        <img src="{{ asset('storage/' . $nombreevento->diploma->Plantilla) }}" alt="Plantilla"
                                            class="w-12 h-12 object-cover rounded">
                                    @else
                                        <span class="text-stone-400 dark:text-stone-500 text-sm">Sin Plantilla</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('reporteEvento', ['evento' => $nombreevento->id]) }}"
                                            class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300"
                                            title="Ver más">
                                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-width="2"
                                                    d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                                <path stroke="currentColor" stroke-width="2"
                                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('conferencias', ['evento' => $nombreevento->id]) }}"
                                            class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300"
                                            title="Conferencia">
                                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                        </a>
                                        @if($nombreevento->estado == 'Pagado')
                                            <a href="{{ route('inscripcion-evento', ['evento' => $nombreevento->id]) }}"
                                                class="text-green-700 hover:text-green-900 dark:text-green-500 dark:hover:text-green-300"
                                                title="Pagos">
                                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 8h6m-6 4h6m-6 4h6M6 3v18l2-2 2 2 2-2 2 2 2-2 2 2V3l-2 2-2-2-2 2-2-2-2 2-2-2Z" />
                                                </svg>
                                            </a>
                                        @endif
                                        <button wire:click="edit({{ $nombreevento->id }})"
                                            class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300"
                                            title="Editar">
                                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                            </svg>
                                        </button>
                                        <button wire:click="confirmDelete({{ $nombreevento->id }})"
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                            title="Eliminar">
                                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-4 text-center text-stone-500 dark:text-stone-400">
                                    No se encontraron eventos
                                </td>
                            </tr>
                        @endforelse
                    </x-slot>

                    <x-slot name="mobile">
                        @forelse($eventos as $nombreevento)
                            <div
                                class="bg-white dark:bg-stone-800 p-4 rounded-lg shadow-sm border border-stone-200 dark:border-stone-700">
                                <div class="flex justify-between items-start mb-3">
                                    <span
                                        class="bg-stone-100 dark:bg-stone-700 text-stone-800 dark:text-stone-300 px-2 py-1 rounded-full text-xs">
                                        ID: {{ $nombreevento->id }}
                                    </span>
                                </div>

                                <div class="flex items-center gap-3 mb-3">
                                    @if($nombreevento->logo)
                                        <img src="{{ asset('storage/' . $nombreevento->logo) }}" alt="Logo del Evento"
                                            class="w-16 h-16 object-cover rounded-lg">
                                    @else
                                        <div
                                            class="w-16 h-16 bg-stone-200 dark:bg-stone-700 rounded-lg flex items-center justify-center">
                                            <span class="text-stone-400 text-xs">Sin logo</span>
                                        </div>
                                    @endif
                                    <div>
                                        <h3 class="font-semibold text-stone-900 dark:text-stone-200 text-lg">
                                            {{ $nombreevento->nombreevento }}</h3>
                                        <p class="text-stone-600 dark:text-stone-400 text-sm">
                                            {{ $nombreevento->organizador }}</p>
                                    </div>
                                </div>

                                <div class="space-y-2 text-sm mb-3">
                                    <div>
                                        <span class="font-medium text-stone-700 dark:text-stone-300">Descripción:</span>
                                        <p class="text-stone-600 dark:text-stone-400">{{ $nombreevento->descripcion }}</p>
                                    </div>
                                    <div>
                                        <span class="font-medium text-stone-700 dark:text-stone-300">Modalidad:</span>
                                        <span
                                            class="text-stone-600 dark:text-stone-400">{{ $nombreevento->modalidad->modalidad }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium text-stone-700 dark:text-stone-300">Localidad:</span>
                                        <span
                                            class="text-stone-600 dark:text-stone-400">{{ $nombreevento->localidad->localidad }}</span>
                                    </div>
                                    @if($nombreevento->diploma->Plantilla)
                                        <div>
                                            <span class="font-medium text-stone-700 dark:text-stone-300">Plantilla:</span>
                                            <img src="{{ asset('storage/' . $nombreevento->diploma->Plantilla) }}"
                                                alt="Plantilla" class="w-16 h-16 object-cover rounded mt-1">
                                        </div>
                                    @endif
                                </div>

                                <div class="flex flex-col gap-2 mt-4">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('reporteEvento', ['evento' => $nombreevento->id]) }}"
                                            class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300"
                                            title="Ver más">
                                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-width="2"
                                                    d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                                <path stroke="currentColor" stroke-width="2"
                                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('conferencias', ['evento' => $nombreevento->id]) }}"
                                            class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300"
                                            title="Conferencia">
                                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                        </a>
                                        @if($nombreevento->estado == 'Pagado')
                                            <a href="{{ route('inscripcion-evento', ['evento' => $nombreevento->id]) }}"
                                                class="text-green-700 hover:text-green-900 dark:text-green-500 dark:hover:text-green-300"
                                                title="Pagos">
                                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 8h6m-6 4h6m-6 4h6M6 3v18l2-2 2 2 2-2 2 2 2-2 2 2V3l-2 2-2-2-2 2-2-2-2 2-2-2Z" />
                                                </svg>
                                            </a>
                                        @endif
                                        <button wire:click="edit({{ $nombreevento->id }})"
                                            class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300"
                                            title="Editar">
                                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                            </svg>
                                        </button>
                                        <button wire:click="confirmDelete({{ $nombreevento->id }})"
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                            title="Eliminar">
                                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div
                                class="bg-white dark:bg-stone-800 p-4 rounded-lg shadow text-center text-stone-500 dark:text-stone-400">
                                No se encontraron eventos
                            </div>
                        @endforelse
                    </x-slot>

                    <x-slot name="footer">
                        {{ $eventos->links() }}
                    </x-slot>
                </x-table>
            </div>

        </div>

    </div>

    @if (session()->has('error'))
        <div class="fixed z-50 inset-0 flex items-center justify-center overflow-y-auto ease-out duration-400">
            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-stone-500 opacity-75"></div>
            </div>

            <div class="bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Error</h3>
                    <p>{{ session('error') }}</p>
                    <div class="mt-4 flex justify-end">
                        <button wire:click="cancelarEliminacion"
                            class="bg-stone-500 hover:bg-stone-600 text-white font-bold py-2 px-4 rounded mr-2">
                            Aceptar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @elseif ($confirmingDelete)
            <x-elegant-delete-modal
                wire:model="confirmingDelete"
                title="Confirmación de Eliminación"
                message="¿Estás seguro de que deseas eliminar el evento '{{ $nombreEventoAEliminar }}'? Esta acción no se puede deshacer."
                confirmText="Eliminar"
                cancelText="Cancelar"
                confirmMethod="delete"
                cancelMethod="cancelarEliminacion"
            />
        @endif

</div>
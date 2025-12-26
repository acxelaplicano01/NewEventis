<div class="bg-white dark:bg-stone-800 rounded-lg shadow-md p-6">
    <div class="mb-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4">
            <h2 class="text-xl font-semibold text-stone-800 dark:text-stone-200">
                {{ __('Administración de Conferencias') }}
            </h2>

            <div class="flex flex-col sm:flex-row w-full sm:w-auto space-y-3 sm:space-y-0 sm:space-x-2">
                <div class="relative w-full sm:w-auto">
                    <x-input wire:model.live="search" type="text" placeholder="Buscar conferencias..."
                        class="w-full pl-10 pr-4 py-2" />
                    <div class="absolute left-3 top-2.5">
                        <svg class="h-5 w-5 text-stone-500 dark:text-stone-400" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                    ]" class="w-full" />
                </div>
                @can('mantenimiento.conferencias.crear')
                    <x-spinner-button wire:click="create()" loadingTarget="create()" :loadingText="__('Abriendo...')">
                        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        {{ __('Nueva conferencia') }}
                    </x-spinner-button>
                @endcan
            </div>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
            {{ session('message') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="mb-4 p-3 rounded bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
            {{ session('error') }}
        </div>
    @endif

    <x-table
        sort-field="{{ $sortField }}"
        sort-direction="{{ $sortDirection }}"
        :columns="[
            ['key' => 'id', 'label' => '#', 'sortable' => true],
            ['key' => 'foto', 'label' => 'Imagen'],
            ['key' => 'evento', 'label' => 'Evento'],
            ['key' => 'nombre', 'label' => 'Nombre'],
            ['key' => 'lugar', 'label' => 'Lugar'],
            ['key' => 'conferencista', 'label' => 'Conferencista'],
            ['key' => 'acciones', 'label' => 'Acciones', 'class' => 'text-right'],
        ]"
        empty-message="No hay conferencias registradas"
        class="mt-6"
    >
        <x-slot name="desktop">
            @forelse($conferencias as $conferencia)
                <tr class="hover:bg-stone-50 dark:hover:bg-stone-700 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-stone-900 dark:text-stone-300">{{ $conferencia->id }}</td>
                    <td class="px-6 py-4">
                        @if($conferencia->foto)
                            <img src="{{ asset('storage/' . $conferencia->foto) }}" alt="Logo del Evento" class="w-12 h-12 object-cover">
                        @else
                            <img src="{{ asset('images/default-profile.png') }}" alt="Imagen" class="w-12 h-12 object-cover">
                        @endif
                    </td>
                    <td class="px-6 py-4 text-stone-900 dark:text-stone-300">{{ $conferencia->evento->nombreevento }}</td>
                    <td class="px-6 py-4 text-stone-900 dark:text-stone-300">{{ $conferencia->nombre }}</td>
                    <td class="px-6 py-4 text-stone-900 dark:text-stone-300">{{ $conferencia->lugar }}</td>
                    <td class="px-6 py-4 text-stone-900 dark:text-stone-300">
                        @if ($conferencia->conferencista)
                            @if ($conferencia->conferencista->user)
                                {{ $conferencia->conferencista->user->nombre }}
                                {{ $conferencia->conferencista->user->apellido ?? '' }}
                            @else
                                N/A
                            @endif
                        @else
                            N/A
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end space-x-2">
                            <button wire:click="viewDetails({{ $conferencia->id }})"
                                class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300"
                                title="Ver más">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </button>
                            <a href="{{ route('asistencias-Conferencia', ['conferencia' => $conferencia->id]) }}"
                                class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300"
                                title="Asistencia">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M18 14a1 1 0 1 0-2 0v2h-2a1 1 0 1 0 0 2h2v2a1 1 0 1 0 2 0v-2h2a1 1 0 1 0 0-2h-2v-2Z" clip-rule="evenodd" />
                                    <path fill-rule="evenodd" d="M15.026 21.534A9.994 9.994 0 0 1 12 22C6.477 22 2 17.523 2 12S6.477 2 12 2c2.51 0 4.802.924 6.558 2.45l-7.635 7.636L7.707 8.87a1 1 0 0 0-1.414 1.414l3.923 3.923a1 1 0 0 0 1.414 0l8.3-8.3A9.956 9.956 0 0 1 22 12a9.994 9.994 0 0 1-.466 3.026A2.49 2.49 0 0 0 20 14.5h-.5V14a2.5 2.5 0 0 0-5 0v.5H14a2.5 2.5 0 0 0 0 5h.5v.5c0 .578.196 1.11.526 1.534Z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <button wire:click="edit({{ $conferencia->id }})"
                                class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300"
                                title="Editar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                    <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <button wire:click="confirmDelete({{ $conferencia->id }})"
                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                title="Eliminar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-stone-500 dark:text-stone-400">
                        No hay conferencias registradas
                    </td>
                </tr>
            @endforelse
        </x-slot>

        <x-slot name="mobile">
            @forelse($conferencias as $conferencia)
                <div class="bg-white dark:bg-stone-800 p-4 rounded-lg shadow-sm border border-stone-200 dark:border-stone-700">
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="bg-stone-100 dark:bg-stone-700 text-stone-800 dark:text-stone-300 px-2 py-1 rounded-full text-xs">
                                ID: {{ $conferencia->id }}
                            </span>
                            <h3 class="font-semibold text-stone-900 dark:text-stone-200 text-lg mt-2">{{ $conferencia->nombre }}</h3>
                        </div>
                        <div class="flex space-x-2">
                            <button wire:click="viewDetails({{ $conferencia->id }})"
                                class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </button>
                            <a href="{{ route('asistencias-Conferencia', ['conferencia' => $conferencia->id]) }}"
                                class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300"
                                title="Asistencia">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M18 14a1 1 0 1 0-2 0v2h-2a1 1 0 1 0 0 2h2v2a1 1 0 1 0 2 0v-2h2a1 1 0 1 0 0-2h-2v-2Z" clip-rule="evenodd" />
                                    <path fill-rule="evenodd" d="M15.026 21.534A9.994 9.994 0 0 1 12 22C6.477 22 2 17.523 2 12S6.477 2 12 2c2.51 0 4.802.924 6.558 2.45l-7.635 7.636L7.707 8.87a1 1 0 0 0-1.414 1.414l3.923 3.923a1 1 0 0 0 1.414 0l8.3-8.3A9.956 9.956 0 0 1 22 12a9.994 9.994 0 0 1-.466 3.026A2.49 2.49 0 0 0 20 14.5h-.5V14a2.5 2.5 0 0 0-5 0v.5H14a2.5 2.5 0 0 0 0 5h.5v.5c0 .578.196 1.11.526 1.534Z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <button wire:click="edit({{ $conferencia->id }})"
                                class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                    <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <button wire:click="confirmDelete({{ $conferencia->id }})"
                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white dark:bg-stone-800 p-4 rounded-lg shadow text-center text-stone-500 dark:text-stone-400">
                    No hay conferencias registradas
                </div>
            @endforelse
        </x-slot>

        <x-slot name="footer">
            {{ $conferencias->links() }}
        </x-slot>
    </x-table>

    <!-- Incluir el modal de crear/editar -->
    @if ($isOpen)
        @include('livewire.Conferencia.create')
    @endif

    <!-- Modal de detalles -->
    @if ($showDetails)
        @include('livewire.conferencia.detalles')
    @endif

    <!-- Modal de confirmación de eliminación -->
    <x-elegant-delete-modal wire:model="confirmingDelete" title="Eliminar Conferencia"
        message="¿Estás seguro de que deseas eliminar esta conferencia?"
        entityName="{{ $nombreAEliminar }}"
        confirmMethod="delete" cancelMethod="cancelarEliminacion" confirmText="Eliminar"
        cancelText="Cancelar" />
</div>
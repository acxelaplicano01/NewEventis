<div class="bg-white dark:bg-stone-800 rounded-lg shadow-md p-6">
    <div class="mb-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4">
            <h2 class="text-xl font-semibold text-stone-800 dark:text-stone-200">
                {{ __('Administración de Nacionalidades') }}
            </h2>

            <div class="flex flex-col sm:flex-row w-full sm:w-auto space-y-3 sm:space-y-0 sm:space-x-2">
                <div class="relative w-full sm:w-auto">
                    <x-input wire:model.live="search" type="text" placeholder="Buscar nacionalidades..."
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
                @can('mantenimiento.nacionalidades.crear')
                    <x-spinner-button wire:click="create()" loadingTarget="create()" :loadingText="__('Abriendo...')">
                        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        {{ __('Nueva Nacionalidad') }}
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
            ['key' => 'nombreNacionalidad', 'label' => 'Nacionalidad', 'sortable' => true],
            ['key' => 'acciones', 'label' => 'Acciones', 'class' => 'text-right'],
        ]"
        empty-message="No hay nacionalidades registradas"
        class="mt-6"
    >
        <x-slot name="desktop">
            @forelse($nacionalidades as $nac)
                <tr class="hover:bg-stone-50 dark:hover:bg-stone-700 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-stone-900 dark:text-stone-300">{{ $nac->id }}</td>
                    <td class="px-6 py-4 text-stone-900 dark:text-stone-300">{{ $nac->nombreNacionalidad }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end space-x-2">
                            <button wire:click="edit({{ $nac->id }})"
                                class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300">
                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                </svg>
                            </button>
                            <button wire:click="confirmDelete({{ $nac->id }})"
                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
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
                    <td colspan="3" class="px-6 py-4 text-center text-stone-500 dark:text-stone-400">
                        No hay nacionalidades registradas
                    </td>
                </tr>
            @endforelse
        </x-slot>

        <x-slot name="mobile">
            @forelse($nacionalidades as $nac)
                <div
                    class="bg-white dark:bg-stone-800 p-4 rounded-lg shadow-sm border border-stone-200 dark:border-stone-700">
                    <div class="flex justify-between items-center">
                        <div>
                            <span
                                class="bg-stone-100 dark:bg-stone-700 text-stone-800 dark:text-stone-300 px-2 py-1 rounded-full text-xs">
                                ID: {{ $nac->id }}
                            </span>
                            <h3 class="font-semibold text-stone-900 dark:text-stone-200 text-lg mt-2">
                                {{ $nac->nombreNacionalidad }}</h3>
                        </div>
                        <div class="flex space-x-2">
                            <button wire:click="edit({{ $nac->id }})"
                                class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300">
                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                </svg>
                            </button>
                            <button wire:click="confirmDelete({{ $nac->id }})"
                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
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
                    No hay nacionalidades registradas
                </div>
            @endforelse
        </x-slot>

        <x-slot name="footer">
            {{ $nacionalidades->links() }}
        </x-slot>
    </x-table>

    <!-- Incluir el modal de crear/editar -->
    @include('livewire.nacionalidad.create')

    <!-- Modal de confirmación de eliminación -->
    <x-elegant-delete-modal wire:model="confirmingDelete" title="Eliminar Nacionalidad"
        message="¿Estás seguro de que deseas eliminar esta nacionalidad?" entityName="{{ $nombreAEliminar }}"
        confirmMethod="delete" cancelMethod="cancelarEliminacion" confirmText="Eliminar"
        cancelText="Cancelar" />
</div>
<div x-data="{ showModal: false, message: '' }" @show-modal.window="showModal = true; message = $event.detail"
    class="flex flex-col min-h-screen">
    <div class="dark:bg-stone-900">
        <div>
            <div class="bg-white overflow-hidden sm:rounded-lg px-4 py-4 dark:bg-stone-800">
                @if (session()->has('message'))
                    @include('components.notification-alert', [
                        'type' => 'success',
                        'dismissible' => true,
                        'icon' => true,
                        'duration' => 5,
                        'slot' => session('message')
                    ])
                @endif
                <!-- Modal -->
                <div x-show="showModal" x-cloak @keydown.escape.window="showModal = false"
                    class="fixed inset-0 flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg shadow-lg p-8 dark:bg-stone-700">
                        <h2 class="text-lg font-medium text-stone-900 dark:text-white">Notificación</h2>
                        <p class="mt-4 text-sm text-stone-700 dark:text-stone-300" x-text="message"></p>
                        <div class="mt-6 flex justify-end">
                            <button @click="showModal = false"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Cerrar</button>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4">
                        <h2 class="text-xl font-semibold text-stone-800 dark:text-stone-200">
                            {{ __('Comprobantes de Pago') }}
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
                            <x-spinner-button wire:click="marcarTodos('Inscrito')" loadingTarget="marcarTodos('Inscrito')"
                                :loadingText="__('Marcando...')">
                                <svg class="w-6 h-6 text-stone-800 mr-1" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2"
                                        d="M15 4h3a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h3m0 3h6m-6 7 2 2 4-4m-5-9v4h4V3h-4Z" />
                                </svg>
                                Aceptar Todos
                            </x-spinner-button>
                            <x-spinner-button wire:click="descargarDiplomas({{ $evento_id }})" loadingTarget="descargarDiplomas({{ $evento_id }})"
                                :loadingText="__('Descargando...')">
                                Descargar diplomas
                                <svg class="w-6 h-6 text-stone-800 ms-2" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2"
                                        d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4" />
                                </svg>
                            </x-spinner-button>
                        </div>
                    </div>
                </div>
                <div class="relative overflow-x-auto sm:rounded-lg dark:bg-stone-800">
                    <x-table :columns="[
                            ['key' => 'id', 'label' => 'No.'],
                            ['key' => 'persona', 'label' => 'Persona'],
                            ['key' => 'evento', 'label' => 'Evento'],
                            ['key' => 'estado', 'label' => 'Estado'],
                            ['key' => 'acciones', 'label' => 'Acciones'],
                            ['key' => 'diploma', 'label' => 'Diploma'],
                        ]" empty-message="No hay coincidencias registradas">
                        <x-slot name="desktop">
                            @forelse($inscripciones as $inscripcion)
                                <tr class="border-b dark:border-stone-700 hover:bg-stone-50 dark:hover:bg-stone-700/50">
                                    <td class="px-6 py-4 font-medium text-stone-900 whitespace-nowrap dark:text-white">
                                        {{ $inscripcion->id }}
                                    </td>
                                    <td class="px-6 py-4 dark:text-white">
                                        {{ $inscripcion->user->nombre }} {{ $inscripcion->user->apellido }}
                                    </td>
                                    <td class="px-6 py-4 dark:text-white">
                                        {{ $inscripcion->evento->nombreevento }}
                                    </td>
                                    <td class="px-6 py-4 dark:text-white">
                                        @if($inscripcion->Status == "Pendiente")
                                            <span
                                                class="bg-yellow-100 text-yellow-800 text-xs font-bold me-2 px-3 py-1 rounded-full dark:bg-yellow-900 dark:text-yellow-300">Pendiente</span>
                                        @elseif($inscripcion->Status == "Rechazado")
                                            <span
                                                class="bg-red-100 text-red-800 text-xs font-bold me-2 px-3 py-1 rounded-full dark:bg-red-900 dark:text-red-300">Rechazado</span>
                                        @elseif($inscripcion->Status == "Inscrito")
                                            <span
                                                class="bg-green-100 text-green-800 text-xs font-bold me-2 px-3 py-1 rounded-full dark:bg-green-900 dark:text-green-300">Inscrito</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 dark:text-stone-900 text-center">
                                        <button data-modal-target="large-modal-{{$inscripcion->id}}"
                                            data-modal-toggle="large-modal-{{$inscripcion->id}}"
                                            class="mb-1 px-3 py-2 text-sm font-bold text-white inline-flex items-center bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 rounded-lg text-center dark:bg-green-700 dark:hover:bg-green-800 dark:focus:ring-green-800"
                                            type="button">
                                            <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                                viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M9 8h6m-6 4h6m-6 4h6M6 3v18l2-2 2 2 2-2 2 2 2-2 2 2V3l-2 2-2-2-2 2-2-2-2 2-2-2Z" />
                                            </svg>
                                            Ver comprobante
                                        </button>
                                    </td>
                                    <td class="px-6 py-4 dark:text-stone-900 text-center">
                                        @if($inscripcion->Status == 'Inscrito')
                                            <button wire:click="descargarDiploma({{ $inscripcion->id }})"
                                                class="mb-1 w-full px-3 py-2 text-sm font-bold text-white inline-flex items-center bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-center dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                                                Diploma
                                                <svg class="w-6 h-6 text-white ms-2 dark:text-white" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                                    viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4" />
                                                </svg>
                                            </button>
                                        @elseif($inscripcion->Status == 'Pendiente')
                                            <p class="text-black dark:text-white">Esperando...</p>
                                        @elseif($inscripcion->Status == 'Rechazado')
                                            <p class="text-black dark:text-white">No disponible</p>
                                        @endif
                                    </td>
                                    <!-- Extra Large Modal -->
                                    <div id="large-modal-{{$inscripcion->id}}" tabindex="-1"
                                        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                        <div class="relative w-full max-w-lg max-h-full">
                                            <div class="fixed inset-0 bg-black opacity-50"></div>
                                            <!-- Modal content -->
                                            <div class="relative bg-white rounded-lg shadow dark:bg-stone-700">
                                                <!-- Modal header -->
                                                <div
                                                    class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-stone-600">
                                                    <h3 class="text-xl font-medium text-stone-900 dark:text-white">
                                                        Comprobante de {{ $inscripcion->user->nombre }}
                                                        {{ $inscripcion->user->apellido }}
                                                    </h3>
                                                    <button type="button"
                                                        class="text-stone-400 bg-transparent hover:bg-stone-200 hover:text-stone-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-stone-600 dark:hover:text-white"
                                                        data-modal-hide="large-modal-{{$inscripcion->id}}">
                                                        <svg class="w-3 h-3" aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 14 14">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                        </svg>
                                                        <span class="sr-only">Close modal</span>
                                                    </button>
                                                </div>
                                                <!-- Modal body -->
                                                <div class="p-4 md:p-5 space-y-4">
                                                    <div>
                                                        @if($inscripcion->recibo)
                                                            <img class="h-auto max-w-full rounded-lg"
                                                                src="{{ asset('storage/' . $inscripcion->recibo->foto) }}"
                                                                alt="Comprobante">
                                                        @else
                                                            <p>Sin comprobante</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <!-- Modal footer -->
                                                <div
                                                    class="flex items-center p-4 md:p-5 space-x-3 rtl:space-x-reverse border-t border-stone-200 rounded-b dark:border-stone-600">
                                                    <div class="px-6 py-4 text-center">
                                                        <div class="flex space-x-2 justify-center">
                                                            <button wire:click="marcarComprobado({{$inscripcion->id}})"
                                                                onclick="handleButtonClick()"
                                                                class="px-3 py-1 w-28 h-10 bg-green-500 text-white rounded-lg hover:bg-green-600">Aceptar</button>
                                                            <button wire:click="rechazarComprobacion({{ $inscripcion->id}})"
                                                                onclick="handleButtonClick()"
                                                                class="px-3 py-1 w-28 h-10 bg-red-600 text-white rounded-lg hover:bg-red-700">Rechazar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-stone-500 dark:text-stone-400">
                                        No hay Comprobantes registrados
                                    </td>
                                </tr>
                            @endforelse
                        </x-slot>
                        <x-slot name="mobile">
                            @forelse($inscripciones as $inscripcion)
                                <div class="bg-white dark:bg-stone-800 rounded-lg shadow p-4 flex flex-col gap-2">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-xs font-bold text-stone-500 dark:text-stone-300">No.</span>
                                        <span
                                            class="font-semibold text-stone-900 dark:text-white">{{ $inscripcion->id }}</span>
                                    </div>
                                    <div>
                                        <span class="text-xs font-bold text-stone-500 dark:text-stone-300">Persona:</span>
                                        <span class="ml-1 text-stone-900 dark:text-white">{{ $inscripcion->user->nombre }}
                                            {{ $inscripcion->user->apellido }}</span>
                                    </div>
                                    <div>
                                        <span class="text-xs font-bold text-stone-500 dark:text-stone-300">Evento:</span>
                                        <span
                                            class="ml-1 text-stone-900 dark:text-white">{{ $inscripcion->evento->nombreevento }}</span>
                                    </div>
                                    <div>
                                        <span class="text-xs font-bold text-stone-500 dark:text-stone-300">Estado:</span>
                                        @if($inscripcion->Status == "Pendiente")
                                            <span
                                                class="ml-1 bg-yellow-100 text-yellow-800 text-xs font-bold px-3 py-1 rounded-full dark:bg-yellow-900 dark:text-yellow-300">Pendiente</span>
                                        @elseif($inscripcion->Status == "Rechazado")
                                            <span
                                                class="ml-1 bg-red-100 text-red-800 text-xs font-bold px-3 py-1 rounded-full dark:bg-red-900 dark:text-red-300">Rechazado</span>
                                        @elseif($inscripcion->Status == "Inscrito")
                                            <span
                                                class="ml-1 bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full dark:bg-green-900 dark:text-green-300">Inscrito</span>
                                        @endif
                                    </div>
                                    <div class="flex flex-col gap-2 mt-2">
                                        <button data-modal-target="large-modal-{{$inscripcion->id}}"
                                            data-modal-toggle="large-modal-{{$inscripcion->id}}"
                                            class="px-3 py-2 text-sm font-bold text-white inline-flex items-center bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 rounded-lg text-center dark:bg-green-700 dark:hover:bg-green-800 dark:focus:ring-green-800"
                                            type="button">
                                            <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                                viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M9 8h6m-6 4h6m-6 4h6M6 3v18l2-2 2 2 2-2 2 2 2-2 2 2V3l-2 2-2-2-2 2-2-2-2 2-2-2Z" />
                                            </svg>
                                            Ver comprobante
                                        </button>
                                        @if($inscripcion->Status == 'Inscrito')
                                            <button wire:click="descargarDiploma({{ $inscripcion->id }})"
                                                class="w-full px-3 py-2 text-sm font-bold text-white inline-flex items-center bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-center dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                                                Diploma
                                                <svg class="w-6 h-6 text-white ms-2 dark:text-white" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                                    viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4" />
                                                </svg>
                                            </button>
                                        @elseif($inscripcion->Status == 'Pendiente')
                                            <p class="text-black dark:text-white">Esperando...</p>
                                        @elseif($inscripcion->Status == 'Rechazado')
                                            <p class="text-black dark:text-white">No disponible</p>
                                        @endif
                                    </div>
                                    <!-- Extra Large Modal (igual que en desktop) -->
                                    <div id="large-modal-{{$inscripcion->id}}" tabindex="-1"
                                        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                        <div class="relative w-full max-w-lg max-h-full">
                                            <div class="fixed inset-0 bg-black opacity-50"></div>
                                            <div class="relative bg-white rounded-lg shadow dark:bg-stone-700">
                                                <div
                                                    class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-stone-600">
                                                    <h3 class="text-xl font-medium text-stone-900 dark:text-white">
                                                        Comprobante de {{ $inscripcion->user->nombre }}
                                                        {{ $inscripcion->user->apellido }}
                                                    </h3>
                                                    <button type="button"
                                                        class="text-stone-400 bg-transparent hover:bg-stone-200 hover:text-stone-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-stone-600 dark:hover:text-white"
                                                        data-modal-hide="large-modal-{{$inscripcion->id}}">
                                                        <svg class="w-3 h-3" aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 14 14">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                        </svg>
                                                        <span class="sr-only">Close modal</span>
                                                    </button>
                                                </div>
                                                <div class="p-4 md:p-5 space-y-4">
                                                    <div>
                                                        @if($inscripcion->recibo)
                                                            <img class="h-auto max-w-full rounded-lg"
                                                                src="{{ asset('storage/' . $inscripcion->recibo->foto) }}"
                                                                alt="Comprobante">
                                                        @else
                                                            <p>Sin comprobante</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div
                                                    class="flex items-center p-4 md:p-5 space-x-3 rtl:space-x-reverse border-t border-stone-200 rounded-b dark:border-stone-600">
                                                    <div class="px-6 py-4 text-center">
                                                        <div class="flex space-x-2 justify-center">
                                                            <button wire:click="marcarComprobado({{$inscripcion->id}})"
                                                                onclick="handleButtonClick()"
                                                                class="px-3 py-1 w-28 h-10 bg-green-500 text-white rounded-lg hover:bg-green-600">Aceptar</button>
                                                            <button wire:click="rechazarComprobacion({{ $inscripcion->id}})"
                                                                onclick="handleButtonClick()"
                                                                class="px-3 py-1 w-28 h-10 bg-red-600 text-white rounded-lg hover:bg-red-700">Rechazar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="bg-white dark:bg-stone-800 rounded-lg shadow p-4 text-center">
                                    No hay coincidencias registradas.
                                </div>
                            @endforelse
                        </x-slot>
                        <x-slot name="footer">
                            <br>
                            {{ $inscripciones->links() }}
                            <br>
                        </x-slot>
                    </x-table>
                    <br>
                    {{ $inscripciones->links() }}
                    <br>
                </div>
                @if (session()->has('error'))
                    @include('components.notification-alert', [
                        'type' => 'error',
                        'dismissible' => true,
                        'icon' => true,
                        'duration' => 8,
                        'slot' => session('error')
                    ])
                @elseif ($confirmingDelete)
                    <div id="rechazar-modal"
                        class="fixed z-50 inset-0 flex items-center justify-center overflow-y-auto ease-out duration-400">
                        <div class="fixed inset-0 transition-opacity">
                            <div class="absolute inset-0 bg-stone-500 opacity-75"></div>
                        </div>

                        <div class="bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                            role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold mb-4">Rechazar Comprobante</h3>
                                <p>¿Deseas rechazar este comprobante de pago de:
                                    "<strong>{{ $inscripcion->evento->nombreevento }}</strong>"? Esta acción no se puede
                                    deshacer.</p>
                                <div class="mt-4 flex justify-end">
                                    <button wire:click="$set('confirmingDelete', false)" onclick="handleButtonClick()"
                                        class="bg-stone-500 hover:bg-stone-600 text-white font-bold py-2 px-4 rounded mr-2">
                                        Cancelar
                                    </button>
                                    <button wire:click="delete" data-modal-hide="rechazar-modal"
                                        onclick="handleButtonClick()"
                                        class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                                        Confirmar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<script>
    function handleButtonClick() {
        setTimeout(() => {
            location.reload();
        }, 1000); // Espera 500 s para asegurarse de que la acción de Livewire se complete
    }
</script>
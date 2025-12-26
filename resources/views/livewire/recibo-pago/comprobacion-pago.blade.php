<div x-data="{ showModal: false, message: '' }" @show-modal.window="showModal = true; message = $event.detail"
    class="flex flex-col min-h-screen">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-white mb-7">
        Comprobantes de pago
    </h2>

    <div class="dark:bg-gray-900">
        <div class="">
            <div class="bg-white overflow-hidden border sm:rounded-lg px-4 py-4 dark:bg-gray-800">
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
                <!-- Modal -->
                <div x-show="showModal" x-cloak @keydown.escape.window="showModal = false"
                    class="fixed inset-0 flex items-center justify-center z-50">
                    <div class="bg-white rounded-lg shadow-lg p-8 dark:bg-gray-700">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white">Notificación</h2>
                        <p class="mt-4 text-sm text-gray-700 dark:text-gray-300" x-text="message"></p>
                        <div class="mt-6 flex justify-end">
                            <button @click="showModal = false"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Cerrar</button>
                        </div>
                    </div>
                </div>


                <div class="relative overflow-x-auto sm:rounded-lg dark:bg-gray-800">
                    <div class="flex justify-between">
                        <div
                            class="flex sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center mt-1 pb-2 w-3/5">
                            <div class="mr-2 ml-1">
                                <button wire:click="marcarTodos('Inscrito')"
                                    class="mb-1 w-full py-2 px-4 text-sm font-bold text-white inline-flex items-center bg-green-500 hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 rounded text-center dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-800">
                                    <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15 4h3a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h3m0 3h6m-6 7 2 2 4-4m-5-9v4h4V3h-4Z" />
                                    </svg>
                                    Aceptar Todos
                                </button>
                            </div>
                            <div class="mr-2">
                                <button wire:click="descargarDiplomas({{ $evento_id }})"
                                    class="mb-1 w-full py-2 px-4 text-sm font-bold text-white inline-flex items-center bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded text-center dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                                    Todos los diplomas
                                    <svg class="w-6 h-6 text-white ms-2 dark:text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4" />
                                    </svg>
                                </button>
                            </div>

                        </div>
                        <div class="lg:ml-96 sm:ml-2 md:ml-2  w-2/5">
                            <label for="table-search" class="sr-only dark:text-white">Buscar</label>
                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                    </svg>
                                </div>
                                <input wire:model.live="search" type="text" id="table-search-users"
                                    class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-yellow-500 focus:border-yellow-500 dark:bg-gray-700 dark:text-white"
                                    placeholder="Buscar...">
                            </div>
                        </div>
                    </div>

                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">No.</th>
                                <th scope="col" class="px-6 py-3">Persona</th>
                                <th scope="col" class="px-6 py-3">Evento</th>
                                <th scope="col" class="px-6 py-3">Estado</th>
                                <th scope="col" class="px-6 py-3">Acciones</th>
                                <th scope="col" class="px-6 py-3">Diploma</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($inscripciones as $inscripcion)
                            <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
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
                                <td class="px-6 py-4 dark:text-gray-900 text-center">
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
                                <td class="px-6 py-4 dark:text-gray-900 text-center">
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
                                </td>

                                <!-- Extra Large Modal -->
                                <div id="large-modal-{{$inscripcion->id}}" tabindex="-1"
                                    class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative w-full max-w-lg max-h-full">
                                        <div class="fixed inset-0 bg-black opacity-50"></div>
                                        <!-- Modal content -->
                                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                            <!-- Modal header -->
                                            <div
                                                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                                <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                                                    Comprobante de {{ $inscripcion->user->nombre }}
                                                    {{ $inscripcion->user->apellido }}
                                                </h3>
                                                <button type="button"
                                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
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
                                                class="flex items-center p-4 md:p-5 space-x-3 rtl:space-x-reverse border-t border-gray-200 rounded-b dark:border-gray-600">
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
                                <td colspan="5" class="px-6 py-4 text-center">No hay coincidencias registradas.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <br>
                    {{ $inscripciones->links() }}
                    <br>
                </div>
                @if (session()->has('error'))
                <div class="fixed z-50 inset-0 flex items-center justify-center overflow-y-auto ease-out duration-400">
                    <div class="fixed inset-0 transition-opacity">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>

                    <div class="bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                        role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Advertencia</h3>
                            <p>{{ session('error') }}</p>
                            <div class="mt-4 flex justify-end">
                                <button wire:click="$set('confirmingDelete', false)" onclick="handleButtonClick()"
                                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-2">
                                    Aceptar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @elseif ($confirmingDelete)
                <div id="rechazar-modal"
                    class="fixed z-50 inset-0 flex items-center justify-center overflow-y-auto ease-out duration-400">
                    <div class="fixed inset-0 transition-opacity">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
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
                                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded mr-2">
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
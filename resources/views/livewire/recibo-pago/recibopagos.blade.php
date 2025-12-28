<div x-data="{ showDeleteModal: @entangle('showDeleteModal'), selectedImage: null }">
    <h2 class="font-semibold text-xl text-stone-800 leading-tight dark:text-white mb-7">
        Comprobante para: {{ $evento->nombreevento }}
    </h2>

    <div class="dark:bg-stone-900">
        <div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4 dark:bg-stone-800">
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

                <form wire:submit.prevent="realizarPago" class="mb-4" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label class="block mb-1 dark:text-stone-300">Nombre completo:</label>
                        <input type="text" class="bg-stone-100 dark:bg-stone-700 dark:text-white w-full p-2 rounded"
                            disabled value="{{ $user->nombre }} {{ $user->apellido }}">
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1 dark:text-stone-300">Correo:</label>
                        <input type="email" class="bg-stone-100 dark:bg-stone-700 dark:text-white w-full p-2 rounded"
                            disabled value="{{ $user->correo }}">
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1 dark:text-stone-300">Comprobante:</label>
                        <input type="file" wire:model="foto"
                            @change="selectedImage = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null"
                            class="rounded-lg bg-stone-100 cursor-pointer dark:bg-stone-700 dark:text-white w-full p-2">
                        <p class="mt-1 text-sm text-stone-500 dark:text-stone-300" id="file_input_help">Solo se aceptan
                            formatos de imágenes</p>
                        @error('foto') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <!-- Muestra la imagen seleccionada -->
                    <div x-show="selectedImage" class="mt-4">
                        <h3 class="mb-2 dark:text-stone-300">Vista previa del comprobante:</h3>
                        <img :src="selectedImage" class="rounded-lg max-w-full h-auto"
                            alt="Vista previa del comprobante">
                    </div>

                    <button type="submit"
                        class="w-full text-sm font-medium bg-yellow-500 text-black rounded p-2 hover:bg-yellow-600">Subir
                        Comprobante</button>
                </form>
            </div>
        </div>
    </div>
</div>
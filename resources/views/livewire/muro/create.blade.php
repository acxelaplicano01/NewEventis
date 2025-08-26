<div id="crud-modal" tabindex="-1" aria-hidden="true"
    class="fixed inset-0 z-50 flex items-center justify-center w-full h-full">
    <!-- Fondo opaco -->
    <div class="fixed inset-0 bg-black opacity-60"></div>
    <div class="relative p-4 w-full max-w-xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-stone-800">
            <!-- Modal header -->
            <div
                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-stone-600 border-stone-200">
                <h3 class="text-lg font-semibold text-stone-900 dark:text-white">
                    {{ $publicacion_id ? 'Editar Publicación' : 'Nueva Publicación' }}
                </h3>
                <button type="button" wire:click="closeModal"
                    class="text-stone-400 bg-transparent hover:bg-stone-200 hover:text-stone-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-stone-600 dark:hover:text-white"
                    data-modal-toggle="crud-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form class="p-4 md:p-5" wire:submit.prevent="store">
                @csrf
                <article class="transition duration-350 ease-in-out">
                    <div class="flex flex-shrink-0 pb-0">
                        <a href="#" class="flex-shrink-0 group block">
                            <div class="flex items-center">
                                <div>
                                @if ($userperfil->profile_photo_path)
                                    <img class="w-10 h-10 object-cover rounded-full" src="/storage/{{$userperfil->profile_photo_path }}" alt="">
                                @else
                                    <img class="w-10 h-10 object-cover rounded-full"
                                        src="https://ui-avatars.com/api/?name={{ $userperfil->name }}&amp;color=000&amp;background=facc15">
                                @endif
                                </div>
                                <div class="ml-3">
                                    <p class="text-base leading-6 font-medium dark:text-white">
                                        {{$userperfil->nombre}}
                                        {{$userperfil->apellido}}
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="pl-11">
                        <textarea wire:model="descripcion" id="descripcion" rows="1" oninput="autoResize(this)"
                            class="block p-1.5 w-full resize-none text-sm text-stone-900 bg-none rounded-lg border border-none focus:ring-white focus:border-white dark:bg-stone-800 dark:border-stone-600 dark:placeholder-stone-400 dark:text-white dark:focus:ring-stone-700 dark:focus:border-gary-700"
                            placeholder="¿Qué novedades tienes?"></textarea>
                        @if ($foto)
                            <div class="md:flex-shrink pr-6 pt-2">
                                <div class="bg-cover bg-no-repeat bg-center rounded-lg w-full h-64"
                                    style="height: 200px; background-image: url({{ is_string($foto) ? asset($foto) : $foto->temporaryUrl() }})">
                                    <img src="{{ is_string($foto) ? asset($foto) : $foto->temporaryUrl() }}"
                                        class="object-cover opacity-0 cursor-pointer transition duration-300 ease-in-out w-full h-full">
                                </div>
                            </div>
                        @endif

                        <div class="flex items-center mt-6 justify-between">
                            <div class="flex ps-0 space-x-1 rtl:space-x-reverse sm:ps-2">
                                <div class="file-upload-container">
                                    <!-- Label como ícono para cargar el archivo -->
                                    <label for="dropzone-file"
                                        class="inline-flex justify-center items-center p-2 text-stone-500 rounded-sm cursor-pointer hover:text-stone-900 hover:bg-stone-100 dark:text-stone-400 dark:hover:text-white dark:hover:bg-stone-600">
                                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                            viewBox="0 0 20 18">
                                            <path
                                                d="M18 0H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm4.376 10.481A1 1 0 0 1 16 15H4a1 1 0 0 1-.895-1.447l3.5-7A1 1 0 0 1 7.468 6a.965.965 0 0 1 .9.5l2.775 4.757 1.546-1.887a1 1 0 0 1 1.618.1l2.541 4a1 1 0 0 1 .028 1.011Z" />
                                        </svg>
                                        <span class="sr-only">Upload image</span>
                                    </label>
                                    <!-- Input file oculto -->
                                    <input id="dropzone-file" type="file" class="hidden" wire:model="foto"/>
                                </div>

                            </div>
                            
                            <button wire:click.prevent="store()" type="submit" data-modal-hide="crud-modal"
                                wire:loading.attr="disabled" wire:loading.class="bg-stone-300 cursor-not-allowed"
                                class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-yellow-500 rounded-lg focus:ring-4 hover:bg-yellow-600"
                                >
                                <!-- Texto dinámico -->
                                {{ $publicacion_id ? 'Actualizar' : 'Publicar' }}
                                <!-- Mostrar el ícono de carga cuando está en proceso -->
                                <div wire:loading>
                                    <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-stone-200 animate-spin dark:text-stone-600"
                                        viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                            fill="currentColor" />
                                        <path
                                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                            fill="#ffff" />
                                    </svg>
                                </div>
                            </button>

                            @error('foto')                                
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </article>
            </form>
        </div>
    </div>
</div>
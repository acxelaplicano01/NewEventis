<div>
    <div class="content-wrapper">
        <h2 class="font-semibold text-xl text-stone-800 leading-tight dark:text-white mb-2 ml-2">
            Eventos Disponibles
        </h2>
        @if($Eventos->isEmpty())
            <div class="p-4 mb-4 text-yellow-800 border border-yellow-300 rounded-lg bg-yellow-50 dark:bg-stone-800 dark:text-yellow-500 dark:border-yellow-800"
                role="alert">
                <div class="flex items-center">
                    <svg class="flex-shrink-0 w-4 h-4 me-2" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                    </svg>
                    <h3 class="text-lg font-bold">No hay eventos disponibles.</h3>
                </div>
                <p>Por el momento no hay eventos disponibles, por favor intente más tarde.</p>
            </div>
        @else
                    <section class="py-2 sm:py-2 lg:py-2">
                        <div class="px-2 mx-auto mb-24 sm:px-2 lg:px-2 max-w-7xl">
                            <div class="grid max-w-md grid-cols-1 gap-6 mx-auto mt-4 lg:mt-8 lg:grid-cols-3 lg:max-w-full">
                                @foreach($eventos as $evento)
                                <div class="flex flex-col overflow-hidden bg-white dark:bg-stone-800 transform transition duration-300 hover:scale-105 rounded-xl shadow-xl">
                        <div class="flex flex-col justify-between flex-1">
                            <div class="relative">
                                <div class="block aspect-w-4 aspect-h-3">
                                    <img class="object-cover w-full h-56"
                                        src="{{ asset('storage/' . $evento->logo) }}"
                                        alt="Arte del evento" />
                                </div>

                                <div class="absolute top-4 left-4">
                                    <span
                                        class="px-4 py-2 text-xs font-semibold tracking-widest text-yellow-900 uppercase bg-yellow-500 dark:bg-yellow-900 dark:text-yellow-300 rounded-full">
                                            {{$evento->modalidad->modalidad}} 
                                    </span>
                                </div>
                                </div>
                                    @php
    $inscripcion = Auth::user()->inscripciones()->where('IdEvento', $evento->id)->first();
    $estadoInscripcion = $inscripcion ? $inscripcion->Status : null;
    $yaInscrito = $estadoInscripcion === 'Inscrito';
                                    @endphp
                                <div class="p-5">
                                    @if ($evento->estado === 'Pagado')
                                        <span class="inline-flex px-4 py-2 text-xs font-semibold tracking-widest uppercase rounded-full {{ $estadoInscripcion === 'Inscrito' ? 'text-green-600 bg-green-100 dark:bg-green-900 dark:text-green-300' : 'text-red-600 bg-red-100' }}"> 
                                            {{ $estadoInscripcion ?? 'No inscrito' }} 
                                        </span>
                                    @endif

                                    @if ($estadoInscripcion === 'Inscrito' || $evento->estado === 'Gratis')
                                        <a href="{{ route('gafete', ['evento' => $evento->id]) }}">
                                            <span class="inline-flex px-4 py-2 text-xs font-semibold tracking-widest uppercase rounded-full text-yellow-500 bg-yellow-100 dark:bg-yellow-900 dark:text-yellow-300">Gafete</span>
                                        </a>
                                    @endif
                                        <span class="inline-flex px-4 py-2 text-xs font-semibold tracking-widest uppercase rounded-full text-yellow-500 bg-yellow-100 dark:bg-yellow-900 dark:text-yellow-300">{{$evento->estado}}</span>
                                        <span class="block mt-4 text-sm font-semibold tracking-widest text-stone-500 dark:text-stone-400">
                                    <?php
    // Obtener el timestamp de la fecha
    $timestamp = strtotime($evento->fechainicio);

    // Obtener el día de la semana en formato textual completo (por ejemplo, "Sunday")
    $diaSemana = date('l', $timestamp);

    // Traducir el día de la semana al español
    $diasSemana = [
        'Monday' => 'Lunes',
        'Tuesday' => 'Martes',
        'Wednesday' => 'Miércoles',
        'Thursday' => 'Jueves',
        'Friday' => 'Viernes',
        'Saturday' => 'Sábado',
        'Sunday' => 'Domingo'
    ];

    $diaSemanaEsp = $diasSemana[$diaSemana];
                                    ?>
                                        {{$diaSemanaEsp}}, {{ \Carbon\Carbon::parse($evento->fechainicio)->format('d \d\e F \d\e Y') }} </span>
                                    <p class="text-2xl font-semibold">
                                        <a 
                                        href="{{($evento->estado === 'Pagado' && !$yaInscrito)
                                            ? route('subir-comprobante', ['evento' => $evento->id])
                                            : route('reporteEvento', ['evento' => $evento->id]) }}"
                                            class="text-black dark:text-stone-300">{{$evento->nombreevento}} 
                                        </a>
                                    </p>
                                    <p class="mt-2 text-base leading-relaxed text-stone-600 dark:text-stone-400 truncate">{{$evento->descripcion}}</p>
                                    </div>

                                    <div class="border-t border-stone-200 dark:border-stone-700">
                                        <div class="flex">
                                            <div class="flex items-center flex-1 pl-6 pr-1 py-5 w-16">
                                               <button data-popover-target="popover-company-profile-{{$evento->id}}" type="button">
                                               <a href="{{route('muro', ['userperfil' => $evento->usuario->id])}}" class="hover:underline"> 
                                               <img class="object-cover w-9 h-9 rounded-full"
                                                    src="https://cdn.rareblocks.xyz/collection/celebration/images/blog/3/avatar-3.jpg"
                                                    alt="" /></a>
                                               </button>
                                               <span
                                                    class="flex-1 block min-w-0 ml-3 text-base font-semibold text-stone-900 dark:text-stone-300 truncate">
                                                        {{ $evento->usuario->nombre }} {{ $evento->usuario->apellido }}<p class="fecha-creacion font-medium">{{ $evento->created_at->diffForHumans() }}</p></span>
                                                        <div data-popover id="popover-company-profile-{{$evento->id}}" role="tooltip"
            class="absolute z-10 invisible inline-block text-sm text-stone-500 transition-opacity duration-300 bg-white border border-stone-200 rounded-lg shadow-sm opacity-0 w-80 dark:text-stone-400 dark:bg-stone-800 dark:border-stone-600">
            <div class="p-3">
                <div class="flex">
                    <div class="me-3 shrink-0">
                        <a href="#" class="block p-2 bg-stone-100 rounded-lg dark:bg-stone-700">
                            <img class="w-8 h-8 rounded-full" src="https://flowbite.com/docs/images/logo.svg"
                                alt="Flowbite logo">
                        </a>
                    </div>
                    <div>
                        <p class="mb-1 text-base font-semibold leading-none text-stone-900 dark:text-white">
                            <a href="{{route('muro', ['userperfil' => $evento->usuario->id])}}" class="hover:underline"> {{ $evento->usuario->nombre }} {{ $evento->usuario->apellido }}</a>
                        </p>
                        <p class="mb-3 text-sm font-normal">
                        {{ $evento->usuario->name }}
                        </p>
                        <p class="mb-4 text-sm">{{ $evento->usuario->descripcion }}</p>
                        <ul class="text-sm">
                            <li class="flex items-center mb-2">
                                <span class="me-2 font-semibold text-stone-400">
                                    <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 21 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M6.487 1.746c0 4.192 3.592 1.66 4.592 5.754 0 .828 1 1.5 2 1.5s2-.672 2-1.5a1.5 1.5 0 0 1 1.5-1.5h1.5m-16.02.471c4.02 2.248 1.776 4.216 4.878 5.645C10.18 13.61 9 19 9 19m9.366-6h-2.287a3 3 0 0 0-3 3v2m6-8a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                </span>
                                <a href="#" class="text-yellow-500 dark:text-yellow-600 hover:underline">{{ $evento->usuario->pagina }}</a>
                            </li>
                            <li class="flex items-start mb-2">
                                <span class="me-2 font-semibold text-stone-400">
                                    <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" viewBox="0 0 20 18">
                                        <path
                                            d="M17.947 2.053a5.209 5.209 0 0 0-3.793-1.53A6.414 6.414 0 0 0 10 2.311 6.482 6.482 0 0 0 5.824.5a5.2 5.2 0 0 0-3.8 1.521c-1.915 1.916-2.315 5.392.625 8.333l7 7a.5.5 0 0 0 .708 0l7-7a6.6 6.6 0 0 0 2.123-4.508 5.179 5.179 0 0 0-1.533-3.793Z" />
                                    </svg>
                                </span>
                                <span class="-mt-1">4,567,346 people like this including 5 of your friends</span>
                            </li>
                        </ul>
                        <div class="flex mb-3 -space-x-3 rtl:space-x-reverse">
                            <img class="w-8 h-8 border-2 border-white rounded-full dark:border-stone-800"
                                src="/docs/images/people/profile-picture-5.jpg" alt="">
                            <img class="w-8 h-8 border-2 border-white rounded-full dark:border-stone-800"
                                src="/docs/images/people/profile-picture-2.jpg" alt="">
                            <img class="w-8 h-8 border-2 border-white rounded-full dark:border-stone-800"
                                src="/docs/images/people/profile-picture-3.jpg" alt="">
                            <a class="flex items-center justify-center w-8 h-8 text-xs font-medium text-white bg-stone-400 border-2 border-white rounded-full hover:bg-stone-500 dark:border-stone-800"
                                href="#">+3</a>
                        </div>
                        <div class="flex">
                            <button type="button"
                                class="inline-flex items-center justify-center w-full px-5 py-2 me-2 text-sm font-medium text-stone-900 bg-white border border-stone-200 rounded-lg focus:outline-none hover:bg-stone-100 hover:text-yellow-600 focus:z-10 focus:ring-4 focus:ring-stone-200 dark:focus:ring-stone-700 dark:bg-stone-800 dark:text-stone-400 dark:border-stone-600 dark:hover:text-white dark:hover:bg-stone-700"><svg
                                    class="w-3.5 h-3.5 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor" viewBox="0 0 18 18">
                                    <path
                                        d="M3 7H1a1 1 0 0 0-1 1v8a2 2 0 0 0 4 0V8a1 1 0 0 0-1-1Zm12.954 0H12l1.558-4.5a1.778 1.778 0 0 0-3.331-1.06A24.859 24.859 0 0 1 6 6.8v9.586h.114C8.223 16.969 11.015 18 13.6 18c1.4 0 1.592-.526 1.88-1.317l2.354-7A2 2 0 0 0 15.954 7Z" />
                                </svg>Seguir</button>
                            <button id="dropdown-button" data-dropdown-toggle="dropdown-menu-{{$evento->id}}" data-dropdown-placement="right"
                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-stone-900 bg-white border border-stone-200 rounded-lg shrink-0 focus:outline-none hover:bg-stone-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-stone-200 dark:focus:ring-stone-700 dark:bg-stone-800 dark:text-stone-400 dark:border-stone-600 dark:hover:text-white dark:hover:bg-stone-700"
                                type="button">
                                <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor" viewBox="0 0 16 3">
                                    <path
                                        d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z" />
                                </svg>
                            </button>
                        </div>
                        <div id="dropdown-menu-{{$evento->id}}"
                            class="z-10 hidden bg-white divide-y divide-stone-100 rounded-lg shadow w-44 dark:bg-stone-700">
                            <ul class="py-2 text-sm text-stone-700 dark:text-stone-200" aria-labelledby="dropdown-button">
                                <li>
                                    <a href="#"
                                        class="block px-4 py-2 hover:bg-stone-100 dark:hover:bg-stone-600 dark:hover:text-white">Report
                                        this page</a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="block px-4 py-2 hover:bg-stone-100 dark:hover:bg-stone-600 dark:hover:text-white">Add
                                        to favorites</a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="block px-4 py-2 hover:bg-stone-100 dark:hover:bg-stone-600 dark:hover:text-white">Block
                                        this page</a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="block px-4 py-2 hover:bg-stone-100 dark:hover:bg-stone-600 dark:hover:text-white">Invite
                                        users</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div data-popper-arrow></div>
        </div>
                                            </div>

                                            <a href="{{ route('reporteEvento', ['evento' => $evento->id]) }}"
                                                class="inline-flex items-center flex-shrink-0 px-4 py-5 text-base font-semibold transition-all duration-200 bg-white dark:bg-stone-800 border-l border-stone-200 dark:border-stone-700 hover:bg-yellow-500 dark:hover:bg-yellow-600 text-stone-800 dark:text-stone-300 hover:text-white">
                                                 Evento
                                                <svg class="w-5 h-5 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                    d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                @endforeach
                            </div>
                        </div>
                    </section>
                    <br>
                        {{ $Eventos->links() }}
                    <br>
        @endif
</div>
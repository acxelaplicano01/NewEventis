<div>
    <x-layouts.reportes>
    <div class="relative">
        <section class="bg-center bg-no-repeat bg-gray-700 bg-blend-multiply"
            style="background-image: url('{{ asset('storage/'. $evento->logo) }}');">
           <div class="flex">
                <a  href="{{ route('eventoVista') }}">
                    <svg class="w-8 h-6 m-4 text-white dark:text-white hover:text-yellow-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4"/>
                    </svg>
                </a>
           </div>
            <div class="px-4 mx-auto max-w-screen-xl text-center py-12 lg:py-20">
                <p class="mb-8 text-lg font-normal text-gray-300 lg:text-xl sm:px-16 lg:px-48">
                    {{ $evento->organizador }}
                </p>
                <h1 class="mb-8 text-4xl font-extrabold tracking-tight leading-none text-white md:text-5xl lg:text-6xl">
                    {{ $evento->nombreevento }}
                </h1>

                <div class="mb-8">
                    <div class="flex items-center justify-center">
                        <div class="w-20 h-20 -mr-6 overflow-hidden bg-gray-300 rounded-full">
                            <img class="object-cover w-full h-full"
                                src="https://cdn.rareblocks.xyz/collection/celebration/images/cta/2/female-avatar-1.jpg"
                                alt="" />
                        </div>

                        <div class="relative overflow-hidden bg-gray-300 border-8 border-yellow-500 dark:border-yellow-600 rounded-full w-28 h-28">
                            <img class="object-cover w-full h-full"
                                 src="{{ asset('storage/'. $evento->logo)}}"
                                alt="" />
                        </div>

                        <div class="w-20 h-20 -ml-6 overflow-hidden bg-gray-300 rounded-full">
                            <img class="object-cover w-full h-full"
                                src="https://cdn.rareblocks.xyz/collection/celebration/images/cta/2/female-avatar-2.jpg"
                                alt="" />
                        </div>
                    </div>
                    <h2 class="mt-8 text-3xl font-bold leading-tight text-white lg:mt-12 sm:text-4xl lg:text-5xl">
                        Se han inscrito <span class="border-b-8 border-yellow-300"> {{ $evento->inscripciones->count() }}</span> participantes</h2>
                </div>

                <div class="flex flex-col space-y-4 mb-12 sm:flex-row sm:justify-center sm:space-y-0">
                @if ($evento->estado === 'Pagado')
                @php
    $yaInscrito = Auth::user()->inscripciones()
        ->where('IdEvento', $evento->id)
        ->exists();
                @endphp
                @if ($yaInscrito)
                <button data-modal-target="inscrito-modal-{{ $evento->id }}" data-modal-toggle="inscrito-modal-{{ $evento->id }}"
                        class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-yellow-500 hover:bg-yellow-600 focus:ring-4 focus:ring-yellow-200 dark:focus:ring-yellow-800">
                        Inscribirse
                        <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                </button>
                @else
                <button data-modal-target="progress-modal-{{ $evento->id }}" data-modal-toggle="progress-modal-{{ $evento->id }}"
                        class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-yellow-500 hover:bg-yellow-600 focus:ring-4 focus:ring-yellow-200 dark:focus:ring-yellow-800">
                        Inscribirse
                        <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                </button>
                    @endif
                    @endif
                    <!-- Modal para ya inscrito -->
                    <div id="inscrito-modal-{{ $evento->id }}" tabindex="-1" aria-hidden="true"
                                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                        <!-- Fondo opaco -->
                                        <div class="fixed inset-0 bg-black opacity-50"></div>
                                        <div class="relative p-4 w-full max-w-md max-h-full mx-auto">
                                            <!-- Modal content -->
                                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                <div class="p-4 md:p-5">
                                                    <h3 class="mb-1 text-xl font-bold text-gray-900 dark:text-white">
                                                        Ya estas inscrito a "{{ $evento->nombreevento }}"
                                                    </h3>
                                                    <p class="text-gray-500 dark:text-gray-400 mb-6">Si tu comprobante de pago ya
                                                        fue
                                                        aceptado ya debes poder inscribirte a las conferencias de este evento.</p>
                                                    <!-- Modal footer -->
                                                    @php
$inscripcion = Auth::user()->inscripciones()->where('IdEvento', $evento->id)->first();
$estadoInscripcion = $inscripcion ? $inscripcion->Status : null;
$yaInscrito = $estadoInscripcion === 'Inscrito';
                            @endphp
                                                    <div class="flex items-center mt-6 space-x-4 rtl:space-x-reverse">
                                                        <button data-modal-hide="inscrito-modal-{{ $evento->id }}"
                                                            type="button"
                                                            class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-yellow-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Cerrar</button>
                                                        @if ($estadoInscripcion == 'Inscrito')
                                                            <a href="{{ route('vistaconferencia', ['evento' => $evento->id]) }}"
                                                                data-modal-hide="inscrito-modal-{{ $evento->id }}" type="button"
                                                                class="text-white bg-yellow-600 hover:bg-yellow-700 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">Ver
                                                                conferencias</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="progress-modal-{{ $evento->id}}" tabindex="-1" aria-hidden="true"
                            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="fixed inset-0 bg-black opacity-50"></div>
                            <div class="relative p-4 w-full max-w-md max-h-full">
                                <!-- Modal content -->
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <div class="p-4 md:p-5">
                                        <h3 class="mb-1 text-xl font-bold text-gray-900 dark:text-white">
                                            "{{$evento->nombreevento}}" tiene un costo
                                        </h3>
                                        <div class="payment-section p-4 bg-gray-100 rounded-lg shadow-lg dark:bg-gray-800">
                                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Realiza tu pago</h3>
                                            <ul class="list-disc pl-5 text-gray-700 dark:text-gray-300">
                                                <li>
                                                    Tesorería UNAH con código de pago <strong>1078</strong>
                                                </li>
                                                <li>
                                                    Pago en Banco Lafise con código de pago <strong>1078</strong>
                                                </li>
                                                <li class="mt-2">
                                                    <span>Pago en línea:</span>
                                                    <a href="https://pagos.unah.edu.hn/#/productos/101" target="_blank"
                                                        class="inline-flex items-center px-4 py-2 mt-2 text-sm font-medium text-white bg-yellow-600 rounded-lg shadow hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 dark:bg-yellow-500 dark:hover:bg-yellow-600">
                                                        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                            stroke-width="2" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M17 9V7a4 4 0 1 0-8 0v2M5 9h14a2 2 0 0 1 2 2v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2zm6 3v4m-3-2h6" />
                                                        </svg>
                                                        Pagar en línea
                                                    </a>
                                                </li>
                                            </ul>
                                            <p class="mt-4 text-gray-600 dark:text-gray-400">Por favor, sube tu comprobante de pago para completar tu inscripción.</p>
                                        </div>

                                            <!-- Modal footer -->
                                        <div class="flex items-center mt-6 space-x-4 rtl:space-x-reverse">
                                            <button data-modal-hide="progress-modal-{{ $evento->id }}" type="button"
                                                class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-yellow-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Cerrar</button>
                                            <a href="{{ route('recibo', ['evento' => $evento->id]) }}"
                                                data-modal-hide="progress-modal-{{ $evento->id }}" type="button"
                                                class="text-white bg-yellow-600 hover:bg-yellow-700 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">Subir
                                                Comprobante</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <a href="#conferencias"
                        class="inline-flex justify-center hover:text-gray-900 items-center py-3 px-5 sm:ms-4 text-base font-medium text-center text-white rounded-lg border border-white hover:bg-gray-100 focus:ring-4 focus:ring-gray-400">
                        Conferencias
                    </a>
                </div>
            </div>
        </section>
        
        <dl id="countdown"
            class="hidden lg:grid px-4 mx-auto max-w-screen-xl text-center py-8 lg:py-8 absolute inset-x-0 transform -translate-y-1/2 grid-cols-1 gap-4 divide-y divide-yellow-100 bg-slate-50 sm:mt-8 sm:grid-cols-2 sm:divide-x sm:divide-y-0 lg:grid-cols-4 shadow-2xl rounded-3xl shadow-gray-500">
            <div class="flex flex-col px-4 py-8 text-center">
                <dt class="order-last text-lg font-medium text-gray-900">Días</dt>
                <dd id="days" class="text-4xl font-extrabold text-yellow-500 md:text-5xl">0</dd>
            </div>
            <div class="flex flex-col px-4 py-8 text-center">
                <dt class="order-last text-lg font-medium text-gray-900">Horas</dt>
                <dd id="hours" class="text-4xl font-extrabold text-yellow-500 md:text-5xl">0</dd>
            </div>
            <div class="flex flex-col px-4 py-8 text-center">
                <dt class="order-last text-lg font-medium text-gray-900">Minutos</dt>
                <dd id="minutes" class="text-4xl font-extrabold text-yellow-500 md:text-5xl">0</dd>
            </div>
            <div class="flex flex-col px-4 py-8 text-center">
                <dt class="order-last text-lg font-medium text-gray-900">Segundos</dt>
                <dd id="seconds" class="text-4xl font-extrabold text-yellow-500 md:text-5xl">0</dd>
            </div>
        </dl>

        <script>
            // Fechas de inicio y fin del evento
            var eventStartDate = new Date("{{ $evento->fechainicio }}");
            var eventEndDate = new Date("{{ $evento->fechafinal }}");

            // Actualizar la cuenta regresiva cada segundo
            var countdownInterval = setInterval(function () {
                var now = new Date(); // Fecha y hora actuales

                // Calcular distancias
                var distanceToStart = eventStartDate - now; // Tiempo restante para el inicio
                var distanceToEnd = eventEndDate - now; // Tiempo restante para el final

                // Si el evento ya terminó
                if (distanceToEnd < 0) {
                    clearInterval(countdownInterval);
                    document.getElementById("countdown").innerHTML = `
                        <h1 class="text-4xl font-bold text-gray-900 mb-4">¡El evento ha terminado!</h1>
                        <p class="text-lg text-gray-700 mb-6">Gracias por participar. ¡Esperamos verte en el próximo evento!</p>
                        <div class="flex justify-center">
                            <svg class="w-16 h-16 text-red-500 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"></path>
                            </svg>
                        </div>
                        <div class="mt-6">
                            <a href="#conferencias" class="inline-flex items-center px-6 py-3 text-lg font-medium text-white bg-yellow-600 rounded-lg shadow hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                                Ver conferencias
                            </a>
                        </div>`;
                    return;
                }

                // Si el evento es hoy y aún no ha terminado
                if (distanceToStart <= 0 && distanceToEnd > 0) {
                    clearInterval(countdownInterval);
                    document.getElementById("countdown").innerHTML = `
                        <h1 class="text-4xl font-bold text-gray-900 mb-4">¡Hoy es el evento!</h1>
                        <p class="text-lg text-gray-700 mb-6">Estamos emocionados de que estés aquí. ¡Disfrútalo!</p>
                        <div class="flex justify-center">
                            <svg class="w-16 h-16 text-green-500 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"></path>
                            </svg>
                        </div>
                        <div class="mt-6">
                            <a href="#conferencias" class="inline-flex items-center px-6 py-3 text-lg font-medium text-white bg-yellow-600 rounded-lg shadow hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                                Ir a las conferencias
                            </a>
                        </div>`;
                    return;
                }

                // Si el evento es próximo (aún no comienza)
                if (distanceToStart > 0) {
                    // Calcular días, horas, minutos y segundos
                    var days = Math.floor(distanceToStart / (1000 * 60 * 60 * 24));
                    var hours = Math.floor((distanceToStart % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((distanceToStart % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distanceToStart % (1000 * 60)) / 1000);

                    // Mostrar los resultados en los elementos correspondientes
                    document.getElementById("days").innerHTML = days;
                    document.getElementById("hours").innerHTML = hours;
                    document.getElementById("minutes").innerHTML = minutes;
                    document.getElementById("seconds").innerHTML = seconds;
                }
            }, 1000);
        </script>

        <section class="py-10 bg-gray-50 dark:bg-gray-900 sm:py-16 lg:py-24">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="max-w-xl mt-24 mx-auto text-center">
                    <p class="text-sm font-semibold tracking-widest text-yellow-500 dark:text-yellow-400 uppercase">Este evento
                        es
                        {{$evento->estado}}
                    </p>
        
                    <h2 class="mt-6 text-3xl font-bold leading-tight text-black dark:text-gray-100 sm:text-4xl lg:text-5xl">
                        Acerca del
                        evento</h2>
                </div>
        
                <div class="grid items-center grid-cols-1 mt-12 gap-y-10 lg:grid-cols-5 sm:mt-20 gap-x-4">
                    <div class="space-y-8 lg:pr-16 xl:pr-24 lg:col-span-2 lg:space-y-12">
                        <div class="flex items-start">
                            <svg class="flex-shrink-0 w-9 h-9 text-green-600 dark:text-green-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 6h-8m8 4H6m12 4h-8m8 4H6" />
                            </svg>
        
                            <div class="ml-5">
                                <h3 class="text-xl font-semibold text-black dark:text-gray-100">Descripción</h3>
                                <p class="mt-3 text-base text-gray-600 dark:text-gray-400">{{$evento->descripcion}}</p>
                            </div>
                        </div>
        
                        <div class="flex items-start">
                            <svg class="flex-shrink-0 w-9 h-9 text-blue-500 dark:text-blue-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
        
                            <div class="ml-5">
                                <h3 class="text-xl font-semibold text-black dark:text-gray-100">Hora</h3>
                                <p class="mt-3 text-base text-gray-600 dark:text-gray-400">
                                    {{ \Carbon\Carbon::parse($evento->fechainicio)->locale('es')->isoFormat('D [de] MMMM [de] YYYY ') }}Hora:
                                    <strong>{{ \Carbon\Carbon::parse($evento->horaInicio)->format('g:i a') }}</strong>
                                </p>
                                <p class="mt-3 text-base text-gray-600 dark:text-gray-400">
                                    {{ \Carbon\Carbon::parse($evento->fechafinal)->locale('es')->isoFormat('D [de] MMMM [de] YYYY ') }}Hora:
                                    <strong>{{ \Carbon\Carbon::parse($evento->horafin)->format('g:i a') }}</strong>
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <svg class="flex-shrink-0 w-9 h-9 text-red-500 dark:text-red-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.8 13.938h-.011a7 7 0 1 0-11.464.144h-.016l.14.171c.1.127.2.251.3.371L12 21l5.13-6.248c.194-.209.374-.429.54-.659l.13-.155Z" />
                            </svg>
        
                            <div class="ml-5">
                                <h3 class="text-xl font-semibold text-black dark:text-gray-100">Localidad / Modalidad</h3>
                                <p class="mt-3 text-base text-gray-600 dark:text-gray-400">
                                    {{$evento->localidad->localidad}}
                                </p>
                                <p class="mt-3 text-base text-gray-600 dark:text-gray-400">
                                    {{$evento->modalidad->modalidad}}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <svg class="flex-shrink-0 w-9 h-9 text-yellow-500 dark:text-yellow-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7H5a2 2 0 0 0-2 2v4m5-6h8M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m0 0h3a2 2 0 0 1 2 2v4m0 0v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-6m18 0s-4 2-9 2-9-2-9-2m9-2h.01" />
                            </svg>
        
                            <div class="ml-5">
                                <h3 class="text-xl font-semibold text-black dark:text-gray-100">¿Cómo contactar al organizador?
                                </h3>
                                <p class="mt-4 text-base text-gray-700 dark:text-gray-400">
                                    Visita nuestro sitio web: <a href="#"
                                        class="text-blue-600 dark:text-blue-400 hover:underline">dreamworldwide.net</a>.
                                    Para más detalles, consulta nuestra sección de preguntas frecuentes.
                                </p>
                            </div>
                        </div>
                    </div>
                    <!--<div class="w-full h-[200px] md:h-[450px] ">
                        <div class="fluid-width-video-wrapper" style="padding-top: 36%;"><iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4019.0807429007573!2d-87.1941431248207!3d13.313927907280377!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8f703d1a0569519d%3A0x45b3a77ef135ae3a!2sHotel%20Gualiqueme!5e1!3m2!1ses!2shn!4v1731765668105!5m2!1ses!2shn"
                                class="w-full h-full border-0" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade" id="fitvid0">
                            </iframe></div>
                    </div>-->
                    <div class="lg:col-span-3">
                        <img class="w-full rounded-lg shadow-xl"
                        src="{{ asset('storage/'. $evento->diploma->Plantilla)}}" alt="Diploma" />
                    </div>
                </div>
            </div>
        </section>
        </div>


        <section id="conferencias" class="py-10 bg-white dark:bg-gray-900 sm:py-16 lg:py-24">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        
                <div class="max-w-2xl mx-auto text-center mb-16">
                    <h2 class="text-3xl font-bold leading-tight text-yellow-500 dark:text-yellow-700 sm:text-4xl lg:text-5xl">
                        Conferencias <br><span class="text-gray-800 dark:text-gray-100">{{$evento->nombreevento}}</span>
                    </h2>
                </div>
                <div class="keen-slider__slide grid grid-cols-1 gap-6 lg:gap-10 sm:grid-cols-2 md:grid-cols-3">
                    @foreach ($conferencias as $conferencia)
                        <div class="flex flex-col bg-white dark:bg-gray-800 border dark:border-gray-700 rounded-xl">
                            <div class="block relative aspect-w-4 aspect-h-3">
                                <!-- Le agregaremos la funcion de ofertas por conferencias/eventos mas adelante
                                <span
                                    class="absolute z-50 -right-px -top-px rounded-bl-3xl rounded-tr-xl bg-rose-600 px-6 py-4 font-medium uppercase tracking-widest text-white">
                                    Save 10%
                                </span> -->
                                <img class="object-cover w-full h-56 rounded-t-xl"
                                    src="{{ asset( 'storage/' . $conferencia->foto) }}" alt="" />
                            </div>
                            <div class="flex flex-col justify-between flex-1 p-6">
                                <a class="text-gray-600 dark:text-gray-100 text-2xl font-semibold">{{$conferencia->nombre}}</a>
                                <div class="flex-1">
                                    <div>
                                        <ul class="flex flex-col mt-2 space-y-4">
                                            <li class="inline-flex items-center space-x-2">
                                                <svg class="flex-shrink-0 w-8 h-8 text-green-500 dark:text-green-600"
                                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M12 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M17.8 13.938h-.011a7 7 0 1 0-11.464.144h-.016l.14.171c.1.127.2.251.3.371L12 21l5.13-6.248c.194-.209.374-.429.54-.659l.13-.155Z" />
                                                </svg>
                                                <span class="text-base font-medium text-gray-600 dark:text-gray-400"><strong class="text-gray-600 dark:text-gray-100">Lugar: </strong>
                                                    {{ $conferencia->lugar }} </span>
                                            </li>

                                            <li class="inline-flex items-center space-x-2">
                                                <svg class="flex-shrink-0 w-8 h-8 text-green-500 dark:text-green-600"
                                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Zm3-7h.01v.01H8V13Zm4 0h.01v.01H12V13Zm4 0h.01v.01H16V13Zm-8 4h.01v.01H8V17Zm4 0h.01v.01H12V17Zm4 0h.01v.01H16V17Z" />
                                                </svg>
                                                <span class="text-base font-medium text-gray-600 dark:text-gray-400"><strong class="text-gray-600 dark:text-gray-100">Fecha: </strong>
                                                    {{ \Carbon\Carbon::parse($conferencia->fecha)->format('d \d\e F \d\e Y') }}</span>
                                            </li>
                                            <li class="inline-flex items-center space-x-2">
                                                <svg class="flex-shrink-0 w-8 h-8 text-green-500 dark:text-green-600"
                                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                </svg>
                                                <span class="text-base font-medium text-gray-600 dark:text-gray-400"><strong class="text-gray-600 dark:text-gray-100">Hora: </strong> De
                                                    {{ \Carbon\Carbon::parse($conferencia->horaInicio)->format('g:i a') }} a
                                                    {{ \Carbon\Carbon::parse($conferencia->horaFin)->format('g:i a') }} </span>
                                            </li>
                                            <li class="inline-flex items-center space-x-2">
                                                <svg class="flex-shrink-0 w-8 h-8 text-green-500" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                                    viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-width="2"
                                                        d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                </svg>
                                                <span class="text-base font-medium text-gray-600 dark:text-gray-400"><strong class="text-gray-600 dark:text-gray-100">Costo: </strong>
                                                    {{ $conferencia->estado }} </span>
                                            </li>
                                            @if ($conferencia->estado === 'Pagado')
                                                <li class="inline-flex items-center space-x-2">
                                                    <svg class="flex-shrink-0 w-8 h-8 text-green-500 dark:text-green-600"
                                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                                            d="M8 7V6a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1h-1M3 18v-7a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-3.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                                                    </svg>
                                                    <span class="text-base font-medium text-gray-600 dark:text-gray-400"><strong class="text-gray-600 dark:text-gray-100">Precio: </strong>
                                                        {{ $conferencia->precio }} </span>
                                                    <button data-popover-target="popover-description-{{$conferencia->id}}"
                                                        data-popover-placement="bottom-end" type="button"><svg
                                                            class="w-4 h-4 ms-2 text-gray-400 hover:text-gray-500" aria-hidden="true"
                                                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd"
                                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                                                clip-rule="evenodd"></path>
                                                        </svg><span class="sr-only">Show information</span></button></p>
                                                    <div data-popover id="popover-description-{{$conferencia->id}}" role="tooltip"
                                                        class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
                                                        <div class="p-3 space-y-2">
                                                            <h3 class="font-semibold text-gray-900 dark:text-white">Activity growth -
                                                                Incremental</h3>
                                                            <p>Report helps navigate cumulative growth of community activities. Ideally,
                                                                the chart should have a growing
                                                                trend, as stagnating chart signifies a significant decrease of community
                                                                activity.</p>
                                                            <h3 class="font-semibold text-gray-900 dark:text-white">Calculation</h3>
                                                            <p>For each date bucket, the all-time volume of activities is calculated.
                                                                This means that activities in period n
                                                                contain all activities up to period n, plus the activities generated by
                                                                your community in period.</p>
                                                            <a href="#"
                                                                class="flex items-center font-medium text-blue-600 dark:text-blue-500 dark:hover:text-blue-600 hover:text-blue-700 hover:underline">Read
                                                                more <svg class="w-2 h-2 ms-1.5 rtl:rotate-180" aria-hidden="true"
                                                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                                                    <path stroke="currentColor" stroke-linecap="round"
                                                                        stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                                                                </svg></a>
                                                        </div>
                                                        <div data-popper-arrow></div>
                                                    </div>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <div class="w-full h-0 mb-4 border-t-2 dark:border-gray-600 border-gray-300 border-dotted"></div>
                                    <div class="flex items-center">
                                        <img class="flex-shrink-0 object-cover w-10 h-10 rounded-full"
                                            src="{{ asset('storage/'. $conferencia->conferencista->foto)}}"
                                            alt="" />
                                        <div class="min-w-0 ml-3">
                                            <p class="text-base font-semibold text-gray-600 dark:text-gray-100 truncate">
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
                                            </p>
                                            <p class="text-base text-gray-400 dark:text-gray-400 truncate">Conferencista</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="py-10 bg-white dark:bg-gray-900 sm:py-16 lg:py-24">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="max-w-2xl mx-auto text-center">
                    <h2 class="text-3xl font-bold leading-tight text-yellow-500 dark:text-yellow-700 sm:text-4xl lg:text-5xl">
                        Conferencistas <br><span class="text-gray-800 dark:text-gray-100">{{$evento->nombreevento}}</span>
                    </h2>
                </div>
                <div class="grid grid-cols-1 gap-12 mt-24 text-center sm:grid-cols-2 md:grid-cols-3 lg:gap-y-16">
                @foreach($conferencias as $conferencia)
                    <div>
                        <div class="relative flex items-center justify-center mx-auto">
                            <svg class="text-yellow-500 w-62 h-56" viewBox="0 0 72 75" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M63.6911 28.8569C68.0911 48.8121 74.6037 61.2674 53.2349 65.9792C31.8661 70.6909 11.6224 61.2632 7.22232 41.308C2.82229 21.3528 3.6607 12.3967 25.0295 7.68503C46.3982 2.97331 59.2911 8.90171 63.6911 28.8569Z" />
                            </svg>
                            <div class="absolute text-yellow-500 w-48 h-48">
                                <img class="object-cover w-full h-full rounded-full"
                                     src="{{ asset('storage/'. $conferencia->conferencista->foto)}}"
                                    alt="{{$evento->logo}}" />
                            </div>
                        </div>
                        <h3 class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">{{$conferencia->conferencista->user->nombre}} {{$conferencia->conferencista->user->apellido}}</h3>
                        <p class="mt-2 text-base text-gray-900 dark:text-gray-400">Amet minim mollit non deserunt ullamco est sit aliqua dolor do
                            amet sint. Velit officia consequat duis enim velit mollit.</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Aquí en un futuro pondremos a los participantes de los eventos

        <section>
            <div class="py-10 bg-gradient-to-r from-yellow-500 to-yellow-600 dark:from-yellow-700 dark:to-yellow-800">
                <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <h2 class="text-3xl font-bold leading-tight text-center text-white sm:text-4xl lg:text-5xl">
                        Participantes</h2>
                </div>
            </div>
        
            <div class="grid grid-cols-4 md:grid-cols-6 xl:grid-cols-11">
                <div>
                    <div class="aspect-w-1 aspect-h-1">
                        <img class="bg-gray-200"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/testimonials/3/avatar-1.jpg" alt="" />
                    </div>
                </div>
        
                <div>
                    <div class="aspect-w-1 aspect-h-1">
                        <img class="bg-gray-300"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/testimonials/3/avatar-2.jpg" alt="" />
                    </div>
                </div>
        
                <div>
                    <div class="aspect-w-1 aspect-h-1">
                        <img class="bg-gray-200"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/testimonials/3/avatar-3.jpg" alt="" />
                    </div>
                </div>
        
                <div>
                    <div class="aspect-w-1 aspect-h-1">
                        <img class="bg-gray-300"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/testimonials/3/avatar-4.jpg" alt="" />
                    </div>
                </div>
        
                <div>
                    <div class="bg-orange-500 dark:bg-orange-700 aspect-w-1 aspect-h-1">
                        <div class="p-3 sm:p-5 xl:py-6 2xl:py-8 2xl:px-5">
                            <p class="text-sm font-semibold leading-tight text-white sm:text-lg sm:leading-tight">
                                {{$evento->nombreevento}}
                            </p>
                            <p class="mt-2 text-sm text-white truncate">¡Inscribete!</p>
                        </div>
                    </div>
                </div>
        
                <div>
                    <div class="aspect-w-1 aspect-h-1">
                        <img class="bg-gray-300"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/testimonials/3/avatar-5.jpg" alt="" />
                    </div>
                </div>
        
                <div>
                    <div class="aspect-w-1 aspect-h-1">
                        <img class="bg-gray-200"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/testimonials/3/avatar-6.jpg" alt="" />
                    </div>
                </div>
        
                <div>
                    <div class="aspect-w-1 aspect-h-1">
                        <img class="bg-gray-300"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/testimonials/3/avatar-7.jpg" alt="" />
                    </div>
                </div>
        
                <div>
                    <div class="aspect-w-1 aspect-h-1">
                        <img class="bg-gray-200"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/testimonials/3/avatar-8.jpg" alt="" />
                    </div>
                </div>
        
                <div>
                    <div class="aspect-w-1 aspect-h-1">
                        <img class="bg-gray-300"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/testimonials/3/avatar-9.jpg" alt="" />
                    </div>
                </div>
        
                <div>
                    <div class="aspect-w-1 aspect-h-1">
                        <img class="bg-gray-200"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/testimonials/3/avatar-10.jpg"
                            alt="" />
                    </div>
                </div>
        
                <div>
                    <div class="aspect-w-1 aspect-h-1">
                        <img class="bg-gray-300"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/testimonials/3/avatar-11.jpg"
                            alt="" />
                    </div>
                </div>
        
                <div>
                    <div class="aspect-w-1 aspect-h-1">
                        <img class="bg-gray-200"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/testimonials/3/avatar-12.jpg"
                            alt="" />
                    </div>
                </div>
        
                <div>
                    <div class="bg-blue-500 dark:bg-blue-800 aspect-w-1 aspect-h-1">
                        <div class="p-3 sm:p-5 xl:py-6 2xl:py-8 2xl:px-5">
                            <p class="text-sm font-semibold leading-tight text-white sm:text-lg sm:leading-tight">¡Sé
                                parte de la experiencia que hará la diferencia!</p>
                        </div>
                    </div>
                </div>
        
                <div>
                    <div class="aspect-w-1 aspect-h-1">
                        <img class="bg-gray-200"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/testimonials/3/avatar-13.jpg"
                            alt="" />
                    </div>
                </div>
        
                <div>
                    <div class="aspect-w-1 aspect-h-1">
                        <img class="bg-gray-300"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/testimonials/3/avatar-14.jpg"
                            alt="" />
                    </div>
                </div>
        
                <div>
                    <div class="aspect-w-1 aspect-h-1">
                        <img class="bg-gray-200"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/testimonials/3/avatar-15.jpg"
                            alt="" />
                    </div>
                </div>
        
                <div>
                    <div class="aspect-w-1 aspect-h-1">
                        <img class="bg-gray-300"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/testimonials/3/avatar-16.jpg"
                            alt="" />
                    </div>
                </div>
        
                <div>
                    <div class="bg-gray-700 dark:bg-gray-800 aspect-w-1 aspect-h-1">
                        <div class="p-3 sm:p-5 xl:py-6 2xl:py-8 2xl:px-5">
                            <p class="text-sm font-semibold leading-tight text-white sm:text-lg sm:leading-tight">
                                Aprovecha la oportunidad de destacar.</p>
                            <p class="mt-2 text-sm text-white truncate">¡Participa ahora!</p>
                        </div>
                    </div>
                </div>
        
                <div>
                    <div class="aspect-w-1 aspect-h-1">
                        <img class="bg-gray-300"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/testimonials/3/avatar-17.jpg"
                            alt="" />
                    </div>
                </div>
        
                <div>
                    <div class="aspect-w-1 aspect-h-1">
                        <img class="bg-gray-200"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/testimonials/3/avatar-18.jpg"
                            alt="" />
                    </div>
                </div>
        
                <div>
                    <div class="aspect-w-1 aspect-h-1">
                        <img class="bg-gray-300"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/testimonials/3/avatar-19.jpg"
                            alt="" />
                    </div>
                </div>
        
                <div>
                    <div class="aspect-w-1 aspect-h-1">
                        <img class="bg-gray-200"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/testimonials/3/avatar-20.jpg"
                            alt="" />
                    </div>
                </div>
        
                <div>
                    <div class="aspect-w-1 aspect-h-1">
                        <img class="bg-gray-300"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/testimonials/3/avatar-21.jpg"
                            alt="" />
                    </div>
                </div>
        
                <div>
                    <div class="aspect-w-1 aspect-h-1">
                        <img class="bg-gray-200"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/testimonials/3/avatar-22.jpg"
                            alt="" />
                    </div>
                </div>
        
                <div>
                    <div class="aspect-w-1 aspect-h-1">
                        <img class="bg-gray-300"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/testimonials/3/avatar-23.jpg"
                            alt="" />
                    </div>
                </div>
        
                <div>
                    <div class="aspect-w-1 aspect-h-1">
                        <img class="bg-gray-200"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/testimonials/3/avatar-24.jpg"
                            alt="" />
                    </div>
                </div>
        
                <div>
                    <div class="bg-green-400 dark:bg-green-800 aspect-w-1 aspect-h-1">
                        <div class="p-3 sm:p-5 xl:py-6 2xl:py-8 2xl:px-5">
                            <p class="text-sm font-semibold leading-tight text-white sm:text-lg sm:leading-tight">El
                                éxito te está esperando.</p>
                            <p class="mt-2 text-sm text-white truncate">¡Inscribete!</p>
                        </div>
                    </div>
                </div>
        
                <div>
                    <div class="aspect-w-1 aspect-h-1">
                        <img class="bg-gray-200"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/testimonials/3/avatar-25.jpg"
                            alt="" />
                    </div>
                </div>
        
                <div>
                    <div class="aspect-w-1 aspect-h-1">
                        <img class="bg-gray-300"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/testimonials/3/avatar-26.jpg"
                            alt="" />
                    </div>
                </div>
        
                <div>
                    <div class="aspect-w-1 aspect-h-1">
                        <img class="bg-gray-200"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/testimonials/3/avatar-27.jpg"
                            alt="" />
                    </div>
                </div>
        
                <div>
                    <div class="bg-red-500 dark:bg-red-800 aspect-w-1 aspect-h-1">
                        <div class="p-3 sm:p-5 xl:py-6 2xl:py-8 2xl:px-5">
                            <p class="text-sm font-semibold leading-tight text-white sm:text-lg sm:leading-tight">
                                Hazlo por ti, hazlo por tu futuro.</p>
                            <p class="mt-2 text-sm text-white truncate">¡Inscribete ya!</p>
                        </div>
                    </div>
                </div>
        
                <div>
                    <div class="aspect-w-1 aspect-h-1">
                        <img class="bg-gray-200"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/testimonials/3/avatar-28.jpg"
                            alt="" />
                    </div>
                </div>
        
                <div>
                    <div class="aspect-w-1 aspect-h-1">
                        <img class="bg-gray-300"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/testimonials/3/avatar-29.jpg"
                            alt="" />
                    </div>
                </div>
        
                <div>
                    <div class="bg-gray-700 dark:bg-gray-800 aspect-w-1 aspect-h-1">
                        <div class="p-3 sm:p-5 xl:py-6 2xl:py-8 2xl:px-5">
                            <p class="text-sm font-semibold leading-tight text-white sm:text-lg sm:leading-tight">
                                Grandes cosas suceden cuando tomas acción.</p>
                            <p class="mt-2 text-sm text-white truncate">¡Inscríbete!</p>
                        </div>
                    </div>
                </div>
        
                <div>
                    <div class="aspect-w-1 aspect-h-1">
                        <img class="bg-gray-300"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/testimonials/3/avatar-30.jpg"
                            alt="" />
                    </div>
                </div>
        
                <div>
                    <div class="aspect-w-1 aspect-h-1">
                        <img class="bg-gray-200"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/testimonials/3/avatar-31.jpg"
                            alt="" />
                    </div>
                </div>
        
                <div>
                    <div class="aspect-w-1 aspect-h-1">
                        <img class="bg-gray-300"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/testimonials/3/avatar-32.jpg"
                            alt="" />
                    </div>
                </div>
        
                <div>
                    <div class="aspect-w-1 aspect-h-1">
                        <img class="bg-gray-200"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/testimonials/3/avatar-33.jpg"
                            alt="" />
                    </div>
                </div>
        
                <div>
                    <div class="aspect-w-1 aspect-h-1">
                        <img class="bg-gray-300"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/testimonials/3/avatar-34.jpg"
                            alt="" />
                    </div>
                </div>
        
                <div>
                    <div class="bg-indigo-500 dark:bg-indigo-800 aspect-w-1 aspect-h-1">
                        <div class="p-3 sm:p-5 xl:py-6 2xl:py-8 2xl:px-5">
                            <p class="text-sm font-semibold leading-tight text-white sm:text-lg sm:leading-tight">
                                Conecta, aprende y crece.</p>
                            <p class="mt-2 text-sm text-white truncate">¡Inscribete!</p>
                        </div>
                    </div>
                </div>
        
                <div>
                    <div class="aspect-w-1 aspect-h-1">
                        <img class="bg-gray-300"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/testimonials/3/avatar-35.jpg"
                            alt="" />
                    </div>
                </div>
        
                <div>
                    <div class="aspect-w-1 aspect-h-1">
                        <img class="bg-gray-200"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/testimonials/3/avatar-4.jpg" alt="" />
                    </div>
                </div>
        
                <div>
                    <div class="aspect-w-1 aspect-h-1">
                        <img class="bg-gray-300"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/testimonials/3/avatar-3.jpg" alt="" />
                    </div>
                </div>
            </div>
        </section>

        -->

        <section class="py-10 bg-white dark:bg-gray-900 sm:py-16 lg:py-24">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="max-w-2xl mx-auto text-center">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-300 sm:text-4xl sm:leading-tight">Conoce nuestros
                        patrocinadores y organizadores</h2>
                </div>
        
                <div class="grid items-center max-w-4xl grid-cols-2 mx-auto mt-12 md:mt-20 md:grid-cols-4 gap-x-10 gap-y-16">
                    <div>
                        <img class="object-contain w-full h-6 mx-auto"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/logos/3/logo-1.png" alt="" />
                    </div>
        
                    <div>
                        <img class="object-contain w-full h-8 mx-auto"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/logos/3/logo-2.png" alt="" />
                    </div>
        
                    <div>
                        <img class="object-contain w-full h-8 mx-auto"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/logos/3/logo-3.png" alt="" />
                    </div>
        
                    <div>
                        <img class="object-contain w-full mx-auto h-7"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/logos/3/logo-4.png" alt="" />
                    </div>
        
                    <div class="hidden md:block">
                        <img class="object-contain w-full h-8 mx-auto"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/logos/3/logo-5.png" alt="" />
                    </div>
        
                    <div class="hidden md:block">
                        <img class="object-contain w-full h-8 mx-auto"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/logos/3/logo-6.png" alt="" />
                    </div>
        
                    <div class="hidden md:block">
                        <img class="object-contain w-full h-8 mx-auto"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/logos/3/logo-7.png" alt="" />
                    </div>
        
                    <div class="hidden md:block">
                        <img class="object-contain w-full h-8 mx-auto"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/logos/3/logo-8.png" alt="" />
                    </div>
        
                    <div class="hidden md:block">
                        <img class="object-contain w-full h-8 mx-auto"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/logos/3/logo-9.png" alt="" />
                    </div>
        
                    <div class="hidden md:block">
                        <img class="object-contain w-full mx-auto h-7"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/logos/3/logo-10.png" alt="" />
                    </div>
        
                    <div class="hidden md:block">
                        <img class="object-contain w-full h-8 mx-auto"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/logos/3/logo-11.png" alt="" />
                    </div>
        
                    <div class="hidden md:block">
                        <img class="object-contain w-full h-8 mx-auto"
                            src="https://cdn.rareblocks.xyz/collection/celebration/images/logos/3/logo-12.png" alt="" />
                    </div>
                </div>
        
                <div class="flex items-center justify-center mt-10 space-x-3 md:hidden">
                    <div class="w-2.5 h-2.5 rounded-full bg-blue-600 block"></div>
                    <div class="w-2.5 h-2.5 rounded-full bg-gray-300 dark:bg-gray-600 block"></div>
                    <div class="w-2.5 h-2.5 rounded-full bg-gray-300 dark:bg-gray-600 block"></div>
                </div>
        
                <p class="mt-10 text-base text-center text-gray-500 dark:text-gray-400 md:mt-20">and, 1000+ more companies</p>
            </div>
        </section>



        <section class="py-8 bg-gray-50 dark:bg-gray-900 sm:py-2 lg:py-8">
            <div class="px-6 mx-auto sm:px-6 lg:px-8 max-w-7xl">
                <div class="flex items-end justify-between">
                    <div class="flex-1 text-center lg:text-left">
                        <h2 class="text-3xl font-bold leading-tight text-black dark:text-gray-300 sm:text-4xl lg:text-5xl">Otros eventos
                        </h2>
                        <p class="max-w-xl mx-auto mt-4 text-base leading-relaxed text-gray-600 dark:text-gray-400 lg:mx-0">Puede que
                            tambien te interesen estos eventos.
                        </p>
                    </div>
                </div>
                <div class="grid max-w-md grid-cols-1 gap-6 mx-auto mt-4 lg:mt-8 lg:grid-cols-3 lg:max-w-full">
                @foreach($Eventos as $evento)
                    <div class="flex flex-col overflow-hidden bg-white dark:bg-gray-800 transform transition duration-300 hover:scale-105 rounded-xl shadow-xl">
                        <div class="flex flex-col justify-between flex-1">
                            <div class="relative">
                                <div class="block aspect-w-4 aspect-h-3">
                                    <img class="object-cover w-full h-56"
                                        src="{{ asset('storage/'. $evento->logo) }}"
                                        alt="" />
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
                                        <span class="inline-flex px-4 py-2 text-xs font-semibold tracking-widest uppercase rounded-full {{ $estadoInscripcion === 'Inscrito' ? 'text-green-600 bg-green-100 dark:bg-green-900 dark:text-green-300' : 'text-red-600 bg-red-100 dark:bg-red-900 dark:text-red-300' }}"> 
                                            {{ $estadoInscripcion ?? 'No inscrito' }} 
                                        </span>
                                    @endif

                                    @if ($estadoInscripcion === 'Inscrito' || $evento->estado === 'Gratis')
                                        <a href="{{ route('gafete', ['evento' => $evento->id]) }}">
                                            <span class="inline-flex px-4 py-2 text-xs font-semibold tracking-widest uppercase rounded-full text-yellow-500 bg-yellow-100 dark:bg-yellow-900 dark:text-yellow-300">Gafete</span>
                                        </a>
                                    @endif
                                        <span class="inline-flex px-4 py-2 text-xs font-semibold tracking-widest uppercase rounded-full text-yellow-500 bg-yellow-100 dark:bg-yellow-900 dark:text-yellow-300">{{$evento->estado}}</span>
                                        <span class="block mt-4 text-sm font-semibold tracking-widest text-gray-500 dark:text-gray-400">
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
                                            class="text-black dark:text-gray-300">{{$evento->nombreevento}} 
                                        </a>
                                    </p>
                                    <p class="mt-2 text-base leading-relaxed text-gray-600 dark:text-gray-400 truncate">{{$evento->descripcion}}</p>
                                    </div>

                                    <div class="border-t border-gray-200 dark:border-gray-700">
                                        <div class="flex">
                                            <div class="flex items-center flex-1 pl-6 pr-1 py-5">
                                               <button data-popover-target="popover-company-profile-{{$evento->id}}" type="button">
                                               <img class="object-cover w-8 h-8 rounded-full"
                                                    src="https://cdn.rareblocks.xyz/collection/celebration/images/blog/3/avatar-3.jpg"
                                                    alt="" />
                                               </button>
                                                <span
                                                    class="flex-1 block min-w-0 ml-3 text-base font-semibold text-gray-900 dark:text-gray-300 truncate">
                                                    {{ $evento->usuario->nombre }} {{ $evento->usuario->apellido }}<p class="fecha-creacion font-medium">{{ $evento->created_at->diffForHumans() }}</p></span>
                                                        <div data-popover id="popover-company-profile-{{$evento->id}}" role="tooltip"
            class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-80 dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600">
            <div class="p-3">
                <div class="flex">
                    <div class="me-3 shrink-0">
                        <a href="#" class="block p-2 bg-gray-100 rounded-lg dark:bg-gray-700">
                            <img class="w-8 h-8 rounded-full" src="https://flowbite.com/docs/images/logo.svg"
                                alt="Flowbite logo">
                        </a>
                    </div>
                    <div>
                        <p class="mb-1 text-base font-semibold leading-none text-gray-900 dark:text-white">
                            <a href="#" class="hover:underline"> {{ $evento->usuario->nombre }} {{ $evento->usuario->apellido }}</a>
                        </p>
                        <p class="mb-3 text-sm font-normal">
                        {{ $evento->usuario->name }}
                        </p>
                        <p class="mb-4 text-sm">Open-source library of Tailwind CSS components and Figma design system.</p>
                        <ul class="text-sm">
                            <li class="flex items-center mb-2">
                                <span class="me-2 font-semibold text-gray-400">
                                    <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 21 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M6.487 1.746c0 4.192 3.592 1.66 4.592 5.754 0 .828 1 1.5 2 1.5s2-.672 2-1.5a1.5 1.5 0 0 1 1.5-1.5h1.5m-16.02.471c4.02 2.248 1.776 4.216 4.878 5.645C10.18 13.61 9 19 9 19m9.366-6h-2.287a3 3 0 0 0-3 3v2m6-8a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                </span>
                                <a href="#" class="text-blue-600 dark:text-blue-500 hover:underline">https://flowbite.com/</a>
                            </li>
                            <li class="flex items-start mb-2">
                                <span class="me-2 font-semibold text-gray-400">
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
                            <img class="w-8 h-8 border-2 border-white rounded-full dark:border-gray-800"
                                src="/docs/images/people/profile-picture-5.jpg" alt="">
                            <img class="w-8 h-8 border-2 border-white rounded-full dark:border-gray-800"
                                src="/docs/images/people/profile-picture-2.jpg" alt="">
                            <img class="w-8 h-8 border-2 border-white rounded-full dark:border-gray-800"
                                src="/docs/images/people/profile-picture-3.jpg" alt="">
                            <a class="flex items-center justify-center w-8 h-8 text-xs font-medium text-white bg-gray-400 border-2 border-white rounded-full hover:bg-gray-500 dark:border-gray-800"
                                href="#">+3</a>
                        </div>
                        <div class="flex">
                            <button type="button"
                                class="inline-flex items-center justify-center w-full px-5 py-2 me-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"><svg
                                    class="w-3.5 h-3.5 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor" viewBox="0 0 18 18">
                                    <path
                                        d="M3 7H1a1 1 0 0 0-1 1v8a2 2 0 0 0 4 0V8a1 1 0 0 0-1-1Zm12.954 0H12l1.558-4.5a1.778 1.778 0 0 0-3.331-1.06A24.859 24.859 0 0 1 6 6.8v9.586h.114C8.223 16.969 11.015 18 13.6 18c1.4 0 1.592-.526 1.88-1.317l2.354-7A2 2 0 0 0 15.954 7Z" />
                                </svg>Like page</button>
                            <button id="dropdown-button" data-dropdown-toggle="dropdown-menu-{{$evento->id}}" data-dropdown-placement="right"
                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg shrink-0 focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                                type="button">
                                <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor" viewBox="0 0 16 3">
                                    <path
                                        d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z" />
                                </svg>
                            </button>
                        </div>
                        <div id="dropdown-menu-{{$evento->id}}"
                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdown-button">
                                <li>
                                    <a href="#"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Report
                                        this page</a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Add
                                        to favorites</a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Block
                                        this page</a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Invite
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
                                                class="inline-flex items-center flex-shrink-0 px-4 py-5 text-base font-semibold transition-all duration-200 bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700 hover:bg-yellow-500 dark:hover:bg-yellow-600 dark:text-gray-300 text-gray-900 hover:text-white">
                                                Ver evento
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
            <x-footer />
    </x-layouts.reportes>
</div>
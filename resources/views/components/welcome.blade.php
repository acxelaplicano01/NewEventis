<div>
    <div>
        <h5 class="text-stone-700 dark:text-stone-100">Hola {{ Auth::user()->name ?? 'Usuario' }}</h5>
        <p class="sm:text-3xl text-3xl font-extrabold font text-stone-700 dark:text-stone-100 mb-8">Bienvenido de nuevo
        </p>
    </div>
    <section class="text-stone-600 body-font">
        <div
            class="container mx-auto flex px-8 py-12 md:flex-row flex-col items-center bg-yellow-400 rounded-2xl shadow-lg max-h-[300px]">
            <div
                class="lg:flex-grow md:w-1/2 lg:pr-24 md:pr-16 flex flex-col md:items-start md:text-left mb-8 md:mb-0 items-center text-center">
                <h1 class="title-font sm:text-3xl text-3xl mb-2 font-bold text-white">¿Necesitas gestionar tus eventos?
                    <br /> ¡Hazlo con EVENTIS!
                </h1>
                <p class="mb-8 leading-relaxed text-white">Agenda, crea y promociona tus eventos en línea.</p>
                <div class="flex justify-center">
                    <a href="#"
                        class="inline-flex text-yellow-400 bg-slate-200 border-0 py-2 px-6 focus:outline-none hover:bg-slate-300 rounded text-lg font-semibold shadow-md">Crear
                        Evento</a>
                </div>
            </div>
            <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6 flex justify-center items-center relative">
                <iframe src="https://lottie.host/embed/2fc5f969-b468-460d-b7bb-d326a620c2bc/VuxZpH67Tt.lottie"
                    class="w-[350px] h-[350px] md:w-[350px] md:h-[350px] -mt-12 md:-mt-16"
                    style="border:none;"></iframe>
            </div>
        </div>
    </section>
</div>
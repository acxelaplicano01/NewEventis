<div>
    <h5 class="text-stone-700 dark:text-stone-100">Hola {{ Auth::user()->name ?? 'Usuario' }}</h5>
    <p class="sm:text-3xl text-3xl font-extrabold font text-stone-700 dark:text-stone-100 mb-8">Bienvenido de nuevo</p>
</div>
<section class="text-stone-600 body-font">
    <div
        class="container mx-auto flex px-8 py-12 md:flex-row flex-col items-center bg-yellow-400 rounded-2xl shadow-lg max-h-[300px]">
        <div
            class="lg:flex-grow md:w-1/2 lg:pr-24 md:pr-16 flex flex-col md:items-start md:text-left mb-8 md:mb-0 items-center text-center">
            <h1 class="title-font sm:text-3xl text-3xl mb-2 font-bold text-white">¿Necesitas gestionar tus eventos?
                <br /> ¡Hazlo con EVENTIS!</h1>
            <p class="mb-8 leading-relaxed text-white">Agenda, crea y promociona tus eventos en línea.</p>
            <div class="flex justify-center">
                <a href="#"
                    class="inline-flex text-yellow-400 bg-slate-200 border-0 py-2 px-6 focus:outline-none hover:bg-slate-300 rounded text-lg font-semibold shadow-md">Crear
                    Evento</a>
            </div>
        </div>
        <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6 flex justify-center items-center relative">
            <iframe src="https://lottie.host/embed/2fc5f969-b468-460d-b7bb-d326a620c2bc/VuxZpH67Tt.lottie"
                class="w-[350px] h-[350px] md:w-[350px] md:h-[350px] -mt-12 md:-mt-16" style="border:none;"></iframe>
        </div>
    </div>
</section>

<div>
    <!-- tarjetas de estadisticas -->
    <div class="w-full grid grid-cols-1 mt-6 sm:grid-cols-2 lg:grid-cols-4 gap-6 dark:bg-stone-900">
        <!-- Tarjeta -->
        <div
            class="relative flex items-center p-8 rounded-xl border border-stone-200 bg-white dark:border-white/5 dark:bg-white/5">
            <div class="flex items-center justify-center w-14 h-14 rounded-full bg-blue-100 dark:bg-blue-700">
                <svg class="w-8 h-8 text-blue-600 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M12.4472 4.10557c-.2815-.14076-.6129-.14076-.8944 0L2.76981 8.49706l9.21949 4.39024L21 8.38195l-8.5528-4.27638Z" />
                    <path
                        d="M5 17.2222v-5.448l6.5701 3.1286c.278.1325.6016.1293.8771-.0084L19 11.618v5.6042c0 .2857-.1229.5583-.3364.7481l-.0025.0022-.0041.0036-.0103.009-.0119.0101-.0181.0152c-.024.02-.0562.0462-.0965.0776-.0807.0627-.1942.1465-.3405.2441-.2926.195-.7171.4455-1.2736.6928C15.7905 19.5208 14.1527 20 12 20c-2.15265 0-3.79045-.4792-4.90614-.9751-.5565-.2473-.98098-.4978-1.27356-.6928-.14631-.0976-.2598-.1814-.34049-.2441-.04036-.0314-.07254-.0576-.09656-.0776-.01201-.01-.02198-.0185-.02991-.0253l-.01038-.009-.00404-.0036-.00174-.0015-.0008-.0007s-.00004 0 .00978-.0112l-.00009-.0012-.01043.0117C5.12215 17.7799 5 17.5079 5 17.2222Zm-3-6.8765 2 .9523V17c0 .5523-.44772 1-1 1s-1-.4477-1-1v-6.6543Z" />
                </svg>
            </div>
            <div class="ml-5">
                <h4 class="text-2xl font-bold text-stone-800 dark:text-white">
                    88</h4>
                <p class="text-base font-medium text-stone-600 dark:text-stone-400">Proyectos
                </p>
            </div>
        </div>

        <!-- Tarjeta -->
        <div
            class="relative flex items-center p-8 rounded-xl border border-stone-200 bg-white  dark:border-white/5 dark:bg-white/5">
            <div class="flex items-center justify-center w-14 h-14 rounded-full bg-green-100 dark:bg-green-700">
                <svg class="w-8 h-8 text-green-600 dark:text-white" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M9 7V2.221a2 2 0 0 0-.5.365L4.586 6.5a2 2 0 0 0-.365.5H9Z" />
                    <path fill-rule="evenodd"
                        d="M11 7V2h7a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V9h5a2 2 0 0 0 2-2Zm4.707 5.707a1 1 0 0 0-1.414-1.414L11 14.586l-1.293-1.293a1 1 0 0 0-1.414 1.414l2 2a1 1 0 0 0 1.414 0l4-4Z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-5">
                <h4 class="text-2xl font-bold text-stone-900 dark:text-white">
                    75</h4>
                <p class="text-base font-medium text-stone-600 dark:text-stone-400">
                    Finalizados
                </p>
            </div>
        </div>

        <!-- Tarjeta -->
        <div
            class="relative flex items-center p-8 rounded-xl border border-stone-200 dark:border-white/5 bg-white dark:bg-white/5">
            <div class="flex items-center justify-center w-14 h-14 rounded-full bg-red-100 dark:bg-red-700">
                <svg class="w-8 h-8 text-red-600 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M14.502 7.046h-2.5v-.928a2.122 2.122 0 0 0-1.199-1.954 1.827 1.827 0 0 0-1.984.311L3.71 8.965a2.2 2.2 0 0 0 0 3.24L8.82 16.7a1.829 1.829 0 0 0 1.985.31 2.121 2.121 0 0 0 1.199-1.959v-.928h1a2.025 2.025 0 0 1 1.999 2.047V19a1 1 0 0 0 1.275.961 6.59 6.59 0 0 0 4.662-7.22 6.593 6.593 0 0 0-6.437-5.695Z" />
                </svg>

            </div>
            <div class="ml-5">
                <h4 class="text-2xl font-bold text-stone-900 dark:text-white">
                    2</h4>
                <p class="text-base font-medium text-stone-600 dark:text-stone-400">Subsanar
                </p>
            </div>
        </div>

        <!-- Tarjeta -->
        <div
            class="relative flex items-center p-8 rounded-xl border border-stone-200 bg-white  dark:border-white/5 dark:bg-white/5">
            <div class="flex items-center justify-center w-14 h-14 rounded-full bg-yellow-100 dark:bg-yellow-700">
                <svg class="w-8 h-8 text-yellow-600 dark:text-white" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd"
                        d="M9 7V2.221a2 2 0 0 0-.5.365L4.586 6.5a2 2 0 0 0-.365.5H9Zm2 0V2h7a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-5h7.586l-.293.293a1 1 0 0 0 1.414 1.414l2-2a1 1 0 0 0 0-1.414l-2-2a1 1 0 0 0-1.414 1.414l.293.293H4V9h5a2 2 0 0 0 2-2Z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-5">
                <h4 class="text-2xl font-bold text-stone-900 dark:text-white">752</h4>
                <p class="text-base font-medium text-stone-600 dark:text-stone-400">
                    En Curso
                </p>
            </div>
        </div>

    </div>
</div>

<div>
    <x-calendar/>
</div>

<div class="pt-6 grid sm:grid-cols-2 xl:grid-cols-3 gap-4 lg:gap-6 mx-auto sm:max-w-3xl lg:max-w-4xl xl:max-w-none">
    <div
        class="border border-stone-200 dark:border-transparent transition-colors bg-white dark:bg-white/5 min-h-[12rem] py-12 rounded-xl">
        <div class="h-full flex items-center justify-center gap-4">
            
        </div>
    </div>








    <div
        class="border border-stone-200 dark:border-transparent transition-colors bg-white dark:bg-white/5 min-h-[12rem] py-8 px-6 md:py-12 md:px-12 lg:px-16 rounded-xl">
        <div class="h-full mx-auto flex items-center justify-center gap-4">
            <div
                class="min-w-0 [&amp;:not(:has([data-flux-field])):has([data-flux-control][disabled])&gt;[data-flux-label]]:opacity-50 [&amp;:has(&gt;[data-flux-radio-group][disabled])&gt;[data-flux-label]]:opacity-50 [&amp;:has(&gt;[data-flux-checkbox-group][disabled])&gt;[data-flux-label]]:opacity-50 block *:data-flux-label:mb-3 [&amp;&gt;[data-flux-label]:has(+[data-flux-description])]:mb-2 [&amp;&gt;[data-flux-label]+[data-flux-description]]:mt-0 [&amp;&gt;[data-flux-label]+[data-flux-description]]:mb-3 [&amp;&gt;*:not([data-flux-label])+[data-flux-description]]:mt-3"
                data-flux-field="">
                

                
            </div>
        </div>
    </div>






    <div
        class="border border-stone-200 dark:border-transparent transition-colors bg-white dark:bg-white/5 min-h-[12rem] py-8 px-6 md:py-12 md:px-12 lg:px-16 rounded-xl row-span-2">
        <div class="h-full flex items-center justify-center gap-4 max-w-80 mx-auto">
           

        </div>
    </div>













    <div
        class="border border-stone-200 dark:border-transparent transition-colors bg-white dark:bg-white/5 min-h-[12rem] py-8 px-6 md:py-12 md:px-12 lg:px-16 rounded-xl row-span-2">
        <div class="h-full flex items-center justify-center gap-4 max-w-80 mx-auto">
            
        </div>
    </div>










    <div
        class="border border-stone-200 dark:border-transparent transition-colors bg-white dark:bg-white/5 min-h-[12rem] py-8 px-6 md:py-12 md:px-1 lg:px-16 rounded-xl row-span-2">
        <div class="h-full flex items-center justify-center gap-4 max-w-80 mx-auto">
           
        </div>
    </div>










    <div
        class="row-span-2 border border-stone-200 dark:border-transparent transition-colors bg-white dark:bg-white/5 min-h-[12rem] p-6 md:p-12 lg:p-16 rounded-xl">
        <div class="h-full flex items-center justify-center gap-4 w-full mx-auto">
            
        </div>
    </div>










    <div
        class="max-lg:hidden sm:col-span-2 border border-stone-200 dark:border-transparent transition-colors bg-white dark:bg-white/5 min-h-[12rem] py-8 px-6 md:py-12 md:px-1 lg:px-16 rounded-xl flex flex-col justify-center">
       
    </div>







    <div
        class="border border-stone-200 dark:border-transparent transition-colors bg-white dark:bg-white/5 min-h-[12rem] py-8 px-6 md:py-12 md:px-10 lg:px-16 rounded-xl">
        <div>
            
        </div>
    </div>





    <div
        class="border border-stone-200 dark:border-transparent transition-colors bg-white dark:bg-white/5 min-h-[12rem] py-8 px-6 md:py-12 md:px-1 lg:px-16 rounded-xl">
        <div class="h-full flex items-center justify-center gap-4 max-w-80 mx-auto">
           
        </div>
    </div>






    <div
        class="border border-stone-200 dark:border-transparent transition-colors bg-white dark:bg-white/5 min-h-[12rem] py-8 px-6 md:py-12 md:px-1 lg:px-16 rounded-xl">
        <div class="h-full flex items-center justify-center gap-4 max-w-80 mx-auto">
           
        </div>
    </div>







    <div
        class="border border-stone-200 dark:border-transparent transition-colors bg-white dark:bg-white/5 min-h-[12rem] py-8 px-6 md:py-12 md:px-1 lg:px-16 rounded-xl">
        <div class="h-full flex items-center justify-center gap-4 max-w-80 mx-auto">
            
        </div>
    </div>












    <div
        class="border border-stone-200 dark:border-transparent transition-colors bg-white dark:bg-white/5 min-h-[12rem] py-12 rounded-xl">
        <div class="h-full flex items-center justify-center gap-4">
            <div class="flex group/button [&amp;&gt;[data-flux-input]:last-child:not(:first-child)&gt;[data-flux-group-target]:not([data-invalid])]:border-s-0 [&amp;&gt;[data-flux-input]:not(:first-child):not(:last-child)&gt;[data-flux-group-target]:not([data-invalid])]:border-s-0 [&amp;&gt;[data-flux-input]:has(+[data-flux-input-group-suffix])&gt;[data-flux-group-target]:not([data-invalid])]:border-e-0 [&amp;&gt;*:last-child:not(:first-child)&gt;[data-flux-group-target]:not([data-invalid])]:border-s-0 [&amp;&gt;*:not(:first-child):not(:last-child)&gt;[data-flux-group-target]:not([data-invalid])]:border-s-0 [&amp;&gt;*:has(+[data-flux-input-group-suffix])&gt;[data-flux-group-target]:not([data-invalid])]:border-e-0 [&amp;&gt;[data-flux-group-target]:last-child:not(:first-child)]:border-s-0 [&amp;&gt;[data-flux-group-target]:not(:first-child):not(:last-child)]:border-s-0 [&amp;&gt;[data-flux-group-target]:has(+[data-flux-input-group-suffix])]:border-e-0 [&amp;&gt;[data-flux-group-target]:not(:first-child):not(:last-child)]:rounded-none [&amp;&gt;[data-flux-group-target]:first-child:not(:last-child)]:rounded-e-none [&amp;&gt;[data-flux-group-target]:last-child:not(:first-child)]:rounded-s-none [&amp;&gt;*:not(:first-child):not(:last-child):not(:only-child)&gt;[data-flux-group-target]]:rounded-none [&amp;&gt;*:first-child:not(:last-child)&gt;[data-flux-group-target]]:rounded-e-none [&amp;&gt;*:last-child:not(:first-child)&gt;[data-flux-group-target]]:rounded-s-none [&amp;&gt;*:not(:first-child):not(:last-child):not(:only-child)&gt;[data-flux-input]&gt;[data-flux-group-target]]:rounded-none [&amp;&gt;*:first-child:not(:last-child)&gt;[data-flux-input]&gt;[data-flux-group-target]]:rounded-e-none [&amp;&gt;*:last-child:not(:first-child)&gt;[data-flux-input]&gt;[data-flux-group-target]]:rounded-s-none"
                data-flux-button-group="">
                
            </div>
        </div>
    </div>













    <div
        class="border border-stone-200 dark:border-transparent transition-colors bg-white dark:bg-white/5 min-h-[12rem] py-8 px-6 md:py-12 md:px-1 lg:px-16 rounded-xl">
        <div class="h-full flex items-center justify-center gap-4 max-w-80 mx-auto">
          
        </div>
    </div>




</div>
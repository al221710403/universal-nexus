<x-app-layout>
    @push('styles')
    @endpush

    <div class="flex-1 flex flex-shrink-0 antialiased" x-data="{ open: true }">

        <div class="flex-col w-14 bg-white h-full text-gray-500 transition-all duration-700 rounded-r-lg shadow-lg"
            :class="open ? ' hover:w-52 md:w-52' : ''">

            <div class="overflow-x-hidden flex flex-col justify-between flex-grow">
                <ul class="flex flex-col py-2 space-y-1">
                    <li>
                        <div
                            class="relative flex flex-row items-center text-sm h-11 border-l-4 border-transparent tracking-wide text-gray-600 font-semibold uppercase pr-6">
                            <span x-on:click="open = ! open"
                                class=" cursor-pointer inline-flex justify-center items-center ml-4">
                                <i class='bx bx-menu bx-sm'></i>
                            </span>
                            <span class="ml-2 text-sm tracking-wide truncate">Mi
                                Board</span>
                        </div>
                        <hr />
                    </li>
                    <li>
                        <a href="#"
                            class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-600 text-white-600 hover:text-white border-l-4 border-transparent hover:border-blue-700 pr-6">
                            <span class="inline-flex justify-center items-center ml-4">
                                <i class='bx bx-notepad bx-sm'></i>
                            </span>
                            <span class="ml-2 text-sm tracking-wide truncate">Tareas</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-600 text-white-600 hover:text-white border-l-4 border-transparent hover:border-blue-700 pr-6">
                            <span class="inline-flex justify-center items-center ml-4">
                                <i class='bx bx-sun bx-sm'></i>
                            </span>
                            <span class="ml-2 text-sm tracking-wide truncate">Mi día</span>
                            <span
                                class="hidden md:inline px-2 py-0.5 ml-auto text-xs font-medium tracking-wide text-blue-500 bg-indigo-50 rounded-full">12</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-600 text-white-600 hover:text-white border-l-4 border-transparent hover:border-blue-700 pr-6">
                            <span class="inline-flex justify-center items-center ml-4">
                                <i class='bx bx-label bx-sm'></i>
                            </span>
                            <span class="ml-2 text-sm tracking-wide truncate">Importante</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-600 text-white-600 hover:text-white border-l-4 border-transparent hover:border-blue-700 pr-6">
                            <span class="inline-flex justify-center items-center ml-4">
                                <i class='bx bx-calendar bx-sm'></i>
                            </span>
                            <span class="ml-2 text-sm tracking-wide truncate">Planeado</span>
                            <span
                                class="hidden md:block px-2 py-0.5 ml-auto text-xs font-medium tracking-wide text-red-500 bg-red-50 rounded-full">1.2k</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-600 text-white-600 hover:text-white border-l-4 border-transparent hover:border-blue-700 pr-6">
                            <span class="inline-flex justify-center items-center ml-4">
                                <i class='bx bx-share-alt bx-sm'></i>
                            </span>
                            <span class="ml-2 text-sm tracking-wide truncate">Asignado a ti</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-600 text-white-600 hover:text-white border-l-4 border-transparent hover:border-blue-700 pr-6">
                            <span class="inline-flex justify-center items-center ml-4">
                                <i class='bx bx-edit bx-sm'></i>
                            </span>
                            <span class="ml-2 text-sm tracking-wide truncate">Pendiente</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-600 text-white-600 hover:text-white border-l-4 border-transparent hover:border-blue-700 pr-6">
                            <span class="inline-flex justify-center items-center ml-4">
                                <i class='bx bx-check-square bx-sm'></i>
                            </span>
                            <span class="ml-2 text-sm tracking-wide truncate">Completado</span>
                        </a>
                    </li>
                    <hr />
                    <li>
                        <div class="mt-2 ml-3 md:mx-2">
                            <button
                                class="relative flex flex-row items-center w-full py-1 border text-left px-2 rounded-lg hover:bg-blue-600 text-white-600 hover:text-white">
                                <span class="inline-flex justify-center items-center">
                                    <i class='bx bx-plus bx-sm'></i>
                                </span>
                                <span class="ml-2 text-sm tracking-wide truncate">Agregar lista</span>
                            </button>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="bg-fixed bg-cover grid grid-cols-3 border border-red-500 basis-full overflow-y-auto bg-origin-content bg-no-repeat"
            style="background-image: url('https://images.pexels.com/photos/417192/pexels-photo-417192.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1')">
            <section class="relative col-span-2 pt-2 text-white overflow-hidden">
                <header class=" shadow-2xl rounded-lg px-4 py-1 mb-2" x-data="{ search: false }">
                    <div class="flex justify-between items-center mb-1.5 flex-wrap">
                        <h2 class="text-lg font-semibold tracking-wide">Tareas</h2>
                        <ul class="flex items-center text-sm">
                            <li x-show="!search" class="mr-3 bg-black opacity-70 rounded-md py-1 px-2"
                                title="Buscar tarea">
                                <button @click="search = true">
                                    <i class='bx bx-search-alt'></i>
                                </button>
                            </li>
                            <li class="mr-3 bg-black opacity-70 rounded-md py-1 px-2" title="Vista">
                                <button>
                                    <span><i class='bx bxs-layout'></i></span>
                                </button>
                            </li>
                            <li class="mr-3 bg-black opacity-70 rounded-md py-1 px-2" title="Comentarios">
                                <button>
                                    <span><i class='bx bx-comment-detail'></i></span>
                                </button>
                            </li>
                            <li class="mr-3 bg-black opacity-70 rounded-md py-1 px-2" title="Compartir">
                                <button>
                                    <span><i class='bx bxs-user-plus'></i></span>
                                </button>
                            </li>
                            <li class="bg-black opacity-70 rounded-md py-1 px-2" title="Opciones">
                                <button>
                                    <span>
                                        <i class='bx bx-dots-vertical-rounded'></i>
                                    </span>
                                </button>
                            </li>
                        </ul>
                    </div>
                    <hr>

                    <div x-show="search" class="relative mt-1">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-300 z-10">
                            <i class='bx bx-search-alt'></i>
                        </span>
                        <input type="text" id="search" autocomplete="off"
                            class="w-full bg-black opacity-70 text-sm rounded-lg block pl-10 p-2"
                            placeholder="Buscador para tareas...">
                        <button @click="search = false"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-200">
                            <span>
                                <i class='bx bx-x'></i>
                            </span>
                        </button>
                    </div>
                </header>

                <div class="px-4">
                    @for ($i = 0; $i < 15; $i++) <article
                        class="bg-white rounded shadow-xl text-gray-500 px-2 py-1 mb-1.5">
                        <header class="mb-1.5 flex items-center justify-between">
                            <div class="flex items-center flex-1 cursor-pointer">
                                <input type="checkbox" class=" rounded-full">
                                <h3 class="ml-1.5 text-lg font-semibold text-gray-700"> Lorem ipsum dolor sit amet.
                                </h3>
                            </div>
                            <ul class="flex items-center">
                                <li class="flex items-center mr-2 text-xl">
                                    <button title="Marcar como importante">
                                        <span><i class='bx bx-star'></i></span>
                                    </button>
                                </li>
                                <li class="flex items-center text-xl">
                                    <button title="Opciones">
                                        <span><i class='bx bx-dots-vertical-rounded'></i></span>
                                    </button>
                                </li>
                            </ul>
                        </header>
                        <hr />
                        <div class="ml-5">
                            <ul class="flex items-center mt-1.5 flex-wrap">
                                <li class="mr-3" title="Mi día">
                                    <span class="text-xl">
                                        <i class='bx bx-sun'></i>
                                    </span>
                                </li>
                                <li class="mr-3" title="Compartido">
                                    <span class="text-xl">
                                        <i class='bx bxs-user-plus'></i>
                                    </span>
                                </li>
                                <li class="mr-3" title="Fecha de vencimiento">
                                    <span class="text-xl">
                                        <i class='bx bx-calendar'></i>
                                    </span>
                                </li>
                                <li class="mr-3" title="Se repite">
                                    <span class="text-xl">
                                        <i class='bx bx-alarm'></i>
                                    </span>
                                </li>
                                <li class="mr-3" title="Archivos">
                                    <span class="text-xl">
                                        <i class='bx bx-file'></i>
                                    </span>
                                </li>
                                <li class="mr-3" title="Sub-tarea(s)">
                                    <span class="text-xl">
                                        <i class='bx bx-notepad'></i>
                                    </span>
                                </li>
                                <li class="mr-3" title="Nota">
                                    <span class="text-xl">
                                        <i class='bx bx-note'></i>
                                    </span>
                                </li>
                                <li class="mr-3" title="Pendiente">
                                    <span class="text-xl text-red-500">
                                        <i class='bx bx-calendar-x'></i>
                                    </span>
                                </li>
                            </ul>
                        </div>
                        <footer class="ml-5">
                            <div class="flex items-center justify-between my-2">
                                <p class="text-gray-400 text-sm">
                                    4/6 tareas completadas
                                </p>
                            </div>
                            <div class="w-full h-2 bg-blue-200 rounded-full">
                                <div class="h-full text-center text-xs text-white bg-blue-600 rounded-full"
                                    style="width: 50%;">
                                </div>
                            </div>
                        </footer>
                        </article>
                        @endfor
                </div>

                <footer class="fixed bottom-0 block w-full mb-1.5">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-300 z-10">
                            <i class='bx bx-plus bx-sm'></i>
                        </span>
                        <input type="text" id="search" autocomplete="off"
                            class="w-full bg-black text-sm block pl-10 p-2 border-none" placeholder="Agregar una tarea">
                    </div>
                </footer>
            </section>

            <section class="bg-white z-20 py-2 px-3">
                <header class="mb-1.5 flex items-start justify-between">
                    <div class="flex items-start flex-1 cursor-pointer">
                        <input type="checkbox" class="mt-1.5 rounded-full">
                        <h2 class="ml-1.5 text-lg font-semibold text-gray-700"> Lorem ipsum dolor sit
                            amet.
                        </h2>
                    </div>
                    <ul class="flex items-center">
                        <li class="flex items-center mr-2 text-xl">
                            <button title="Marcar como importante">
                                <span><i class='bx bx-star'></i></span>
                            </button>
                        </li>
                        <li class="flex items-center text-xl">
                            <button title="Cerrar">
                                <span><i class='bx bx-x'></i></span>
                            </button>
                        </li>
                        <li class="flex items-center text-xl">
                            <button title="Opciones">
                                <span><i class='bx bx-dots-vertical-rounded'></i></span>
                            </button>
                        </li>
                    </ul>
                </header>
                <hr />
                <div class="mt-2 flex flex-wrap items-center justify-between">

                    <div class="flex items-center">
                        <div class="mr-4 w-10 h-10 rounded-full shadow">
                            <img class="w-full h-full overflow-hidden object-cover object-center rounded-full"
                                src="https://tuk-cdn.s3.amazonaws.com/assets/components/popovers/p_1_0.png"
                                alt="avatar" />
                        </div>
                        <div>
                            <h4 class="mb-2 sm:mb-1 text-gray-700 text-sm font-normal leading-4">
                                Andres Berlin
                            </h4>
                            <p class="text-gray-600 text-xs leading-3">
                                12 Enero
                            </p>
                        </div>
                    </div>


                    <div class="flex flex-col items-end justify-end mb-3">
                        <div class="flex items-center justify-center">
                            <img class="w-6 h-6 rounded-full border-gray-200 border transform hover:scale-125"
                                src="https://randomuser.me/api/portraits/men/1.jpg" />
                            <img class="w-6 h-6 rounded-full border-gray-200 border -m-1 transform hover:scale-125"
                                src="https://randomuser.me/api/portraits/women/2.jpg" />
                            <img class="w-6 h-6 rounded-full border-gray-200 border -m-1 transform hover:scale-125"
                                src="https://randomuser.me/api/portraits/men/3.jpg" />
                        </div>
                        <p class="text-red-600 font-semibold text-xs leading-3 mt-1">
                            12 Febrero <span><i class='bx bx-calendar ml-1'></i></span>
                        </p>

                    </div>
                </div>

                <div class="text-gray-700">
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Reprehenderit
                        temporibus nemo
                        perferendis minima sapiente ipsum! Vero labore quibusdam a non sit, rem iure id unde nam quae
                        quas architecto maiores.
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Reprehenderit temporibus nemo
                        perferendis minima sapiente ipsum! Vero labore quibusdam a non sit, rem iure id unde nam quae
                        quas architecto maiores.
                    </p>

                    <ul class="ml-5 mt-3">
                        <li class="flex items-start mb-1.5">
                            <input type="checkbox" class="mt-1.5 mr-2 rounded-full">
                            <p>Ir a la case para hacer algo</p>
                        </li>
                        <li class="flex items-start mb-1.5">
                            <input type="checkbox" class="mt-1.5 mr-2 rounded-full">
                            <p>Lorem ipsum dolor sit amet.</p>
                        </li>
                        <li class="flex items-start mb-1.5">
                            <input type="checkbox" class="mt-1.5 mr-2 rounded-full">
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing.</p>
                        </li>
                    </ul>

                    <hr />

                    <section class="mt-1.5">
                        <h3 class="text-base font-semibold text-gray-800 flex items-center"> <span class="text-xl"><i
                                    class='bx bx-notepad mr-1'></i></span>
                            Subtareas</h3>
                        <ul class="ml-5 mt-1.5">
                            <li class="flex items-start mb-1.5">
                                <input type="checkbox" class="mt-1.5 mr-2 rounded-full">
                                <p>Subtarea 1</p>
                            </li>
                            <li class="flex items-start mb-1.5">
                                <input type="checkbox" class="mt-1.5 mr-2 rounded-full">
                                <p>Subtarea 2</p>
                            </li>
                        </ul>
                    </section>
                    <hr />

                    <section class="mt-1.5">
                        <h3 class="text-base font-semibold text-gray-800 flex items-center">
                            <span class="text-xl">
                                <i class='bx bx-file mr-1'></i>
                            </span>
                            Archivo(s)
                        </h3>
                        <ul class="mt-1.5 text-gray-500">
                            <li title="Descargar documento..."
                                class="flex rounded-lg items-center mb-1.5 cursor-pointer hover:bg-gray-200 hover:text-gray-600 hover:font-semibold">
                                <i class='bx bxs-file-pdf mr-2 ml-5'></i>
                                <p>Documento de prueba</p>
                            </li>
                            <li title="Descargar imagen..."
                                class="flex rounded-lg items-center mb-1.5 cursor-pointer hover:bg-gray-200 hover:text-gray-600 hover:font-semibold">
                                <i class='bx bxs-file-image mr-2 ml-5'></i>
                                <p>Imagen de muestra</p>
                            </li>
                            <li title="Descargar archivo..."
                                class="flex rounded-lg items-center mb-1.5 cursor-pointer hover:bg-gray-200 hover:text-gray-600 hover:font-semibold">
                                <i class='bx bxs-file mr-2 ml-5'></i>
                                <p>Archivo de mcoresponsdens</p>
                            </li>

                        </ul>
                    </section>

                </div>
            </section>
        </div>

        {{-- <section class="bg-white z-20 py-2 px-3">

            <header class="mb-1.5 flex items-center animate-pulse">
                <div class="h-2.5 my-auto bg-gray-400 rounded-full w-48"></div>
            </header>
            <hr />
            <div class="mt-2 animate-pulse flex items-center space-x-3">
                <svg class="text-gray-400 w-14 h-14" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
                        clip-rule="evenodd"></path>
                </svg>
                <div>
                    <div class="h-2.5 bg-gray-400 rounded-full w-32 mb-2"></div>
                    <div class="w-48 h-2 bg-gray-400 rounded-full"></div>
                </div>
            </div>

            <div role="status" class="mt-4 space-y-2.5 animate-pulse max-w-lg">
                <div class="flex items-center w-full space-x-2">
                    <div class="h-2.5 bg-gray-300 rounded-full w-32"></div>
                    <div class="h-2.5 bg-gray-400 rounded-full w-24"></div>
                    <div class="h-2.5 bg-gray-400 rounded-full w-full"></div>
                </div>
                <div class="flex items-center w-full space-x-2 max-w-[480px]">
                    <div class="h-2.5 bg-gray-300 rounded-full w-full"></div>
                    <div class="h-2.5 bg-gray-400 rounded-full w-full"></div>
                    <div class="h-2.5 bg-gray-400 rounded-full w-24"></div>
                </div>
                <div class="flex items-center w-full space-x-2 max-w-[400px]">
                    <div class="h-2.5 bg-gray-400 rounded-full w-full"></div>
                    <div class="h-2.5 bg-gray-300 rounded-full w-80"></div>
                    <div class="h-2.5 bg-gray-400 rounded-full w-full"></div>
                </div>
                <div class="flex items-center w-full space-x-2 max-w-[480px]">
                    <div class="h-2.5 bg-gray-300 rounded-full w-full"></div>
                    <div class="h-2.5 bg-gray-400 rounded-full w-full"></div>
                    <div class="h-2.5 bg-gray-400 rounded-full w-24"></div>
                </div>
                <div class="flex items-center w-full space-x-2 max-w-[440px]">
                    <div class="h-2.5 bg-gray-400 rounded-full w-32"></div>
                    <div class="h-2.5 bg-gray-400 rounded-full w-24"></div>
                    <div class="h-2.5 bg-gray-300 rounded-full w-full"></div>
                </div>
                <div class="flex items-center w-full space-x-2 max-w-[360px]">
                    <div class="h-2.5 bg-gray-400 rounded-full w-full"></div>
                    <div class="h-2.5 bg-gray-300 rounded-full w-80"></div>
                    <div class="h-2.5 bg-gray-400 rounded-full w-full"></div>
                </div>
                <span class="sr-only">Loading...</span>
            </div>

            <div class="mt-3 space-y-8 animate-pulse md:space-y-0 md:space-x-8 md:flex md:items-center">
                <div role="status" class="w-full">
                    <div class="h-2.5 bg-gray-400 rounded-full w-48 mb-4"></div>
                    <div class="h-2 bg-gray-400 rounded-full max-w-[480px] mb-2.5"></div>
                    <div class="h-2 bg-gray-400 rounded-full mb-2.5"></div>
                    <div class="h-2 bg-gray-400 rounded-full max-w-[440px] mb-2.5"></div>
                    <div class="h-2 bg-gray-400 rounded-full max-w-[460px] mb-2.5"></div>
                    <div class="h-2 bg-gray-400 rounded-full max-w-[360px]"></div>
                </div>
            </div>
        </section> --}}


    </div>
    @push('scripts')

    @endpush
</x-app-layout>

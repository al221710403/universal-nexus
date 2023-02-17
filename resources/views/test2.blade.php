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
                <button data-tooltip-target="tooltip-default" type="button"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Default
                    tooltip</button>
                <div id="tooltip-default" role="tooltip"
                    class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                    Tooltip content
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
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

                toggleEditingState
                <div x-data="data()" class="p-4">
                    <p @click.prevent @dblclick="toggleEditingState" x-show="!isEditing" x-text="text"
                        class="select-none cursor-pointer"></p>
                    <input type="text" x-model="text" x-show="isEditing" @click.away="toggleEditingState"
                        @keydown.enter="disableEditing" @keydown.window.escape="disableEditing"
                        class="bg-white focus:outline-none focus:shadow-outline border border-gray-300 rounded-lg py-2 px-4 appearance-none leading-normal w-128"
                        x-ref="input">
                </div>

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
                    </ul>
                </header>
                <hr />

                {{-- Agregar pasos --}}
                <div class="mt-2">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex text-blue-500 items-center pl-3 z-10">
                            <i class='bx bx-plus bx-sm'></i>
                        </span>
                        <input type="text" id="search" autocomplete="off"
                            class="w-full text-sm block pl-10 p-2 border border-white rounded-md focus:border-blue-500 placeholder-blue-500 text-gray-500"
                            placeholder="Agregar paso">
                    </div>
                    <ul class="mt-2 ml-8 mb-3">
                        <li class="relative flex flex-wrap items-center hover:shadow-xl py-1 px-2 mb-2">
                            <input type="checkbox" class="rounded-full">
                            <p class="ml-1.5 text-sm font-semibold text-gray-500"> Lorem ipsum dolor sit
                                amet.
                            </p>
                            <span class="absolute right-0 cursor-pointer">
                                <i class='bx bx-x'></i>
                            </span>
                        </li>
                        <li class="relative flex items-center hover:shadow-xl py-1 px-2 mb-2">
                            <input type="checkbox" class="rounded-full">
                            <p class="ml-1.5 text-sm font-semibold text-gray-500">
                                Lorem ipsum dolor sit amet, consectetur.
                            </p>
                            <span class="absolute right-0 cursor-pointer">
                                <i class='bx bx-x'></i>
                            </span>
                        </li>
                    </ul>
                </div>

                <div class="relative mb-3" x-data="{ open: false }">
                    {{-- <button x-on:click="open = ! open"
                        class="w-full text-left mb-3 text-sm block p-2 pl-4 rounded-md hover:shadow-lg text-gray-500 hover:text-blue-500 hover:font-semibold">
                        <span class="mr-1.5">
                            <i class='bx bx-alarm'></i>
                        </span>
                        Avisame a las 14:00
                        Hoy
                    </button> --}}

                    <div
                        class="flex w-full text-left mb-3 text-sm p-2 pl-4 rounded-md hover:shadow-lg text-gray-500 hover:text-blue-500 hover:font-semibold">
                        <span class="mr-1.5">
                            <i class='bx bx-alarm'></i>
                        </span>
                        <div class="flex-1">
                            <div class="block">
                                Avisame a las 14:00
                            </div>
                            <p class="text-xs font-semibold">Hoy</p>
                        </div>
                    </div>

                    <div x-show="open" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute w-full rounded-md shadow-lg top-9">
                        <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white ">
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                <input type="datetime-local"
                                    class="w-full text-sm block rounded-md border border-white focus:border-blue-500 placeholder-blue-500 mb-2">

                                <div class="border-t border-gray-100"></div>
                                <div class="flex justify-end items-center mt-2">
                                    <button
                                        class="mr-2 rounded-md border border-red-500 text-red-500 hover:bg-red-600 hover:text-white px-2 py-1 text-md"
                                        x-on:click="open = ! open">
                                        Cancelar
                                    </button>

                                    <button
                                        class="mr-2 rounded-md border border-blue-500 text-blue-500 hover:bg-blue-600 hover:text-white px-2 py-1 text-md"
                                        x-on:click="open = ! open">
                                        Guardar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative mb-3" x-data="{ open: false }">
                    {{-- <button x-on:click="open = ! open"
                        class="w-full text-left mb-3 text-sm block p-2 pl-4 rounded-md hover:shadow-lg text-gray-500 hover:text-blue-500 hover:font-semibold">
                        <span class="mr-1.5">
                            <i class='bx bx-calendar'></i>
                        </span>
                        Agregar fecha de vencimiento
                    </button> --}}

                    <div
                        class="flex w-full text-left mb-3 text-sm p-2 pl-4 rounded-md hover:shadow-lg text-gray-500 hover:text-blue-500 hover:font-semibold">
                        <span class="mr-1.5">
                            <i class='bx bx-calendar'></i>
                        </span>
                        <div class="flex-1">
                            <div class="block">
                                Vence a las 14:00
                            </div>
                            <p class="text-xs font-semibold">15 de Febrero</p>
                        </div>
                    </div>

                    <div x-show="open" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute w-full rounded-md shadow-lg top-9">
                        <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white ">
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                <input type="datetime-local"
                                    class="w-full text-sm block rounded-md border border-white focus:border-blue-500 placeholder-blue-500 mb-2">

                                <div class="border-t border-gray-100"></div>
                                <div class="flex justify-end items-center mt-2">
                                    <button
                                        class="mr-2 rounded-md border border-red-500 text-red-500 hover:bg-red-600 hover:text-white px-2 py-1 text-md"
                                        x-on:click="open = ! open">
                                        Cancelar
                                    </button>

                                    <button
                                        class="mr-2 rounded-md border border-blue-500 text-blue-500 hover:bg-blue-600 hover:text-white px-2 py-1 text-md"
                                        x-on:click="open = ! open">
                                        Guardar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>


                    {{-- datetime-local --}}
                    {{-- <input
                        class="cursor-pointer w-full text-sm block pl-10 p-2 border border-white rounded-md focus:border-blue-500 placeholder-blue-500 text-gray-500"
                        placeholder="Recordarme"> --}}
                </div>

                <div class="mb-3">
                    <button
                        class="w-full text-left mb-1.5 text-sm block p-2 pl-4 rounded-md hover:shadow-lg text-gray-500 hover:text-blue-500 hover:font-semibold">
                        <span class="mr-1.5">
                            <i class='bx bx-paperclip bx-rotate-270'></i>
                        </span>
                        Agregar archivos
                    </button>

                    <ul class="ml-8">
                        <li class="flex flex-wrap items-center justify-between hover:shadow-xl py-1 px-2 mb-2">
                            <div class="flex text-gray-500">
                                <span class="mr-2">
                                    <i class='bx bx-file'></i>
                                </span>
                                <p class="text-sm"> Lorem ipsum dolor sit
                                    amet.
                                </p>
                            </div>
                            <ul class="flex">
                                <li class="mr-1 cursor-pointer" title="Ver">
                                    <span>
                                        <i class='bx bx-fullscreen'></i>
                                    </span>
                                </li>
                                <li class="mr-1 cursor-pointer" title="Descargar">
                                    <span>
                                        <i class='bx bx-cloud-download'></i>
                                    </span>
                                </li>
                                <li class="cursor-pointer" title="Eliminar">
                                    <span>
                                        <i class='bx bx-trash-alt'></i>
                                    </span>
                                </li>
                            </ul>
                        </li>
                    </ul>

                </div>

                <button
                    class="w-full text-left mb-3 text-sm block p-2 pl-4 rounded-md hover:shadow-lg text-gray-500 hover:text-yellow-500 hover:font-semibold">
                    <span class="mr-1.5">
                        <i class="bx bx-sun"></i>
                    </span>
                    Agregar a Mi día
                </button>

                <textarea rows="5"
                    class="w-full mb-3 border border-white px-2 py-1 text-gray-500 rounded-md text-md leading-relaxed tracking-wide placeholder-gray-400"
                    placeholder="Agregar nota..."></textarea>

                <div class="text-gray-400 text-sm text-center">
                    Creado hace un momento por Cristian Milton Fidel Pascual
                </div>
            </section>
        </div>


    </div>
    @push('scripts')
    <script>
        function data() {
            return {
            text: "Example text. vkhkv",
            isEditing: false,
                toggleEditingState() {
                this.isEditing = !this.isEditing;
                    if (this.isEditing) {
                        this.$nextTick(() => {
                        this.$refs.input.focus();
                        });
                    }
                },
                disableEditing() {
                this.isEditing = false;
                }
            };
        }
    </script>

    @endpush
</x-app-layout>

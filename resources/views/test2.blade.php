<x-app-layout>
    @push('styles')
    @endpush

    <div id="div2" class="flex-1 flex flex-shrink-0 antialiased" x-data="{ open: true }">

        <div class="flex flex-col w-14 bg-white h-full text-gray-500 transition-all duration-700 rounded-r-lg shadow-lg"
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
                                class="hidden md:block px-2 py-0.5 ml-auto text-xs font-medium tracking-wide text-blue-500 bg-indigo-50 rounded-full">New</span>
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
                    {{-- <li class="px-5 hidden md:block">
                        <div class="flex flex-row items-center mt-5 h-8">
                            <div class="text-sm font-light tracking-wide text-gray-400 uppercase">Settings</div>
                        </div>
                    </li> --}}
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

        <div class="grid grid-cols-3 border border-red-500 basis-full overflow-y-auto">
            <div class="border border-blue-600 col-span-2 overflow-y-auto">
                <p id="demo"></p>
                <p>lremo2</p>
                <p>lremo2</p>
                <p>lremo2</p>
                <p>lremo2</p>
                <p>lremo2</p>
                <p>lremo2</p>
                <p>lremo2</p>
                <p>lremo2</p>
                <p>lremo2</p>
                <p>lremo2</p>
                <p>lremo2</p>
                <p>lremo2</p>
                <p>lremo2</p>
                <p>lremo2</p>
                <p>lremo2</p>
                <p>lremo2</p>
                <p>lremo2</p>
                <p>lremo2</p>
                <p>lremo2</p>
                <p>lremo2</p>
                <p>lremo2</p>
                <p>lremo2</p>
                <p>lremo2</p>
                <p>lremo2</p>
                <p>lremo2</p>
                <p>lremo2</p>
            </div>
            <div class="border border-blue-600">1 Item</div>
        </div>




    </div>
    @push('scripts')
    <script type="text/javascript">
        let navigation = document.getElementById('navigation');
        let height = screen.height;

        let newHeight = height - navigation.offsetHeight;

        document.getElementById("div2").style.height = newHeight;
        console.log('ALtura del menu : '+ navigation.offsetHeight);
        console.log('ALtura total : '+ height);
        console.log('altura restante : '+ newHeight);


        //document.getElementById("demo").innerHTML =  height + "px";

    </script>
    @endpush
</x-app-layout>

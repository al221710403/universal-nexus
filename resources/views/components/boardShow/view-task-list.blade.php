@props(['task'])

<article class="rounded shadow-xl px-2 py-1 mb-1.5"
    style="background-color: {{$task->background_color}}; color: {{$task->text_color}};">

    {{-- Cabezera de la tarea--}}
    <header class="mb-1.5 flex items-center justify-between">
        <div class="flex items-center flex-1">
            <input type="checkbox" @if($task->status == "Completado") checked @endif
            class="rounded-full"
            wire:change="setComplete({{$task->id}})">
            <h3 wire:click="selectedTaskView({{$task->id}},'edit')"
                class="cursor-pointer ml-1.5 text-lg font-semibold {{$task->status == 'Completado' ? 'line-through' : ''}}">
                {{$task->title}}
            </h3>
        </div>

        {{-- Opciones de la cabezera del articulo --}}
        <ul class="flex items-center">
            {{-- Empezar tarea --}}
            <li class="flex items-center mr-2 text-xl">
                <button class="transition duration-150 ease-in-out" title="Empezar tarea"
                    wire:click="runningTask({{$task->id}})">
                    @if ($task->status != 'Completado')
                    @if ($task->status == 'Trabajando')
                    <span class=" text-green-500">
                        <i class="bx bx-play-circle  bx-burst "></i>
                    </span>
                    @else
                    <span>
                        <i class='bx bx-play-circle'></i>
                    </span>
                    @endif
                    @endif
                </button>
            </li>

            {{-- Marcar como importante --}}
            <li class="flex items-center mr-2 text-xl">
                <button wire:click="setImportant({{$task->id}})" title="Marcar como importante">
                    @if ($task->priority)
                    <span class=" text-yellow-500">
                        <i class='bx bxs-star'></i>
                    </span>
                    @else
                    <span>
                        <i class='bx bx-star'></i>
                    </span>
                    @endif
                </button>
            </li>

            {{-- Opciones --}}
            <li class="flex items-center text-xl relative" x-data="{ open: false }" @click.away="open = false"
                @close.stop="open = false">
                <button title="Opciones" x-on:click="open = ! open">
                    <span><i class='bx bx-dots-vertical-rounded'></i></span>
                </button>
                {{-- Ventana de opciones --}}
                <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="absolute rounded-md shadow-lg origin-top-right right-0 z-10 mt-52 w-48">
                    <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white ">
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            <button wire:click="selectedTaskView({{$task->id}},'edit')" x-on:click="open = ! open"
                                class="text-left w-full block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">
                                Editar
                            </button>
                            <div class="border-t border-gray-100"></div>
                            <button wire:click="viewSetColorTask({{$task->id}})"
                                class="text-left w-full block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">
                                Cambiar color
                            </button>
                            <div class="border-t border-gray-100"></div>
                            <button
                                class="text-left w-full block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">
                                Compartir
                            </button>
                            <div class="border-t border-gray-100"></div>
                            <button
                                onclick="Confirm('la tarea, esta acción eliminara tambien las subtareas','setDeleteTask',{{$task->id}})"
                                class="text-left w-full block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">
                                Eliminar
                            </button>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </header>

    <hr />

    {{-- Iconos de los estados --}}
    <div class="ml-5">
        <ul class="flex items-center mt-1.5 flex-wrap">
            {{-- Icono de mi dia --}}
            @if ($task->is_today)
            <li class="mr-3" title="Mi día">
                <span class="text-xl">
                    <i class='bx bx-sun'></i>
                </span>
            </li>
            @endif

            {{-- Icono de colaboradores --}}
            @if ($task->collaborators->count() > 0)
            <li class="mr-3" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
                <span class="text-xl cursor-pointer" x-on:click="open = ! open">
                    <i class='bx bxs-user-plus'></i>
                </span>
                <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="absolute z-10 px-3 w-72 py-2 invisible flex flex-col text-sm font-light text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 ">
                    <div>
                        <h3 class="font-semibold text-gray-900">Compartido</h3>
                    </div>
                    <hr />
                    <div class="mt-2">
                        <ul>
                            @foreach ($task->collaborators as $user)
                            <li
                                class="flex justify-between items-center mb-2.5 border-b hover:bg-gray-300 hover:px-1 rounded-md">
                                <p class="text-ms text-gray-700">{{$user->name}}</p>

                                @if ($user->pivot->assigned_task)
                                <span class="p-1 text-xs text-green-600 rounded-md">Asignada</span>
                                @endif
                            </li>
                            @endforeach
                        </ul>

                    </div>
                    <div data-popper-arrow></div>
                </div>
            </li>
            @endif

            {{-- Fecha de vencimiento --}}
            @if ($task->date_expiration)
            <li class="mr-3 relative" title="Fecha de vencimiento" x-data="{ open: false }" @click.away="open = false"
                @close.stop="open = false">
                <span class="text-xl cursor-pointer" x-on:click="open = ! open">
                    <i class='bx bx-calendar'></i>
                </span>

                {{-- Ventana de emergente --}}
                <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="absolute rounded-md shadow-lg top-7 left-0 sm:top-0 sm:left-8 w-80 z-20">
                    <div
                        class="px-3 py-2 flex flex-col text-sm font-light text-gray-500 bg-white border border-gray-200 rounded-lg shadow-sm w-full ">
                        <div>
                            <h3 class="font-semibold text-gray-900">Fecha de vencimiento</h3>
                        </div>
                        <hr />
                        <div class="mt-2 flex justify-between">
                            <div class="flex">
                                <span class="mr-2">
                                    <i class='bx bx-calendar'></i>
                                </span>
                                <div class="flex flex-col">
                                    <div>
                                        Vence a las
                                        {{$task->date_expiration->isoFormat('h:mm A')}}
                                    </div>

                                    <p class="text-xs font-semibold capitalize">

                                        @if($task->date_expiration->format('Y-m-d') == now()->subDay(1)->format('Y-m-d')
                                        )
                                        Ayer
                                        @endif

                                        @if($task->date_expiration->format('Y-m-d') == now()->format('Y-m-d'))
                                        Hoy
                                        @endif

                                        @if($task->date_expiration->format('Y-m-d') ==
                                        \Carbon\Carbon::tomorrow()->format('Y-m-d'))
                                        Mañana
                                        @endif

                                        @if($task->date_expiration->format('Y-m-d') < now()->subDay(1)->format('Y-m-d')
                                            ||
                                            $task->date_expiration->format('Y-m-d') >
                                            \Carbon\Carbon::tomorrow()->format('Y-m-d'))
                                            {{$task->date_expiration->isoFormat('dddd DD MMMM')}}
                                            @endif
                                    </p>
                                </div>
                            </div>

                            <div class="flex flex-col justify-end">
                                @if ($task->date_expiration > now() &&
                                $task['status'] !='Completado' ) <div class="text-right">
                                    Vence
                                </div>
                                <p class="text-right font-semibold">
                                    {{$task->date_expiration->diffForHumans()}}
                                </p>
                                @endif

                                @if ($task['status'] == 'Completado')
                                <div class="text-right text-green-500 rounded-lg px-2 py-1">
                                    Completado
                                </div>
                                @endif

                                @if ($task->date_expiration < now() && $task['status'] !='Completado' ) <div
                                    class="text-right text-red-500 rounded-lg px-2 py-1">
                                    Tarea expirada
                            </div>
                            @endif

                        </div>
                    </div>
                </div>
    </div>
    </li>
    @endif


    {{-- Recordarme --}}
    @if ($task->date_remind_me)
    <li class="mr-3 relative" title="Recordarme" x-data="{ open: false }" @click.away="open = false"
        @close.stop="open = false">
        <span class="text-xl cursor-pointer" x-on:click="open = ! open">
            <i class='bx bx-alarm'></i>
        </span>

        {{-- Ventana de emergente --}}
        <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="absolute rounded-md shadow-lg top-7 -left-11 sm:top-0 sm:left-8 w-80 z-20">
            <div
                class="px-3 py-2 flex flex-col text-sm font-light text-gray-500 bg-white border border-gray-200 rounded-lg shadow-sm w-full ">
                <div>
                    <h3 class="font-semibold text-gray-900">Récordarme</h3>
                </div>
                <hr />
                <div class="mt-1">
                    <div class="flex">
                        <span class="mr-2">
                            <i class='bx bx-alarm'></i>
                        </span>
                        @if($task->date_remind_me > now()) <div class="flex flex-col">
                            <div>
                                Recuerdame a las
                                {{$task->date_remind_me->isoFormat('h:mm A')}}
                            </div>

                            <p class="text-xs font-semibold capitalize">

                                @if($task->date_remind_me->format('Y-m-d') == now()->subDay(1)->format('Y-m-d') )
                                Ayer
                                @endif

                                @if($task->date_remind_me->format('Y-m-d') == now()->format('Y-m-d'))
                                Hoy
                                @endif

                                @if($task->date_remind_me->format('Y-m-d') ==
                                \Carbon\Carbon::tomorrow()->format('Y-m-d'))
                                Mañana
                                @endif

                                @if($task->date_remind_me->format('Y-m-d') < now()->subDay(1)->format('Y-m-d') ||
                                    $task->date_remind_me->format('Y-m-d') >
                                    \Carbon\Carbon::tomorrow()->format('Y-m-d'))
                                    {{$task->date_remind_me->isoFormat('dddd DD MMMM')}}
                                    @endif
                            </p>
                        </div>
                        @else
                        <div class="text-red-500">
                            Recordatorio expirado
                        </div>
                        @endif

                    </div>
                </div>
                <div data-popper-arrow></div>
            </div>
        </div>
    </li>
    @endif


    {{-- Nota --}}
    @if (strlen($task->content) > 0)
    <li class="mr-3 relative" title="Nota" x-data="{ open: false }" @click.away="open = false"
        @close.stop="open = false">
        <span class="text-xl cursor-pointer" x-on:click="open = ! open">
            <i class='bx bx-note'></i>
        </span>
        {{-- Ventana de emergente --}}
        <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="absolute rounded-md shadow-lg top-7 -left-16 sm:top-0 sm:left-8 w-80 h-72 z-20 overflow-y-auto">
            <div
                class="px-3 py-2 flex flex-col text-sm font-light text-gray-500 bg-white border border-gray-200 rounded-lg shadow-sm w-full ">
                <div class="mb-1">
                    <h3 class="font-semibold text-gray-900">Nota</h3>
                </div>
                <hr />
                <div class="ck-editor__main">
                    <div class="ck-content mt-1 px-2 py-3">
                        {!!$task->content!!}
                    </div>
                </div>
            </div>
        </div>
    </li>
    @endif

    {{-- Variable del contador de subtareas --}}
    @php
    $children_count =$task->children()->count();
    @endphp

    {{-- Subtareas --}}
    @if ($children_count > 0)
    <li class="mr-3 relative" title="Subtarea(s)" x-data="{ open: false }" @click.away="open = false"
        @close.stop="open = false">
        <span class="text-xl cursor-pointer" x-on:click="open = ! open">
            <i class='bx bxs-vector'></i>
        </span>
        {{-- Ventana de emergente --}}
        <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="absolute rounded-md shadow-lg top-7 -left-24 sm:top-0 sm:left-8 w-80 z-20">
            <div
                class="px-3 py-2 flex flex-col text-sm font-light text-gray-500 bg-white border border-gray-200 rounded-lg shadow-sm w-full ">
                @php
                $steps_complete = $task->children()->where('status','Completado')->count();
                @endphp
                <div class="mb-1">
                    <h3 class="font-semibold text-gray-900">Subtarea(s)
                        <span class="ml-2 text-gray-400 text-sm">
                            {{$steps_complete}}/{{$children_count}}
                            @if ($children_count == $steps_complete)
                            <span class="text-green-500"><i class='bx bx-check-circle'></i> Completado</span>
                            @else
                            Pasos completados
                            @endif
                        </span>
                    </h3>
                </div>
                <hr />
                <div class="mt-1">
                    <ul>
                        @foreach ($task->children as $subtarea)
                        <li class="flex justify-between items-center">
                            <div class="flex">
                                <p wire:click="selectedTaskView({{$subtarea->id}})"
                                    class="cursor-pointer ml-1.5 text-sm font-semibold {{$subtarea->status == 'Completado' ? 'line-through' : ''}}">
                                    {{$subtarea->title}}
                                </p>
                            </div>
                            <ul class="flex justify-end items-center">
                                <li class="mr-2">
                                    <span class="text-base cursor-pointer"
                                        wire:click="selectedTaskView({{$subtarea->id}})">
                                        <i class='bx bx-low-vision'></i>
                                    </span>
                                </li>
                                <li>
                                    <span class="text-base cursor-pointer">
                                        <i class='bx bx-trash-alt'></i>
                                    </span>
                                </li>
                            </ul>
                        </li>
                        @endforeach
                    </ul>

                    <div class="w-full h-2 bg-blue-200 rounded-full mt-2">
                        <div class="h-full text-center text-xs text-white bg-blue-600 rounded-full"
                            style="width: {{$children_count == $steps_complete ? 100 : (100/$children_count)*$steps_complete}}%;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </li>
    @endif

    {{-- Tarea padre --}}
    @if ($task->parent)
    <li class="mr-3 relative" title="Tarea padre" x-data="{ open: false }" @click.away="open = false"
        @close.stop="open = false">
        <span class="text-xl cursor-pointer" x-on:click="open = ! open">
            <i class='bx bx-child'></i>
        </span>

        {{-- Ventana de emergente --}}
        <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="absolute rounded-md shadow-lg top-7 -left-32 sm:top-0 sm:left-8 w-80 z-20">
            <div
                class="px-3 py-2 flex flex-col text-sm font-light text-gray-500 bg-white border border-gray-200 rounded-lg shadow-sm w-full ">
                <div class="mb-1">
                    <h3 class="font-semibold text-gray-900">
                        Tarea principal
                    </h3>
                </div>
                <hr />
                <div class="mt-1 flex justify-between items-center">
                    <div class="flex">
                        <p wire:click="selectedTaskView({{$task->parent->id}})"
                            class="cursor-pointer ml-1.5 text-sm font-semibold {{$task->parent->status == 'Completado' ? 'line-through' : ''}}">
                            {{$task->parent->title}}
                        </p>
                    </div>
                    <span class="text-base cursor-pointer" wire:click="selectedTaskView({{$task->parent->id}})">
                        <i class='bx bx-low-vision'></i>
                    </span>
                </div>
            </div>
        </div>

    </li>
    @endif

    {{-- Archivos --}}
    @if ($task->files->count() > 0)
    <li class="mr-3 relative" title="Archivos" x-data="{ open: false }" @click.away="open = false"
        @close.stop="open = false">
        <span class="text-xl cursor-pointer" x-on:click="open = ! open">
            <i class='bx bx-file'></i>
        </span>

        {{-- Ventana de emergente --}}
        <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="absolute rounded-md shadow-lg top-7 -left-32 sm:top-0 sm:left-8 w-96 z-20">
            <div
                class="px-3 py-2 flex flex-col text-sm font-light text-gray-500 bg-white border border-gray-200 rounded-lg shadow-sm w-full ">
                <div class="mb-1">
                    <h3 class="font-semibold text-gray-900">
                        Archivos
                    </h3>
                </div>
                <hr />

                <div class="mt-1">
                    <ul>
                        @foreach ($task->files as $file)
                        <li class="flex justify-between items-center hover:bg-slate-200 rounded-md">
                            <div class="flex">
                                <p class="cursor-pointer ml-1.5 text-sm font-semibold">
                                    @switch($file->type)
                                    @case('image')
                                    <span class="mr-1">
                                        <i class='bx bx-image-alt'></i>
                                    </span>
                                    @break
                                    @case('video')
                                    <span class="mr-1">
                                        <i class='bx bxs-videos'></i>
                                    </span>
                                    @break
                                    @case('document')
                                    <span class="mr-1">
                                        <i class='bx bx-file'></i>
                                    </span>
                                    @break
                                    @default

                                    @endswitch
                                    {{$file->name}}
                                </p>
                            </div>
                            <ul class="flex justify-end items-center">
                                <li class="mr-2" title="Ver">
                                    <span class="text-base cursor-pointer">
                                        <i class='bx bx-fullscreen'></i>
                                    </span>
                                </li>
                                <li class="mr-2" wire:click="downloadFile({{$file}})" title="Descargar">
                                    <span class="text-base cursor-pointer">
                                        <i class='bx bx-cloud-download'></i>
                                    </span>
                                </li>
                                <li title="Eliminar"
                                    onclick="Confirm('el archivo, esta acción no se puede revertir','deleteFileTask',{{$file->id}})">
                                    <span class="text-base cursor-pointer">
                                        <i class='bx bx-trash-alt'></i>
                                    </span>
                                </li>
                            </ul>
                        </li>
                        @endforeach
                    </ul>

                </div>
            </div>
        </div>
    </li>
    @endif
    </ul>
    </div>

    {{-- Pasos para completar tarea --}}
    @if ($task->steps_count > 0)
    <footer class="ml-5">
        @php
        $steps_complete = $task->steps()->where('complete',true)->count();
        @endphp

        <div class="flex items-center justify-between my-2">
            <p class="text-gray-400 text-sm">
                {{$steps_complete}}/{{$task->steps_count}}
                @if ($task->steps_count == $steps_complete)
                <span class="text-green-500"><i class='bx bx-check-circle'></i> Completado</span>
                @else
                Pasos completados
                @endif
            </p>
        </div>
        <div class="w-full h-2 bg-blue-200 rounded-full">
            <div class="h-full text-center text-xs text-white bg-blue-600 rounded-full"
                style="width: {{$task->steps_count == $steps_complete ? 100 : (100/$task->steps_count)*$steps_complete}}%;">
            </div>
        </div>
    </footer>
    @endif

</article>

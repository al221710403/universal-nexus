<section class="bg-white z-20 py-2 px-3 overflow-y-auto scroll sticky top-0" style="height: 562px;">
    {{-- Cabezera de la tarea --}}
    <header class="mb-1.5 flex items-start justify-between">
        {{-- Title --}}
        <div class="flex items-start flex-1 cursor-pointer">
            <input type="checkbox" class="mt-1.5 rounded-full" @if($task->status == "Completado") checked @endif
            wire:change="setComplete({{$task->id}})">
            <h2
                class="ml-1.5 text-lg font-semibold text-gray-700 {{$task->status == 'Completado' ? 'line-through' : ''}}">
                {{$task->title}}
            </h2>
        </div>
        {{-- Opciones de cabezera --}}
        <ul class="flex items-center">
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
            <li class="flex items-center text-xl">
                <button title="Cerrar" wire:click="closeViewTask">
                    <span><i class='bx bx-x'></i></span>
                </button>
            </li>
        </ul>
    </header>
    <hr />

    {{-- Agregar pasos --}}
    <div class="mt-2">
        {{-- Add Pasos --}}
        <form class="relative" wire:submit.prevent="saveStep({{$task->id}})">
            <span class="absolute inset-y-0 left-0 flex text-blue-500 items-center pl-3 z-10">
                <i class='bx bx-plus bx-sm'></i>
            </span>
            <input type="text" autocomplete="off" wire:model.defer='newStep'
                class="w-full text-sm block pl-10 p-2 border border-white rounded-md focus:border-blue-500 placeholder-blue-500 text-gray-500"
                placeholder="Agregar paso">
            <button class="hidden" type="submit">Save</button>
        </form>
        {{-- Lista de pasos --}}
        @if ($task->steps_count > 0)
        <ul class="mt-2 ml-8 mb-3">
            @foreach ($task->steps as $step)
            <li class="relative flex items-center hover:shadow-xl py-1 px-2 mb-2">
                <input type="checkbox" class="rounded-full" @if($step->complete) checked @endif
                wire:change="completeStep({{$step->id}})">
                <p class="ml-1.5 text-sm font-semibold {{$step->complete ? 'line-through text-gray-500' : ''}}">
                    {{$step->name}}
                </p>
                <span class="absolute right-0 cursor-pointer" wire:click="delteStep({{$step->id}})">
                    <i class='bx bx-x'></i>
                </span>
            </li>
            @endforeach
        </ul>
        @endif
    </div>

    {{-- Recuérdame --}}
    <div class="relative mb-3" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
        @if ($task->date_remind_me)
        <div x-on:click="open = ! open"
            class="cursor-pointer flex w-full text-left mb-3 text-sm p-2 pl-4 rounded-md hover:shadow-lg text-gray-500 hover:text-blue-500 hover:font-semibold">
            <span class="mr-1.5">
                <i class='bx bx-alarm'></i>
            </span>
            <div class="flex-1">
                <div class="block">
                    Recuérdame a las {{$task->date_remind_me->isoFormat('h:mm A')}}
                </div>
                <p class="text-xs font-semibold capitalize">

                    @if (now() > $task->date_remind_me)
                    <span class="text-red-500">Recordatorio expirado</span>
                    @else
                    @if ($task->date_remind_me->format('Y-m-d') == now()->subDay(1)->format('Y-m-d'))
                    Ayer
                    @endif

                    @if ($task->date_remind_me->format('Y-m-d') == now()->format('Y-m-d'))
                    Hoy
                    @endif

                    @if ($task->date_remind_me->format('Y-m-d') == \Carbon\Carbon::tomorrow()->format('Y-m-d'))
                    Mañana
                    @endif

                    @if ($task->date_remind_me->format('Y-m-d') < now()->subDay(1)->format('Y-m-d') ||
                        $task->date_remind_me->format('Y-m-d') > \Carbon\Carbon::tomorrow()->format('Y-m-d'))
                        {{$task->date_remind_me->isoFormat('dddd DD MMMM')}}
                        @endif
                        @endif
                </p>
            </div>
        </div>
        @else
        <button x-on:click="open = ! open"
            class="w-full text-left mb-3 text-sm block p-2 pl-4 rounded-md hover:shadow-lg text-gray-500 hover:text-blue-500 hover:font-semibold">
            <span class="mr-1.5">
                <i class='bx bx-alarm'></i>
            </span>
            Recuérdame
        </button>
        @endif

        <div x-show="open" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="absolute w-full rounded-md shadow-lg top-9 z-10">

            <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white ">
                <div class="block px-4 py-2 text-xs text-gray-400">
                    @if ($task->date_remind_me)
                    <button x-on:click="open = ! open" wire:click="romoveDateRemindMe({{$task->id}})"
                        class="text-left w-full block px-4 py-2 text-sm leading-5 transition text-red-600">
                        <span class="mr-1.5 text-base">
                            <i class='bx bx-calendar-x'></i>
                        </span>
                        Remover fecha de recordatorio
                    </button>
                    @endif
                    <button wire:click="getDateRemindMe('morning')"
                        class="text-left w-full block px-4 py-2 text-sm leading-5 transition {{$typeDateRemindMeSelected == 'morning' ? 'text-blue-700' : 'text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100'}}">
                        <span class="mr-1.5 text-base">
                            <i class='bx bx-timer'></i>
                        </span>
                        Mañana
                        <span class="ml-2 text-xs text-gray-400 font-semibold">
                            7:00 am
                        </span>
                    </button>
                    <button wire:click="getDateRemindMe('afternoon')"
                        class="text-left w-full block px-4 py-2 text-sm leading-5 transition {{$typeDateRemindMeSelected == 'afternoon' ? 'text-blue-700' : 'text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100'}}">
                        <span class="mr-1.5 text-base">
                            <i class='bx bx-timer'></i>
                        </span>
                        Tarde
                        <span class="ml-2 text-xs text-gray-400 font-semibold">
                            2:00 pm
                        </span>
                    </button>
                    <button wire:click="getDateRemindMe('night')"
                        class="text-left w-full block px-4 py-2 text-sm leading-5 transition {{$typeDateRemindMeSelected == 'night' ? 'text-blue-700' : 'text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100'}}">
                        <span class="mr-1.5 text-base">
                            <i class='bx bx-timer'></i>
                        </span>
                        Noche
                        <span class="ml-2 text-xs text-gray-400 font-semibold">
                            8:00 pm
                        </span>
                    </button>

                    <div x-data="{ date: false }" @click.away="date = false" @close.stop="date = false">
                        <button x-on:click="date = ! date" wire:click="getDateRemindMe('selected_date_remind_me')"
                            class="text-left w-full block px-4 py-2 text-sm leading-5 transition {{$typeDateRemindMeSelected == 'selected_date_remind_me' ? 'text-blue-700' : 'text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100'}}">
                            <span class="mr-1.5 text-base">
                                <i class='bx bx-calendar-event'></i>
                            </span>
                            Elegir fecha
                        </button>
                        <div class="z-20" x-show="date">
                            <input type="datetime-local" wire:model="dateRemindMe"
                                min="{{now()->isoFormat('YYYY-MM-DDTHH:mm')}}"
                                class="w-full text-sm block rounded-md border border-white focus:border-blue-500 placeholder-blue-500 mb-2">
                        </div>
                    </div>
                    <div class="border-t border-gray-100"></div>
                    <div class="flex justify-end items-center mt-2">
                        <button wire:click="closeDateRemindMe"
                            class="mr-2 rounded-md border border-red-500 text-red-500 hover:bg-red-600 hover:text-white px-2 py-1 text-md"
                            x-on:click="open = ! open">
                            Cancelar
                        </button>

                        @if ($dateRemindMe)
                        <button wire:click="saveDateRemindMe({{$task->id}})"
                            class="mr-2 rounded-md border border-blue-500 text-blue-500 hover:bg-blue-600 hover:text-white px-2 py-1 text-md"
                            x-on:click="open = ! open">
                            Guardar
                        </button>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>

    {{-- Vence --}}
    <div class="relative mb-3" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
        @if ($task->date_expiration)
        <div x-on:click="open = ! open"
            class="cursor-pointer flex w-full text-left mb-3 text-sm p-2 pl-4 rounded-md hover:shadow-lg text-gray-500 hover:text-blue-500 hover:font-semibold">
            <span class="mr-1.5">
                <i class='bx bx-calendar'></i>
            </span>
            <div class="flex-1">
                <div class="block">
                    Vence a las {{$task->date_expiration->isoFormat('h:mm A')}}
                </div>
                <p class="text-xs font-semibold capitalize">

                    @if ($task->date_expiration->format('Y-m-d') == now()->subDay(1)->format('Y-m-d'))
                    Ayer
                    @endif

                    @if ($task->date_expiration->format('Y-m-d') == now()->format('Y-m-d'))
                    Hoy
                    @endif

                    @if ($task->date_expiration->format('Y-m-d') == \Carbon\Carbon::tomorrow()->format('Y-m-d'))
                    Mañana
                    @endif

                    @if ($task->date_expiration->format('Y-m-d') < now()->subDay(1)->format('Y-m-d') ||
                        $task->date_expiration->format('Y-m-d') > \Carbon\Carbon::tomorrow()->format('Y-m-d'))
                        {{$task->date_expiration->isoFormat('dddd DD MMMM')}}
                        @endif
                </p>
            </div>
        </div>
        @else
        <button x-on:click="open = ! open"
            class="w-full text-left mb-3 text-sm block p-2 pl-4 rounded-md hover:shadow-lg text-gray-500 hover:text-blue-500 hover:font-semibold">
            <span class="mr-1.5">
                <i class='bx bx-calendar'></i>
            </span>
            Agregar fecha de vencimiento
        </button>
        @endif



        <div x-show="open" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="absolute w-full rounded-md shadow-lg top-9 z-10">
            <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white ">
                <div class="block px-4 py-2 text-xs text-gray-400">
                    @if ($task->date_expiration)
                    <button x-on:click="open = ! open" wire:click="romoveDateExpiration({{$task->id}})"
                        class="text-left w-full block px-4 py-2 text-sm leading-5 transition text-red-600">
                        <span class="mr-1.5 text-base">
                            <i class='bx bx-calendar-x'></i>
                        </span>
                        Remover fecha de vencimiento
                    </button>
                    @endif
                    <button wire:click="getDateExpiration('today')"
                        class="text-left w-full block px-4 py-2 text-sm leading-5 transition {{$typeDateSelected == 'today' ? 'text-blue-700' : 'text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100'}}">
                        <span class="mr-1.5 text-base">
                            <i class='bx bx-calendar-event'></i>
                        </span>
                        Hoy
                    </button>
                    <button wire:click="getDateExpiration('tomorrow')"
                        class="text-left w-full block px-4 py-2 text-sm leading-5 transition {{$typeDateSelected == 'tomorrow' ? 'text-blue-700' : 'text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100'}}">
                        <span class="mr-1.5 text-base">
                            <i class='bx bx-calendar-event'></i>
                        </span>
                        Mañana
                    </button>
                    <button wire:click="getDateExpiration('next_week')"
                        class="text-left w-full block px-4 py-2 text-sm leading-5 transition {{$typeDateSelected == 'next_week' ? 'text-blue-700' : 'text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100'}}">
                        <span class="mr-1.5 text-base">
                            <i class='bx bx-calendar-event'></i>
                        </span>
                        Semana próxima
                    </button>

                    <div x-data="{ date: false }" @click.away="date = false" @close.stop="date = false">
                        <button x-on:click="date = ! date" wire:click="getDateExpiration('selected_date_expiration')"
                            class="text-left w-full block px-4 py-2 text-sm leading-5 transition {{$typeDateSelected == 'selected_date_expiration' ? 'text-blue-700' : 'text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100'}}">
                            <span class="mr-1.5 text-base">
                                <i class='bx bx-calendar-event'></i>
                            </span>
                            Elegir fecha
                        </button>

                        <div class="z-20" x-show="date">
                            <input type="datetime-local" wire:model="dateExpiration"
                                class="w-full text-sm block rounded-md border border-white focus:border-blue-500 placeholder-blue-500 mb-2">
                        </div>
                    </div>
                    <div class="border-t border-gray-100"></div>
                    <div class="flex justify-end items-center mt-2">
                        <button wire:click="closeDateExpiration"
                            class="mr-2 rounded-md border border-red-500 text-red-500 hover:bg-red-600 hover:text-white px-2 py-1 text-md"
                            x-on:click="open = ! open">
                            Cancelar
                        </button>

                        @if ($dateExpiration)
                        <button wire:click="saveDateExpiration({{$task->id}})"
                            class="mr-2 rounded-md border border-blue-500 text-blue-500 hover:bg-blue-600 hover:text-white px-2 py-1 text-md"
                            x-on:click="open = ! open">
                            Guardar
                        </button>
                        @endif
                    </div>

                </div>
            </div>
        </div>

    </div>
    {{-- Agregar a mi día --}}
    @if ($task->date_expiration)
    @if ($task->date_expiration->format('Y-m-d') == now()->format('Y-m-d') || $task->status == 'Trabajando')
    <div
        class="cursor-not-allowed w-full text-left mb-3 text-sm block p-2 pl-4 rounded-md hover:shadow-lg text-yellow-500 hover:font-semibold">
        <span class="mr-1.5">
            <i class="bx bx-sun"></i>
        </span>
        Agregar a Mi día
    </div>
    @else
    <button wire:click="addToday({{$task->id}})"
        class="w-full text-left mb-3 text-sm block p-2 pl-4 rounded-md hover:shadow-lg hover:text-yellow-500 hover:font-semibold {{$task->is_today ? 'text-yellow-500' : 'text-gray-500'}}">
        <span class="mr-1.5">
            <i class="bx bx-sun"></i>
        </span>
        Agregar a Mi día
    </button>
    @endif
    @else
    @if ($task->status == 'Trabajando')
    <div
        class="cursor-not-allowed w-full text-left mb-3 text-sm block p-2 pl-4 rounded-md hover:shadow-lg text-yellow-500 hover:font-semibold">
        <span class="mr-1.5">
            <i class="bx bx-sun"></i>
        </span>
        Agregar a Mi día
    </div>
    @else
    <button wire:click="addToday({{$task->id}})"
        class="w-full text-left mb-3 text-sm block p-2 pl-4 rounded-md hover:shadow-lg hover:text-yellow-500 hover:font-semibold {{$task->is_today ? 'text-yellow-500' : 'text-gray-500'}}">
        <span class="mr-1.5">
            <i class="bx bx-sun"></i>
        </span>
        Agregar a Mi día
    </button>
    @endif
    @endif

    {{-- Subtarea(s) --}}
    {{-- @if (!$task->parent)
    <div class="mb-3">
        <button
            class="w-full text-left mb-1.5 text-sm block p-2 pl-4 rounded-md hover:shadow-lg text-gray-500 hover:text-blue-500 hover:font-semibold">
            <span class="mr-1.5">
                <i class='bx bxs-vector'></i>
            </span>
            Agregar Subtarea(s)
        </button>

        @if ($task->children->count() > 0)
        <hr />
        <ul class="ml-8 mt-3">
            @foreach ($task->children as $subtask)
            <li class="flex flex-wrap items-center justify-between hover:shadow-xl py-1 px-2 mb-2">
                <div class="flex text-gray-500">
                    <span class="mr-2">
                        <i class='bx bx-notepad'></i>
                    </span>
                    <p class="text-sm">
                        {{$subtask->title}}
                    </p>
                </div>
                <ul class="flex">
                    <li class="mr-1 cursor-pointer" title="Ver">
                        <span>
                            <i class='bx bx-fullscreen'></i>
                        </span>
                    </li>
                    <li onclick="Confirm('la tarea, esta acción eliminara tambien las subtareas','setViewDeleteTask',{{$subtask->id}})"
                        class="cursor-pointer" title="Eliminar">
                        <span>
                            <i class='bx bx-trash-alt'></i>
                        </span>
                    </li>
                </ul>
            </li>
            @endforeach

        </ul>
        @endif
    </div>
    @endif --}}



    {{-- Agregar archivos --}}
    <div class="relative mb-3" x-data="{ open: false }" @click.away="open = false" @close.stop="open = false">
        <button x-on:click="open = ! open"
            class="btn-mdl w-full text-left mb-1.5 text-sm block p-2 pl-4 rounded-md hover:shadow-lg text-gray-500 hover:text-blue-500 hover:font-semibold">
            <span class="mr-1.5">
                <i class='bx bx-paperclip bx-rotate-270'></i>
            </span>
            Agregar archivos
        </button>

        <div x-show="open" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="absolute w-full rounded-md shadow-lg top-9 z-10">

            <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white ">
                <div class="block px-4 py-2 text-xs text-gray-400">
                    <div class="mb-4 w-full group">
                        <x-jet-label class="text-gray-500 text-base required" value="Archivos(s)" />
                        <input type="file" wire:model="files" multiple
                            class="w-full text-sm block rounded-md border border-white focus:border-blue-500 placeholder-blue-500 mb-2">
                        <x-jet-input-error for="files" class="mt-2" />
                    </div>

                    <div class="flex justify-end items-center mt-2">
                        <button wire:click="$set('files',[])"
                            class="mr-2 rounded-md border border-red-500 text-red-500 hover:bg-red-600 hover:text-white px-2 py-1 text-md"
                            x-on:click="open = ! open">
                            Cancelar
                        </button>

                        <div wire:loading wire:target="files"
                            class=" cursor-not-allowed mr-2 rounded-md border border-blue-500 text-blue-500 hover:bg-blue-600 hover:text-white px-2 py-1 text-md">
                            <span class="mr-1">
                                <i class='bx bx-loader-alt bx-spin'></i>
                            </span>
                            Uploading...
                        </div>

                        @if ($files)
                        <button wire:click="saveFiles({{$task->id}})"
                            class="mr-2 rounded-md border border-blue-500 text-blue-500 hover:bg-blue-600 hover:text-white px-2 py-1 text-md"
                            x-on:click="open = ! open">
                            Guardar
                        </button>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        @if ($task->files->count() > 0)
        <ul class="ml-8">
            @foreach ($task->files as $file)
            <li class="flex flex-wrap items-center justify-between hover:shadow-xl py-1 px-2 mb-2">
                <div class="flex text-gray-500">
                    <span class="mr-2">
                        @switch($file->type)
                        @case('image')
                        <i class='bx bx-image-alt'></i>
                        @break
                        @case('video')
                        <i class='bx bxs-videos'></i>
                        @break
                        @case('document')
                        <i class='bx bx-file'></i>
                        @break
                        @default

                        @endswitch
                    </span>
                    <p class="text-sm">
                        {{$file->name}}
                    </p>
                </div>
                <ul class="flex">
                    <li class="mr-1 cursor-pointer" title="Ver">
                        <span>
                            <i class='bx bx-fullscreen'></i>
                        </span>
                    </li>
                    <li class="mr-1 cursor-pointer" wire:click="downloadFile({{$file}})" title="Descargar">
                        <span>
                            <i class='bx bx-cloud-download'></i>
                        </span>
                    </li>
                    <li class="cursor-pointer"
                        onclick="Confirm('el archivo, esta acción no se puede revertir','deleteFileTask',{{$file->id}})"
                        title="Eliminar">
                        <span>
                            <i class='bx bx-trash-alt'></i>
                        </span>
                    </li>
                </ul>
            </li>
            @endforeach
        </ul>
        @endif


    </div>

    {{-- Nota --}}
    <div class="mb-3">
        @if ($task->content)
        <div
            class="flex justify-between text-sm p-2 pl-4 rounded-md hover:shadow-lg text-gray-500 hover:text-blue-500 hover:font-semibold">
            <h4 class=" cursor-default"><span class="mr-1"><i class='bx bx-notepad'></i></span>Nota</h4>
            <button class="btn-mdl mr-1 text-lg" title="Editar Nota" data-action="open"
                wire:click="$emitTo('to-do.task-index-controller','editNote','{{$task->id}}')">
                <i class='bx bx-edit-alt'></i>
            </button>
        </div>
        <hr />
        @else
        <button data-action="open" wire:click="$emitTo('to-do.task-index-controller','editNote','{{$task->id}}')"
            class="btn-mdl w-full text-left mb-1.5 text-sm block p-2 pl-4 rounded-md hover:shadow-lg text-gray-500 hover:text-blue-500 hover:font-semibold">
            <span class="mr-1.5">
                <i class='bx bx-plus bx-sm'></i>
            </span>
            Agregar Nota
        </button>
        @endif


        @if ($task->content)
        <div class="ck-editor__main">
            <div class="ck-content mt-1 px-2 py-3 shadow-lg">
                {!!$task->content!!}
            </div>
        </div>
        @endif
    </div>


    {{-- Fotter --}}
    <div class="text-gray-400 text-sm text-center">
        Creado @if ($task->created_at->diffInDays(now()) > 1)
        el <span class="capitalize">{{$task->created_at->isoFormat('dddd DD MMMM YYYY')}}</span>
        @else
        {{$task->created_at->diffForHumans()}}
        @endif por <span class="font-semibold">{{$task->authorTask->name}}</span>
    </div>


    {{-- Modales --}}
    @include('livewire.toDo.parts.modal-add-files')
</section>

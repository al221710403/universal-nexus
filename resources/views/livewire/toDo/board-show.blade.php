@if ($readyToLoad)
@if ($board->background_image == null)
<div class="relative bg-fixed grid grid-cols-1 md:grid-cols-3 basis-full overflow-y-auto bg-gray-400 scroll_none">
    @else
    @if ($board->background_location == 'local' || $board->background_default)
    <div class="relative bg-fixed bg-cover grid grid-cols-1 md:grid-cols-3 basis-full overflow-y-auto bg-origin-content bg-no-repeat scroll_none"
        style="background-image: url({{ asset('storage/'.$board->background_image) }})">
        @else
        <div class="relative bg-fixed bg-cover grid grid-cols-1 md:grid-cols-3 basis-full overflow-y-auto bg-origin-content bg-no-repeat scroll_none"
            style="background-image: url('{{$board->background_image}}')">
            @endif
            @endif

            <div wire:loading.delay.longest class="inset-0 h-full w-full fixed overflow-x-hidden overflow-y-auto"
                style="z-index: 99; background-color: rgba(0, 0, 0, 0.5)">
                <div class="flex items-center justify-center text-center min-h-screen">
                    <div
                        class="flex flex-col px-4 py-10 mx-auto font-quick bg-white text-left transition-all transform rounded-lg shadow-xl w-full md:w-48">
                        <div class="flex justify-center">
                            <span class="loader"></span>
                        </div>
                        <div class="mt-4 text-center text-lg text-gray-600 font-semibold">
                            Cargando...
                        </div>
                    </div>
                </div>
            </div>

            <section class="relative pt-2 text-white {{$showTaskId ? 'col-span-2' : 'col-span-3'}}">
                {{-- Nombre y opciones del tablero --}}
                <header class=" shadow-2xl rounded-lg px-4 py-1 mb-2" x-data="{ search: false }">
                    <div class="flex justify-between items-center mb-1.5 flex-wrap">
                        <h2 class="text-lg font-semibold tracking-wide">{{is_numeric($title) ?
                            $this->board->name :
                            $title}}</h2>
                        {{-- elemntos del menu del tableto --}}
                        <ul class="flex items-center text-sm">
                            <li x-show="!search" class="mr-3 bg-black opacity-70 rounded-md py-1 px-2"
                                title="Buscar tarea">
                                <button @click="search = true">
                                    <i class='bx bx-search-alt'></i>
                                </button>
                            </li>

                            @if (is_numeric($title))
                            <li class="mr-3 bg-black opacity-70 rounded-md py-1 px-2" title="Comentario de tu lista">
                                <button wire:click="$set('showCommentBoard',true)">
                                    <span><i class='bx bx-comment-detail'></i></span>
                                </button>
                            </li>

                            <li class="mr-3 bg-black opacity-70 rounded-md py-1 px-2" title="Compartir">
                                <button>
                                    <span><i class='bx bxs-user-plus'></i></span>
                                </button>
                            </li>
                            @endif
                            <li class="relative" title="Opciones" x-data="{ open: false }" @click.away="open = false"
                                @close.stop="open = false">
                                <button x-on:click="open = ! open" class="bg-black opacity-70 py-1 px-2 rounded-md">
                                    <span>
                                        <i class='bx bx-dots-vertical-rounded'></i>
                                    </span>
                                </button>
                                <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="transform opacity-100 scale-100"
                                    x-transition:leave-end="transform opacity-0 scale-95"
                                    class="absolute rounded-md shadow-lg origin-top-right right-0 z-20 mt-3 w-48">
                                    <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white ">
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            <button data-action="open" wire:click="$set('changeBackgroundBoard',true)"
                                                x-on:click="open = ! open"
                                                class="btn-mdl text-left w-full block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">
                                                Cambiar fondo
                                            </button>
                                            <div class="border-t border-gray-100"></div>
                                            @if (!$board->is_tasks)
                                            <button
                                                onclick="Confirm('la lista, esta acción eliminará también todas las tareas relacionadas con esta lista','setDeleteBoard',{{$board->id}})"
                                                class="text-left w-full block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">
                                                Eliminar
                                            </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <hr>

                    {{-- Input search --}}
                    <div x-cloak x-show="search" class="relative mt-1">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-300 z-10">
                            <i class='bx bx-search-alt'></i>
                        </span>
                        <input type="text" id="search" autocomplete="off" wire:model.debounce.400ms="searchTask"
                            class="w-full bg-black opacity-70 text-sm rounded-lg block pl-10 p-2"
                            placeholder="Buscador para tareas...">
                        <button @click="search = false" wire:click="$set('searchTask','')"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-200">
                            <span>
                                <i class='bx bx-x'></i>
                            </span>
                        </button>
                    </div>
                </header>

                {{-- Muesta las tareas por los distintis status --}}
                <div class="px-4 pb-10 relative">
                    @if ($pendingTasks->count() > 0 || $workingTasks->count() > 0 || $completeTasks->count() > 0
                    ||
                    $delayedTasks->count() > 0)

                    {{-- Tareas pendientes --}}
                    @if($pendingTasks->count() > 0)
                    <section class="mb-3">
                        <div class="sticky top-2 z-10">
                            <header class="relative w-36 bg-black rounded-md py-1 px-2 mb-3">
                                <h3>Pendientes</h3>
                                <span
                                    class="absolute -top-2 -right-3 rounded-full bg-white text-gray-500 flex justify-center items-center w-8 h-8">
                                    {{$pendingTasks->count()}}
                                </span>
                            </header>
                        </div>
                        @foreach ($pendingTasks as $task)
                        <x-boardShow.view-task-list :task="$task" />
                        @endforeach
                    </section>
                    @endif

                    {{-- Tareas trabajando --}}
                    @if($workingTasks->count() > 0)
                    <section class="mb-3">
                        <div class="sticky top-2 z-10">
                            <header class="relative w-36 bg-black rounded-md py-1 px-2 mb-3">
                                <h3>Trabajando</h3>
                                <span
                                    class="absolute -top-2 -right-3 rounded-full bg-white text-gray-500 flex justify-center items-center w-8 h-8">
                                    {{$workingTasks->count()}}
                                </span>
                            </header>
                        </div>
                        @foreach ($workingTasks as $task)
                        <x-boardShow.view-task-list :task="$task" />
                        @endforeach
                    </section>
                    @endif

                    {{-- Tareas completas --}}
                    @if($completeTasks->count() > 0)
                    <section class="mb-3">
                        <div class="sticky top-2 z-10">
                            <header class="relative w-36 bg-black rounded-md py-1 px-2 mb-3">
                                <h3>Completado</h3>
                                <span
                                    class="absolute -top-2 -right-3 rounded-full bg-white text-gray-500 flex justify-center items-center w-8 h-8">
                                    {{$completeTasks->count()}}
                                </span>
                            </header>
                        </div>
                        @foreach ($completeTasks as $task)
                        <x-boardShow.view-task-list :task="$task" />
                        @endforeach
                    </section>
                    @endif

                    {{-- Tareas retrasadas --}}
                    @if($delayedTasks->count() > 0)
                    <section class="mb-3">
                        <div class="sticky top-2 z-10">
                            <header class="relative w-36 bg-black rounded-md py-1 px-2 mb-3">
                                <h3>Retrasado</h3>
                                <span
                                    class="absolute -top-2 -right-3 rounded-full bg-white text-gray-500 flex justify-center items-center w-8 h-8">
                                    {{$delayedTasks->count()}}
                                </span>
                            </header>
                        </div>
                        @foreach ($delayedTasks as $task)
                        <x-boardShow.view-task-list :task="$task" />
                        @endforeach
                    </section>
                    @endif

                    @else
                    <div class="text-lx">
                        <span class="text-lg mr-2"><i class='bx bx-search-alt'></i></span> No se a encontrado
                        ningun
                        resultado
                        para su busqueda
                    </div>
                    @endif

                </div>

                <footer class="fixed bottom-0 block w-full mb-1.5">
                    <form class="relative" wire:submit.prevent="saveTask">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-300 z-10">
                            <i class='bx bx-plus bx-sm'></i>
                        </span>
                        <input wire:model.defer='newTask' type="text" id="search" autocomplete="off"
                            class="w-full bg-black text-sm block pl-10 p-2 border-none" placeholder="Agregar una tarea">
                        <button class="hidden" type="submit">Save</button>
                    </form>
                </footer>
                @include('livewire.toDo.parts.modal-comment-board')
                @include('livewire.toDo.parts.modal-set-color-task')
                @include('livewire.toDo.parts.modal-background-board')
            </section>

            @if ($showTaskId)
            <livewire:to-do.task-show />
            @endif
        </div>
        @else
        <div wire:init="loadPosts"
            class="bg-fixed bg-cover mt-2 px-3 grid grid-cols-1 basis-full overflow-y-auto bg-origin-content bg-no-repeat">
            <section class="relative col-span-2 pt-2 text-white">
                <header class="bg-white shadow-2xl rounded-lg px-4 py-1 mb-2">
                    <div class="flex justify-between items-center flex-wrap">
                        <div class="h-2.5 bg-gray-400 rounded-full w-1/3 animate-pulse"></div>
                        <ul class="flex items-center text-sm">
                            <li class="mr-3 bg-gray-400 w-6 h-6 rounded-md animate-pulse"></li>
                            <li class="mr-3 bg-gray-400 w-6 h-6 rounded-md animate-pulse"></li>
                            <li class="mr-3 bg-gray-400 w-6 h-6 rounded-md animate-pulse"></li>
                            <li class="mr-3 bg-gray-400 w-6 h-6 rounded-md animate-pulse"></li>
                            <li class=" bg-gray-400 w-6 h-6 rounded-md animate-pulse"></li>
                        </ul>
                    </div>
                </header>

                <div>
                    @for ($i = 0; $i < 4; $i++) <article
                        class="bg-white rounded shadow-xl text-gray-500 px-2 py-1 mb-1.5">
                        <header class="mb-1.5 flex items-center justify-between">
                            <div class="flex items-center flex-1 cursor-pointer">
                                <input type="checkbox" class=" rounded-full">
                                <div class="h-2.5 ml-2 bg-gray-400 rounded-full w-1/3 animate-pulse"></div>
                            </div>
                            <ul class="flex items-center text-sm mr-2">
                                <li class="mr-3 bg-gray-400 w-6 h-6 rounded-md animate-pulse"></li>
                                <li class=" bg-gray-400 w-6 h-6 rounded-md animate-pulse"></li>
                            </ul>
                        </header>
                        <hr />
                        <div class="ml-5">
                            <ul class="flex items-center mt-1.5 flex-wrap">
                                <li class="mr-3 bg-gray-400 w-6 h-6 rounded-md animate-pulse"></li>
                                <li class="mr-3 bg-gray-400 w-6 h-6 rounded-md animate-pulse"></li>
                                <li class="mr-3 bg-gray-400 w-6 h-6 rounded-md animate-pulse"></li>
                                <li class="mr-3 bg-gray-400 w-6 h-6 rounded-md animate-pulse"></li>
                                <li class="mr-3 bg-gray-400 w-6 h-6 rounded-md animate-pulse"></li>
                                <li class="mr-3 bg-gray-400 w-6 h-6 rounded-md animate-pulse"></li>
                                <li class="mr-3 bg-gray-400 w-6 h-6 rounded-md animate-pulse"></li>
                                <li class=" bg-gray-400 w-6 h-6 rounded-md animate-pulse"></li>
                            </ul>
                        </div>
                        <footer class="ml-5">
                            <div class="flex items-center justify-between my-2">
                                <p class="text-gray-400 text-sm">
                                    ?/? tareas completadas
                                </p>
                            </div>
                            <div class="w-full h-2 bg-blue-200 rounded-full animate-pulse">
                                <div class="h-full text-center text-xs text-white bg-blue-500 rounded-full"
                                    style="width: {{rand(3,8)}}0%;">
                                </div>
                            </div>
                        </footer>
                        </article>
                        @endfor
                </div>

            </section>
        </div>
        @endif

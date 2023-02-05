<div class="bg-fixed bg-cover grid grid-cols-3 basis-full overflow-y-auto bg-origin-content bg-no-repeat"
    style="background-image: url('https://images.pexels.com/photos/417192/pexels-photo-417192.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1')">
    <section class="relative pt-2 text-white overflow-hidden {{$showTaskId ? 'col-span-2' : 'col-span-3'}}">
        <header class=" shadow-2xl rounded-lg px-4 py-1 mb-2" x-data="{ search: false }">
            <div class="flex justify-between items-center mb-1.5 flex-wrap">
                <h2 class="text-lg font-semibold tracking-wide">{{is_numeric($title) ? $this->board->name :
                    $title}}</h2>
                <ul class="flex items-center text-sm">
                    <li x-show="!search" class="mr-3 bg-black opacity-70 rounded-md py-1 px-2" title="Buscar tarea">
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
                <button @click="search = false" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-200">
                    <span>
                        <i class='bx bx-x'></i>
                    </span>
                </button>
            </div>
        </header>

        <div class="px-4 pb-10">

            @forelse ($tasks as $task)
            <article
                class="{{$task->status == 'Completado' ? 'bg-gray-200' : 'bg-white'}} rounded shadow-xl text-gray-500 px-2 py-1 mb-1.5">
                <header class="mb-1.5 flex items-center justify-between">
                    <div class="flex items-center flex-1 cursor-pointer" wire:click="selectedTaskView({{$task->id}})">
                        {{-- <div class="flex items-center flex-1 cursor-pointer"
                            wire:click="$set('showTaskId', {{$task->id}})"> --}}
                            <input type="checkbox" @if($task->status == "Completado") checked @endif
                            class="rounded-full"
                            wire:change="setComplete({{$task->id}})">
                            <h3
                                class="ml-1.5 text-lg font-semibold text-gray-700 {{$task->status == 'Completado' ? 'line-through' : ''}}">
                                {{$task->title}}
                            </h3>
                        </div>
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
                                <button title="Opciones">
                                    <span><i class='bx bx-dots-vertical-rounded'></i></span>
                                </button>
                            </li>
                        </ul>
                </header>
                <hr />
                <div class="ml-5">
                    <ul class="flex items-center mt-1.5 flex-wrap">
                        @if ($task->is_today)
                        <li class="mr-3" title="Mi día">
                            <span class="text-xl">
                                <i class='bx bx-sun'></i>
                            </span>
                        </li>
                        @endif
                        @if ($task->collaborators_count > 0)
                        <li class="mr-3" title="Compartido">
                            <span class="text-xl">
                                <i class='bx bxs-user-plus'></i>
                            </span>
                        </li>
                        @endif
                        @if ($task->date_expiration)
                        <li class="mr-3" title="Fecha de vencimiento">
                            <span
                                class="text-xl {{$task->date_expiration->format('Y-m-d') < now()->format('Y-m-d') ? 'text-red-500' :''}}">
                                <i class='bx bx-calendar'></i>
                            </span>
                        </li>
                        @endif
                        {{-- Ver como manejar el tema de repetición --}}
                        {{-- <li class="mr-3" title="Se repite">
                            <span class="text-xl">
                                <i class='bx bx-alarm'></i>
                            </span>
                        </li> --}}
                        @if (strlen($task->content) > 0)
                        <li class="mr-3" title="Nota">
                            <span class="text-xl">
                                <i class='bx bx-note'></i>
                            </span>
                        </li>
                        @endif
                        @if ($task->children()->count() > 0)
                        <li class="mr-3" title="Sub-tarea(s)">
                            <span class="text-xl">
                                <i class='bx bxs-vector'></i>
                            </span>
                        </li>
                        @endif
                        @if ($task->task_id)
                        <li class="mr-3" title="Tiene tarea padre">
                            <span class="text-xl">
                                <i class='bx bx-child'></i>
                            </span>
                        </li>
                        @endif
                        {{-- <li class="mr-3" title="Archivos">
                            <span class="text-xl">
                                <i class='bx bx-file'></i>
                            </span>
                        </li> --}}
                    </ul>
                </div>
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
            @empty
            No ahi ninguna tarea
            @endforelse
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


    @if ($showTaskId)
    <livewire:to-do.task-show />
    @endif

</div>

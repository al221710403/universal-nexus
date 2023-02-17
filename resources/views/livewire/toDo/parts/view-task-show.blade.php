<section class="{{$task->status == 'Completado' ? 'bg-gray-200' : 'bg-white'}} z-20 py-2 px-3 scroll sticky top-0"
    style="height: 562px;">
    {{-- Titulo y opciones --}}
    <header class="mb-1.5 flex items-start justify-between">
        <div class="flex items-start flex-1 cursor-pointer">
            <input type="checkbox" class="mt-1.5 rounded-full" @if($task->status == "Completado") checked @endif
            wire:change="setComplete({{$task->id}})">
            <h2
                class="ml-1.5 text-lg font-semibold text-gray-700 {{$task->status == 'Completado' ? 'line-through' : ''}}">
                {{$task->title}}
            </h2>
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
                <button title="Cerrar" wire:click="closeViewTask">
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
    {{-- Author, colaboradores y fecha de terminación --}}
    <div class="mt-2 flex flex-wrap items-center justify-between">

        <div class="flex items-center">
            <div class="mr-2 w-10 h-10 rounded-full shadow">
                <img class="w-full h-full overflow-hidden object-cover object-center rounded-full"
                    src="{{$task->authorTask->profile_photo_url}}" alt="avatar: {{$task->authorTask->name}}" />
            </div>
            <div>
                <h4 class="mb-2 sm:mb-1 text-gray-700 text-sm font-semibold leading-4"
                    title="{{$task->authorTask->name}}">
                    {{Str::limit($task->authorTask->name, 20) }}
                </h4>
                <p class="text-gray-600 text-xs leading-3">
                    <time datetime=" {{$task->created_at}}">
                        {{ Carbon\Carbon::parse($task->created_at)->isoFormat('D MMMM') }}
                    </time>
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
                @if ($task->date_expiration)
                <time datetime=" {{$task->date_expiration}}">
                    {{ Carbon\Carbon::parse($task->date_expiration)->isoFormat('D MMMM') }}
                    <span><i class='bx bx-calendar ml-1'></i></span>
                </time>
                @endif

            </p>

        </div>
    </div>


    <div class="text-gray-700">
        <div class="ck-editor__main">
            <div class="ck-content mt-2">
                {!!$task->content!!}
            </div>
        </div>


        {{-- {{dd($task)}} --}}

        @if ($task->steps_count > 0)
        <ul class="ml-5 mt-3">
            @foreach ($task->steps as $step)
            <li class="flex items-start mb-1.5">
                <input type="checkbox" class="mt-1.5 mr-2 rounded-full" @if($step->complete) checked @endif
                wire:change="completeStep({{$step->id}})">
                <p class="{{$step->complete ? 'line-through text-gray-500' : ''}}">{{$step->name}}</p>
            </li>
            @endforeach
        </ul>
        @endif

        @if ($task->children()->count() > 0)
        <hr />
        {{-- {{dd($task->children)}} --}}
        {{-- {{dd($task->children()->where('status','Completado')->get())}} --}}
        @php
        $all_subtasks = $task->children()->count();
        $complete_subtasks = $task->children()->where('status','Completado')->count();
        @endphp
        <section class="mt-1.5">
            <div class="w-full h-2 bg-blue-200 rounded-full">
                <div class="h-full text-center text-xs text-white bg-blue-600 rounded-full"
                    style="width: {{$complete_subtasks == $all_subtasks ? 100 : (100/$all_subtasks)*$complete_subtasks}}%;">
                </div>
            </div>
            <h3 class="text-base font-semibold text-gray-800 flex items-center">
                <span class="text-xl">
                    <i class='bx bx-notepad mr-1'></i>
                </span>

                Subtareas
                <span
                    class="text-xs ml-2 font-normal {{$complete_subtasks == $all_subtasks ? 'text-green-500' : 'text-gray-400'}}">
                    {{$complete_subtasks}}/{{$all_subtasks}}
                    @if ($complete_subtasks == $all_subtasks)
                    <i class='bx bx-check-circle'></i> Completado
                    @else
                    Subtareas
                    @endif
                </span>
            </h3>


            <ul class="ml-5 mt-1.5">
                @foreach ($task->children as $item)
                <li class="flex items-start mb-1.5">
                    <input type="checkbox" class="mt-1.5 mr-2 rounded-full" @if($item->status == "Completado") checked
                    @endif wire:change="setComplete({{$item->id}})">
                    <p class="{{$item->status == 'Completado' ? 'line-through' : ''}}">{{$item->title}}</p>
                </li>
                @endforeach
            </ul>
        </section>
        @endif


        {{--
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
        </section> --}}

    </div>
</section>

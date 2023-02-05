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

                @foreach ($myBoards as $board)
                <li>
                    <div wire:click="changeSelect({{$board->id}})" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-600
                        text-white-600 hover:text-white border-l-4 border-transparent hover:border-blue-700 pr-6
                        {{$boardId == $board->id ? 'bg-blue-600 text-white-600 text-white border-blue-700
                        cursor-default' : 'cursor-pointer'}}">
                        <span class="inline-flex justify-center items-center ml-4 text-2xl">
                            @if ($board->icono)
                            {!!$board->icono!!}
                            @else
                            <i class="bx bxs-book-content"></i>
                            @endif
                        </span>
                        <span class="ml-2 text-sm tracking-wide truncate">{{$board->name}}</span>
                        @if ($board->tasks_count > 0)
                        <span
                            class="hidden md:inline px-2 py-0.5 ml-auto text-xs font-medium tracking-wide text-blue-500 bg-indigo-50 rounded-full">{{$board->tasks_count}}</span>
                        @endif
                    </div>
                </li>
                @endforeach
                <hr />
                <li>
                    <div wire:click="changeSelect('today')" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-600 text-white-600 hover:text-white border-l-4 border-transparent hover:border-blue-700 pr-6 {{$boardId == 'today' ? 'bg-blue-600 text-white-600 text-white border-blue-700
                        cursor-default' : 'cursor-pointer'}}">
                        <span class="inline-flex justify-center items-center ml-4">
                            <i class='bx bx-sun bx-sm'></i>
                        </span>
                        <span class="ml-2 text-sm tracking-wide truncate">Mi día</span>
                        <span
                            class="hidden md:inline px-2 py-0.5 ml-auto text-xs font-medium tracking-wide text-blue-500 bg-indigo-50 rounded-full">{{$myDay}}</span>

                    </div>
                </li>

                <li>
                    <div wire:click="changeSelect('important')" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-600 text-white-600 hover:text-white border-l-4 border-transparent hover:border-blue-700 pr-6 {{$boardId == 'important' ? 'bg-blue-600 text-white-600 text-white border-blue-700
                        cursor-default' : 'cursor-pointer'}}">
                        <span class="inline-flex justify-center items-center ml-4">
                            <i class='bx bx-label bx-sm'></i>
                        </span>
                        <span class="ml-2 text-sm tracking-wide truncate">Importante</span>
                        <span
                            class="hidden md:inline px-2 py-0.5 ml-auto text-xs font-medium tracking-wide text-blue-500 bg-indigo-50 rounded-full">{{$importantTasks}}</span>

                    </div>
                </li>
                <li>
                    <div wire:click="changeSelect('retarded')"
                        class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-600 text-white-600 hover:text-white border-l-4 border-transparent hover:border-blue-700 pr-6 {{$boardId == 'retarded' ? 'bg-blue-600 text-white-600 text-white border-blue-700 cursor-default' : 'cursor-pointer'}}">
                        <span class="inline-flex justify-center items-center ml-4">
                            <i class='bx bx-calendar bx-sm'></i>
                        </span>
                        <span class="ml-2 text-sm tracking-wide truncate">Retrasado</span>
                        <span
                            class="hidden md:block px-2 py-0.5 ml-auto text-xs font-medium tracking-wide text-red-500 bg-red-50 rounded-full">{{$retardedTasks}}</span>
                        </d>
                </li>
                <li>
                    <div wire:click="changeSelect('pending')"
                        class="{{$boardId == 'pending' ? 'bg-blue-600 text-white-600 text-white border-blue-700 cursor-default' : 'cursor-pointer'}} relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-600 text-white-600 hover:text-white border-l-4 border-transparent hover:border-blue-700 pr-6">
                        <span class="inline-flex justify-center items-center ml-4">
                            <i class='bx bx-edit bx-sm'></i>
                        </span>
                        <span class="ml-2 text-sm tracking-wide truncate">Pendiente</span>
                        <span
                            class="hidden md:inline px-2 py-0.5 ml-auto text-xs font-medium tracking-wide text-blue-500 bg-indigo-50 rounded-full">{{$pendingTasks}}</span>
                    </div>
                </li>
                <li>
                    <div wire:click="changeSelect('complete')"
                        class="{{$boardId == 'complete' ? 'bg-blue-600 text-white-600 text-white border-blue-700 cursor-default' : 'cursor-pointer'}} relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-600 text-white-600 hover:text-white border-l-4 border-transparent hover:border-blue-700 pr-6">
                        <span class="inline-flex justify-center items-center ml-4">
                            <i class='bx bx-check-square bx-sm'></i>
                        </span>
                        <span class="ml-2 text-sm tracking-wide truncate">Completado</span>
                        <span
                            class="hidden md:inline px-2 py-0.5 ml-auto text-xs font-medium tracking-wide text-blue-500 bg-indigo-50 rounded-full">{{$completeTasks}}</span>
                    </div>
                </li>
                <li>
                    <a href="#"
                        class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-600 text-white-600 hover:text-white border-l-4 border-transparent hover:border-blue-700 pr-6">
                        <span class="inline-flex justify-center items-center ml-4">
                            <i class='bx bx-share-alt bx-sm'></i>
                        </span>
                        <span class="ml-2 text-sm tracking-wide truncate">Asignado a ti</span>
                        <span
                            class="hidden md:inline px-2 py-0.5 ml-auto text-xs font-medium tracking-wide text-blue-500 bg-indigo-50 rounded-full">0</span>
                    </a>
                </li>
                <hr />
                <li>
                    <div class="mt-2 ml-3 md:mx-2">
                        <button data-action="open" wire:click="$set('crateBoard', true)"
                            class="btn-mdl relative flex flex-row items-center w-full py-1 border text-left px-2 rounded-lg hover:bg-blue-600 text-white-600 hover:text-white">
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

    <livewire:to-do.board-show :boardId="$boardId" />

    <x-modal-boxicon wire:model="modalBoxicon" maxWidth="full" index="30" nameComponent="to-do.task-index-controller" />

    @include('livewire.toDo.parts.modal-create-board')

</div>


@push('scripts')
@endpush

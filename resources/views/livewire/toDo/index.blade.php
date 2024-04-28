@push('styles')
<style>
    :root {
        --ck-image-style-spacing: 1.5em;
        --ck-inline-image-style-spacing: calc(var(--ck-image-style-spacing)/2);
        --ck-color-image-caption-background: #f7f7f7;
        --ck-color-image-caption-text: #333;
        --ck-color-image-caption-highligted-background: #fd0;
    }

    .ck-editor__main {
        word-wrap: break-word;
        background: transparent;
        border: 0;
        margin: 0;
        padding: 0;
        text-decoration: none;
        transition: none;
        vertical-align: middle;
    }

    .ck-content {
        padding: 0 var(--ck-spacing-standard);
    }

    .ck-content .image,
    .ck-conten .image-inline {
        position: relative;
    }

    .ck-content p+.image-style-align-left,
    .ck-content p+.image-style-align-right,
    .ck-content p+.image-style-side {
        margin-top: 0;
    }

    .ck-content p>img {
        clear: both;
        display: table;
        margin: 0.9em auto;
        min-width: 50px;
        text-align: center;
        float: left;
        margin-right: var(--ck-image-style-spacing);
        max-width: 50%;
    }

    .ck-content p+.image-style-align-left,
    .ck-content p+.image-style-align-right,
    .ck-content p+.image-style-side {
        margin-top: 0;
    }

    .ck-content .image-style-side {
        float: right;
        margin-left: var(--ck-image-style-spacing);
        max-width: 50%;
    }

    .ck-content .image {
        clear: both;
        display: table;
        margin: 0.9em auto;
        min-width: 50px;
        text-align: center;
    }

    .ck-content .image>figcaption {
        background-color: var(--ck-color-image-caption-background);
        caption-side: bottom;
        color: var(--ck-color-image-caption-text);
        display: table-caption;
        font-size: .75em;
        outline-offset: -1px;
        padding: 0.6em;
        word-break: break-word;
        border: 1px solid transparent;
    }

    .ck-content p {
        font-size: 1rem
            /* 16px */
        ;
        line-height: 1.5rem
            /* 24px */
        ;

        --tw-text-opacity: 1;
        color: rgb(82 82 82 / var(--tw-text-opacity));
    }

    code {
        background-color: hsla(0, 0%, 78%, .3) !important;
        border-radius: 2px !important;
        padding: 0.15em !important;
    }

    .ck-content blockquote {
        border-left: 5px solid #ccc;
        font-style: italic;
        margin-left: 0;
        margin-right: 0;
        overflow: hidden;
        padding-left: 1.5em;
        padding-right: 1.5em;
        font-weight: 600;
        --tw-text-opacity: 1;
        color: rgb(115 115 115 / var(--tw-text-opacity));
    }
</style>

<style>
    .scroll_none::-webkit-scrollbar {
        -webkit-appearance: none;
    }

    .scroll_none::-webkit-scrollbar:vertical {
        width: 0px;
    }

    .scroll_none::-webkit-scrollbar-button:increment,
    .scroll_none::-webkit-scrollbar-button {
        display: none;
    }

    .scroll_none::-webkit-scrollbar:horizontal {
        height: 10px;
    }

    .scroll::-webkit-scrollbar {
        -webkit-appearance: none;
    }

    .scroll::-webkit-scrollbar:vertical {
        width: 10px;
    }

    .scroll::-webkit-scrollbar-button:increment,
    .scroll::-webkit-scrollbar-button {
        display: none;
    }

    .scroll::-webkit-scrollbar:horizontal {
        height: 10px;
    }

    .scroll::-webkit-scrollbar-thumb {
        background-color: #797979;
        border-radius: 20px;
        border: 2px solid #f1f2f3;
    }

    .scroll::-webkit-scrollbar-track {
        border-radius: 10px;
    }
</style>
@endpush

<div class="flex-1 flex flex-shrink-0 antialiased setHeight" x-data="{ open: true }" style="height: 562px;">

    <div wire:loading wire:target="saveBoard,receiveIconToBoxicon,openViewCreateBoard"
        class="inset-0 h-full w-full fixed overflow-x-hidden overflow-y-auto"
        style="z-index: 99; background-color: rgba(0, 0, 0, 0.5)">
        <div class="flex items-center justify-center text-center min-h-screen">
            <div class="flex flex-col px-4 py-10 mx-auto font-quick bg-white text-left transition-all transform rounded-lg shadow-xl
                w-full md:w-48">
                <div class="flex justify-center">
                    <span class="loader"></span>
                </div>
                <div class="mt-4 text-center text-lg text-gray-600 font-semibold">
                    Cargando...
                </div>
            </div>
        </div>
    </div>

    <div class="overflow-y-auto scroll_none flex-col w-14 bg-white h-full text-gray-500 transition-all duration-700 rounded-r-lg shadow-lg"
        :class="open ? ' hover:w-52 md:w-52' : ''">

        {{-- Nav izquierdo --}}
        <div class="overflow-x-hidden flex flex-col justify-between flex-grow">
            <div class="flex flex-col py-1 space-y-1">
                <div
                    class="relative flex flex-row items-center text-sm h-11 border-l-4 border-transparent tracking-wide text-gray-600 font-semibold uppercase pr-6">
                    <span x-on:click="open = ! open"
                        class=" cursor-pointer inline-flex justify-center items-center ml-4">
                        <i class='bx bx-menu bx-sm'></i>
                    </span>
                    <h2 class="ml-2 text-sm tracking-wide truncate">
                        Mi Board
                    </h2>
                </div>
            </div>
            <hr />
            {{-- Items del menu --}}
            <ul class="flex flex-col">
                @foreach ($myBoards as $board)
                <li class="mb-0.5 {{$board['name'] == 'Tareas' ? '-order-1' : ''}}">
                    <div wire:click="changeSelect({{$board['id']}})" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-600
                        text-white-600 hover:text-white border-l-4 border-transparent hover:border-blue-700 pr-6
                        {{$boardSelected == $board['id'] ? 'bg-blue-600 text-white-600 text-white border-blue-700
                        cursor-default' : 'cursor-pointer'}}">
                        <span class="inline-flex justify-center items-center ml-4 text-2xl">
                            @if ($board['icono'])
                            {!!$board['icono']!!}
                            @else
                            <i class="bx bxs-book-content"></i>
                            @endif
                        </span>
                        <span class="ml-2 text-sm tracking-wide truncate">{{$board['name']}}</span>
                        @if ($board['tasks_count'] > 0)
                        <span x-show="open"
                            class="hidden md:inline px-2 py-0.5 ml-auto text-xs font-medium tracking-wide text-blue-500 bg-indigo-50 rounded-full">
                            {{$board['tasks_count']}}
                        </span>
                        @endif
                    </div>
                </li>
                @endforeach
            </ul>
            <hr />

            {{-- Elmentos de categoria --}}
            <ul>
                {{-- Mi dia --}}
                <li>
                    <div wire:click="changeSelect('today')" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-600 text-white-600 hover:text-white border-l-4 border-transparent hover:border-blue-700 pr-6 {{$boardSelected == 'today' ? 'bg-blue-600 text-white-600 text-white border-blue-700
                            cursor-default' : 'cursor-pointer'}}">
                        <span class="inline-flex justify-center items-center ml-4">
                            <i class='bx bx-sun bx-sm'></i>
                        </span>
                        <span class="ml-2 text-sm tracking-wide truncate">Mi día</span>
                        @if ($myDay > 0)
                        <span x-show="open"
                            class="hidden md:inline px-2 py-0.5 ml-auto text-xs font-medium tracking-wide text-blue-500 bg-indigo-50 rounded-full">
                            {{$myDay}}
                        </span>
                        @endif
                    </div>
                </li>

                {{-- Importante --}}
                <li>
                    <div wire:click="changeSelect('important')" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-600 text-white-600 hover:text-white border-l-4 border-transparent hover:border-blue-700 pr-6 {{$boardSelected == 'important' ? 'bg-blue-600 text-white-600 text-white border-blue-700
                            cursor-default' : 'cursor-pointer'}}">
                        <span class="inline-flex justify-center items-center ml-4">
                            <i class='bx bx-label bx-sm'></i>
                        </span>
                        <span class="ml-2 text-sm tracking-wide truncate">Importante</span>
                        @if ($importantTasks > 0)
                        <span x-show="open"
                            class="hidden md:inline px-2 py-0.5 ml-auto text-xs font-medium tracking-wide text-blue-500 bg-indigo-50 rounded-full">
                            {{$importantTasks}}
                        </span>
                        @endif
                    </div>
                </li>

                {{-- Tareas retrasadas --}}
                <li>
                    <div wire:click="changeSelect('retarded')"
                        class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-600 text-white-600 hover:text-white border-l-4 border-transparent hover:border-blue-700 pr-6 {{$boardSelected == 'retarded' ? 'bg-blue-600 text-white-600 text-white border-blue-700 cursor-default' : 'cursor-pointer'}}">
                        <span class="inline-flex justify-center items-center ml-4">
                            <i class='bx bx-calendar bx-sm'></i>
                        </span>
                        <span class="ml-2 text-sm tracking-wide truncate">Retrasado</span>
                        @if ($retardedTasks > 0)
                        <span x-show="open"
                            class="hidden md:block px-2 py-0.5 ml-auto text-xs font-medium tracking-wide text-red-500 bg-red-50 rounded-full">
                            {{$retardedTasks}}
                        </span>
                        @endif
                    </div>
                </li>

                {{-- Tareas Pendientes --}}
                <li>
                    <div wire:click="changeSelect('pending')"
                        class="{{$boardSelected == 'pending' ? 'bg-blue-600 text-white-600 text-white border-blue-700 cursor-default' : 'cursor-pointer'}} relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-600 text-white-600 hover:text-white border-l-4 border-transparent hover:border-blue-700 pr-6">
                        <span class="inline-flex justify-center items-center ml-4">
                            <i class='bx bx-edit bx-sm'></i>
                        </span>
                        <span class="ml-2 text-sm tracking-wide truncate">Pendiente</span>
                        @if ($pendingTasks > 0)
                        <span x-show="open"
                            class="hidden md:inline px-2 py-0.5 ml-auto text-xs font-medium tracking-wide text-blue-500 bg-indigo-50 rounded-full">
                            {{$pendingTasks}}
                        </span>
                        @endif
                    </div>
                </li>

                {{-- tareas completadas --}}
                <li>
                    <div wire:click="changeSelect('complete')"
                        class="{{$boardSelected == 'complete' ? 'bg-blue-600 text-white-600 text-white border-blue-700 cursor-default' : 'cursor-pointer'}} relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-600 text-white-600 hover:text-white border-l-4 border-transparent hover:border-blue-700 pr-6">
                        <span class="inline-flex justify-center items-center ml-4">
                            <i class='bx bx-check-square bx-sm'></i>
                        </span>
                        <span class="ml-2 text-sm tracking-wide truncate">Completado</span>
                        @if ($completeTasks > 0)
                        <span x-show="open"
                            class="hidden md:inline px-2 py-0.5 ml-auto text-xs font-medium tracking-wide text-blue-500 bg-indigo-50 rounded-full">
                            {{$completeTasks}}
                        </span>
                        @endif
                    </div>
                </li>

                {{-- Compartidas --}}
                <li>
                    <a href="#"
                        class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-blue-600 text-white-600 hover:text-white border-l-4 border-transparent hover:border-blue-700 pr-6">
                        <span class="inline-flex justify-center items-center ml-4">
                            <i class='bx bx-share-alt bx-sm'></i>
                        </span>
                        <span class="ml-2 text-sm tracking-wide truncate">Compartidas</span>
                        {{-- <span
                            class="hidden md:inline px-2 py-0.5 ml-auto text-xs font-medium tracking-wide text-blue-500 bg-indigo-50 rounded-full">0</span>
                        --}}
                    </a>
                </li>
            </ul>
            <hr />

            {{-- Boton del modal de creacion de una lista --}}
            <div class="mt-2 ml-3 md:mx-2">
                <button data-action="open" wire:click="openViewCreateBoard"
                    class="btn-mdl relative flex flex-row items-center w-full py-1 border text-left px-2 rounded-lg hover:bg-blue-600 text-white-600 hover:text-white">
                    <span class="inline-flex justify-center items-center">
                        <i class='bx bx-plus bx-sm'></i>
                    </span>
                    <span class="ml-2 text-sm tracking-wide truncate">Agregar lista</span>
                </button>
            </div>
        </div>
    </div>

    <livewire:to-do.board-show :boardSelected="$boardSelected" />

    <x-modal-boxicon wire:model="modalBoxicon" maxWidth="full" index="30" nameComponent="to-do.task-index-controller" />
    @include('livewire.toDo.parts.modal-create-board')
    @include('livewire.toDo.parts.modal-note-task')
</div>


@push('scripts')
<script>
    //alert("La resolución de tu pantalla es: " + screen.width + " x " + screen.height);
    //var clientWidth = document.getElementById('navigation').clientWidth;
    //var clientHeight = document.getElementById('navigation').clientHeight;
    //alert("La resolución del menu es: " + clientWidth + " x " + clientHeight);
    //var mainWidth = document.getElementById('main').clientWidth;
    //var mainHeight = document.getElementById('main').clientHeight;
    //alert("La resolución del main es: " + mainWidth + " x " + mainHeight);
    //alert("altura restante: " + ((mainHeight-clientHeight)-1) );
</script>
<script src="{{ asset('vendor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>
<script>
    setInterval(function() {
        //console.log("Interval timeout");
        window.livewire.emit('reviewPendingTasks');
    }, 60000); // 60000 milisegundos = 1 minuto
    let CKEditor;
    ClassicEditor
        .create( document.querySelector( '#editor' ),{
            mediaEmbed: {
                previewsInData:true
            },
            simpleUpload: {
                // The URL that the images are uploaded to.
                uploadUrl: "{{ route('publish.posts.image.uplodad') }}",
            },
            placeholder: 'Escriba el texto aqui...'
        } )
        .then( function(editor){
            CKEditor = editor;
        })
        .catch( error => {
            console.error( error );
        } );

        document.addEventListener('DOMContentLoaded', function(){
            window.livewire.on('set-data-editor', msg=>{
                if(msg != null){
                    //console.log(msg);
                    //console.log(typeof msg);
                    CKEditor.setData(msg);
                }else{
                    CKEditor.setData('');
                }

            });
        });

        function saveNoteTask(){
            //console.log(CKEditor.getData());
            window.livewire.emit('saveNoteTask',CKEditor.getData());
        }

</script>
@endpush

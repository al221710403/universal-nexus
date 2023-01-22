@props(['item'])

{{-- Elemento --}}
{{-- <article class="relative overflow-hidden rounded-lg h-56 shadow-2xl "> --}}
    <article class="rounded-sm shadow-2xl w-full h-80 bg-cover bg-center relative">

        <div x-data="{ option:false }"
            class="absolute z-10 top-0 text-white flex flex-row flex-wrap text-xs font-bold italic">
            <span class="cursor-pointer text-lg font-bold px-1" title="Opciones" x-on:click="option = !option">
                <i class='bx bx-dots-vertical-rounded'></i>
            </span>
            <div class="absolute top-6 left-1 bg-white rounded-lg shadow-2xl text-gray-600 text-sm font-normal" x-cloak
                x-show="option">
                <ul>
                    <li>
                        <button class="w-full p-2 flex hover:font-bold hover:text-green-500 hover:shadow-lg">
                            <span class="mr-2"><i class='bx bxs-edit-alt'></i></span>
                            Editar
                        </button>
                    </li>
                    <li class="mt-2">
                        <button class="p-2 flex hover:font-bold hover:text-red-500 hover:shadow-lg">
                            <span class="mr-2"><i class='bx bxs-trash'></i></span>
                            Eliminar
                        </button>
                    </li>
                </ul>
            </div>
        </div>
        {{-- Generos --}}
        {{-- <div class="absolute z-10 top-0 pl-2 pt-2  text-white flex flex-row flex-wrap text-xs font-bold italic">
            <a href="#" class="bg-blue-500 py-1 px-2 rounded-xl mr-1 mb-1 hover:bg-blue-800">
                <i class="fas fa-tag mr-0.5"></i> Remance
            </a>
        </div> --}}

        {{-- Fondo --}}
        <a href="#" class="h-full w-full inline-block card-effect">
            {{-- Imagen del juego --}}
            <figure class="w-full h-full">
                <img src="{{$item->featured_image}}" alt="Fondo" onerror="this.src='/static/img/bg/not-image.jpg';"
                    class="w-full h-full" loading="lazy">
            </figure>
            <div class="absolute bg-blue-300 opacity-50 top-0 left-0 h-full w-full z-0 card--background__opacity"></div>
        </a>

        <div class="absolute h-1/3 w-full bottom-0">
            <div class="relative text-white h-full">
                <div class="absolute bg-gray-900 opacity-80 top-0 left-0 h-full w-full z-0"></div>

                {{-- Titulo del juego --}}
                <div class="relative top-0 font-semibold text-base w-full z-10 px-2">
                    <a href="#" class="grid grid-rows-2 hover:text-yellow-500" title="{{$item->title}}">
                        <span class="truncate tracking-wide">{{Str::limit($item->title, 40)}}</span>
                        <div class="flex justify-between items-center font-normal">
                            <span>
                                <i class='bx bxs-cube-alt'></i>
                                mmk
                            </span>
                            <time datetime=" {{$item->created_at}} ">
                                {{ Carbon\Carbon::parse($item->created_at)->isoFormat('D MMMM') }}
                                <i class='bx bxs-calendar'></i>
                            </time>
                        </div>
                    </a>
                </div>

                {{-- Usuario que subio el juego --}}
                <div class="relative flex flex-wrap w-full items-center z-10 px-2 text-yellow-500">
                    {{-- @for ($i = 0; $i < 5; $i++) @if ($i < $item->qualification)
                        <span><i class='bx bxs-star'></i></span>
                        @else
                        <span><i class='bx bx-star'></i></span>
                        @endif
                        @endfor --}}
                </div>
            </div>
        </div>
    </article>

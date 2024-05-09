{{--  @props(['busqueda','results'])  --}}

<div class="my-auto block p-2 pl-10 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-gray-500 focus:border-gray-500">
    <button class="hidden w-full px-3 py-1 ml-5 text-sm text-left md:inline-block" wire:click="$set('my_posts', true)">
        Buscar artículo <code class="text-xs italic font-semibold border border-gray-500 rounded-lg ml-2 py-1 px-1.5"> Ctrl + B</code>
    </button>
</div>

{{--  <x-jet-modal {{ $attributes }}>
    <div class="relative bg-white">
        <div class="h-16">
            <button class="absolute px-3 py-1 ml-5 text-sm text-left top-2 right-2" x-on:click="show = false">
                <code class="text-xs italic font-bold border-2 border-gray-300 rounded-lg ml-2 py-1 px-1.5">esc</code>
            </button>

            <input type="text" name="search" id="search" placeholder="Buscar juego" wire:model.debounce.10ms="search"
            class="w-2/3 h-full pl-8 ml-8 font-semibold text-gray-500 border-0 focus:outline-none" autocomplete="off">
            <svg class="text-gray-300 w-7 h-7 absolute left-2.5 top-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>

        <hr/>

        <div class="px-6 py-4">

            @if ($busqueda)
                <h3 class="text-gray-500 font-semibold text-base mb-1.5">Resultados encontrados:</h3>
                <ul>
                    @forelse ($results as $result)
                        <li class="rounded-lg py-1.5 bg-gray-200 text-gray-600 text-justify leading-snug md:leading-10 px-2 italic font-semibold text-sm md:text-base cursor-pointer hover:bg-gray-300 mb-2">
                            <a href="{{ route('game.showGame', $result) }}" class="flex items-center">
                                <span class="inline-block w-2 h-2 m-2 bg-green-500 rounded-full"></span>
                                 # {{ $result->name }} v{{ $result->version }}
                            </a>
                        </li>
                    @empty
                        <li class="text-sm font-semibold leading-10 text-gray-500">Noy hay resultados que conincidan con: <span class="text-base italic font-bold">{{$busqueda}}</span> </li>
                    @endforelse
                </ul>
            @else
                <h3 class="text-gray-500 font-semibold text-sm md:text-base mb-1.5">Ingrese el nombre del juego que desee búscar</h3>
            @endif
        </div>
    </div>


</x-jet-modal>  --}}

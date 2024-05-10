@props(['busqueda','results'])

<div class="my-auto block p-2 pl-10 text-sm text-gray-500 bg-gray-50 rounded-lg border border-gray-300 focus:ring-gray-500 focus:border-gray-500">
    <button class="text-left w-full flex justify-between items-center" wire:click="$set('search_post', true)">
        Buscar artículo <code class="text-xs text-gray-400 italic font-semibold border border-gray-400 rounded-lg ml-2 py-1 px-1.5"> Ctrl + B</code>
    </button>
</div>

<x-jet-modal {{ $attributes }}>
    <div class="relative bg-white">
        <div class="h-14 flex items-center">
            <button class="absolute px-3 py-1 ml-5 text-sm text-left top-2 right-2" x-on:click="show = false">
                <code class="text-xs italic font-bold border-2 border-gray-300 rounded-lg ml-2 py-1 px-1.5">esc</code>
            </button>

            <input type="text" name="search" id="search" placeholder="Buscar artículo" wire:model.debounce.300ms="search"
            class="w-2/3 h-full pl-8 ml-8 text-gray-500 border-0 focus:outline-none" autocomplete="off">

            <svg class="text-gray-300 w-6 h-6 absolute left-2.5 top-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>

        <hr/>

        <div class="px-6 py-4">

            @if ($busqueda)
                <ul>
                    @forelse ($results as $post)
                        <li class="rounded-lg py-1.5 bg-gray-100 text-gray-600 text-justify leading-snug md:leading-10 px-2 text-sm md:text-base cursor-pointer hover:bg-blue-600 hover:text-gray-100 mb-2 flex flex-col search-content">
                            <a href="{{ route('publish.posts.show', $post->slug) }}">
                                <div class="flex justify-start items-center text-base mr-1">
                                    <span class="mr-1"><i class='bx bxl-slack-old'></i></span>
                                    <span class="inline-block w-full">{!! $post->title !!}</span>
                                </div>
                                @if(strpos($post->body, '<span class="search-term">') !== false)
                                    @php
                                        // Obtener la posición de la primera coincidencia
                                        $position = strpos($post->body, '<span class="search-term">');

                                        // Extraer un fragmento del texto que contenga la coincidencia y un máximo de 100 palabras antes de ella
                                        $startPosition = max(0, $position - 30); // Calcular la posición de inicio del fragmento
                                        $excerpt = substr($post->body, $startPosition, $position + 100 - $startPosition); // Extraer el fragmento de texto

                                        // Eliminar etiquetas HTML adicionales para evitar problemas de formato
                                        $excerpt = strip_tags($excerpt, '<span>'); // Eliminar todas las etiquetas HTML excepto <span>
                                    @endphp
                                    <div class="ml-4">
                                        <hr>
                                        <div class="truncate">{!! $excerpt !!}</div>
                                    </div>
                                @endif
                            </a>
                        </li>
                    @empty
                        <li class="text-sm font-semibold leading-10 text-gray-500">Noy hay resultados que conincidan con: <span class="text-base italic font-bold">{{$busqueda}}</span> </li>
                    @endforelse
                </ul>
            @else
                <h3 class="text-gray-500 font-semibold text-sm md:text-base mb-1.5">Ingrese el nombre del artículo que desee buscar.</h3>
            @endif
        </div>
    </div>


</x-jet-modal>

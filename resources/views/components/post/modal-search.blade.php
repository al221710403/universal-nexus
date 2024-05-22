@props(['busqueda','results'])
@php
    function strip_tags_except_search_term($text) {
        // Guardar las etiquetas <span class="search-term"> en un marcador temporal
        $text = preg_replace('/<span class="search-term">(.*?)<\/span>/is', '###SPAN###$1###ENDSPAN###', $text);

        // Eliminar todas las etiquetas HTML restantes
        $text = strip_tags($text);

        // Restaurar las etiquetas <span class="search-term">
        $text = preg_replace('/###SPAN###(.*?)###ENDSPAN###/is', '<span class="search-term">$1</span>', $text);

        return $text;
    }

    function highlight($text, $needle, $tag = 'span') {
        // Tokenizar el texto
        $tokens = explode(' ', $text);
        $highlightedText = '';

        // Recorrer cada palabra y resaltar si coincide con la aguja
        foreach ($tokens as $token) {
            if (strpos($token, $needle) !== false) {
                // La palabra coincide con la aguja, resaltarla
                $highlightedText .= "<$tag class='search-term'>$token</$tag> ";
            } else {
                // La palabra no coincide, mantenerla sin resaltar
                $highlightedText .= "$token ";
            }
        }

        return $highlightedText;
    }

@endphp

<div class="my-auto block p-2 pl-10 text-sm text-gray-500 bg-gray-50 rounded-lg border border-gray-300 focus:ring-gray-500 focus:border-gray-500">
    <button class="text-left w-full flex justify-between items-center" wire:click="$set('search_post', true)">
        Buscar artículo <code class="text-xs text-gray-400 italic font-semibold border border-gray-400 rounded-lg ml-2 py-1 px-1.5"> Ctrl + B</code>
    </button>
</div>

<x-jet-modal {{ $attributes }} keydown="Ctrl.B">
    <div class="relative bg-white">
        <div class="h-14 flex items-center">
            <button class="absolute px-3 py-1 ml-5 text-sm text-left top-2 right-2" x-on:click="show = false" wire:click="$set('search_post', false)">
                <code class="text-xs italic font-bold border-2 border-gray-300 rounded-lg ml-2 py-1 px-1.5">esc</code>
            </button>
            <span class="text-2xl absolute top-2 right-16" wire:loading wire:target="search">
                <i class='bx bx-loader-circle bx-burst bx-rotate-90' ></i>
            </span>

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
                @forelse ($results as $post)
                    <ul>
                        <li class="rounded-lg py-1.5 bg-gray-100 text-gray-600 text-justify leading-snug md:leading-10 px-2 text-sm md:text-base cursor-pointer hover:bg-blue-600 hover:text-gray-100 mb-2 flex flex-col search-content">
                            <a href="{{ route('publish.posts.show', $post->slug) }}">
                                <div class="flex justify-start items-center text-base mr-1">
                                    <span class="mr-1"><i class='bx bxl-slack-old'></i></span>
                                    <span class="inline-block w-full">{!! $post->title !!}</span>
                                </div>
                                @if(strpos($post->body, '<span class="search-term">') !== false)
                                    @php
                                        // Eliminar etiquetas HTML adicionales para evitar problemas de formato
                                        // excepto <span> con la clase search-term
                                        $tagExtraction = strip_tags_except_search_term($post->body);

                                        // Obtener la posición de la primera coincidencia
                                        $position = strpos($tagExtraction, '<span class="search-term">');

                                        // Extraer un fragmento del texto que contenga la coincidencia y un máximo de 100 palabras antes de ella
                                        $startPosition = max(0, $position - 30); // Calcular la posición de inicio del fragmento
                                        $excerpt = substr($tagExtraction, $startPosition, $position + 100 - $startPosition); // Extraer el fragmento de texto
                                    @endphp
                                    <div class="ml-4">
                                        <hr>
                                        <div class="truncate">{!! $excerpt !!}</div>
                                    </div>
                                @endif

                                @php
                                    // Decodificar la cadena JSON
                                    $metadata = json_decode($post->metadata, true);
                                    //dd($metadata);

                                    // Comprobar si existe el arreglo "keywords" y si no está vacío
                                    $keywordsExisten = isset($metadata['keywords']) && !empty($metadata['keywords']);
                                @endphp

                                @if ($keywordsExisten)
                                    <section>
                                        <ul class="my-1 w-3/4 ml-8">
                                            @foreach ($metadata['keywords'] as $keyword)
                                                @if (strpos($keyword, $busqueda) !== false)
                                                    <li class="p-1 text-base flex items-center">
                                                        <span class="mr-1"><i class='bx bxs-label'></i></span>
                                                        <p class="inline-block w-full">{!! highlight($keyword, $busqueda) !!}</p>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </section>
                                @endif
                            </a>
                        </li>
                    </ul>
                @empty
                <div class="mx-auto py-2 mb-3 text-gray-700 px-3">
                        <p class="text-sm text-center font-semibold leading-10 text-gray-500"> <span><i class='bx bxs-tag-x bx-rotate-180' ></i></span> No hay resultados que coincidan con tu búsqueda. ¿Quieres intentarlo de nuevo? </p>
                        <img src="{{ asset('img/search.svg') }}" class="w-64 h-60 mx-auto" alt="not_search">
                    </div>
                @endforelse

            @else
                <div class="mx-auto py-2 mb-3 text-gray-700 px-3">
                    <p class="text-gray-500 text-base mb-3 text-center">Ingresa la palabra que desees buscar.</p>
                    <img src="{{ asset('img/articles.svg') }}" class="w-64 h-60 mx-auto" alt="not search">
                </div>
            @endif
        </div>
    </div>



</x-jet-modal>

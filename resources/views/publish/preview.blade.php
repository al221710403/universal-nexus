@extends('layouts.empty')

@section('styles')
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap');
    </style>
    <link rel="stylesheet" href="{{ asset('vendor/prism/prism.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ckeditor_base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ckeditor_view.css') }}">
    <style>
        .ck-content ul,
        .ck-content ol{
            --tw-text-opacity: 1;
            color: rgb(82 82 82 / var(--tw-text-opacity));
            margin-block-start: 1em;
            margin-block-end: 1em;
            margin-inline-start: 0px;
            margin-inline-end: 0px;
            padding-inline-start: 40px !important;
            unicode-bidi: isolate;
            list-style-type: initial;
        }

        .ck-content ol{
            list-style-type: decimal;
        }
    </style>
@endsection

@section('content')
<div class="container mx-auto py-4 mb-4">
    <div class="mb-2">
        <section class="flex justify-between p-4 bg-white rounded-lg shadow-lg">
            <h2 class="text-xl font-bold text-gray-700"> <span><i class='bx bxs-label'></i></span>
                {{$dataJson["title"]}}
            </h2>
        </section>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{--  Seccion del Post  --}}
        <article class="lg:col-span-2 bg-white rounded-md shadow-lg p-3 relative">
            {{--  Sección de Tags  --}}
            @if ($post->tags->count() > 0)
                <section class="flex flex-wrap mb-2">
                    @foreach ($post->tags as $tag)
                    <span class="inline-blog text-xs font-semibold px-2.5 py-0.5 mt-2 mr-2 h-6 bg-blue-100 text-indigo-500 rounded-md">
                        {{$tag->name}}
                    </span>
                    @endforeach
                </section>
                <hr class="mt-1 md:mb-2" />
            @endif

            {{--  Span que muestra si el post es público o privado esto solo si eres el dueño del post  --}}
            @if ( Auth::user()->id == $post->author->id )
                <span class="absolute z-20 top-0 right-0  bg-gray-400 text-white px-2 py-1">
                    {{$post->public ? 'Público' : 'Privado'}}
                </span>
            @endif

            {{--  Muestra el titulo dependiendo si tiene imagen o no  --}}
            @if ($post->featured_image != 'noimg.png')
                <div class="mb-4 md:mb-0 w-full mx-auto relative h-80 text-base">
                    <div class="absolute left-0 bottom-0 w-full h-full z-10"
                        style="background-image: linear-gradient(180deg,transparent,rgba(0,0,0,.7));"></div>
                    <img src="{{Storage::url($post->featured_image)}}"
                        class="absolute left-0 top-0 w-full h-full z-0 object-cover" />
                    <div class="p-4 absolute bottom-0 left-0 z-20">
                        <h1 class="text-5xl font-semibold text-gray-100 leading-tight">
                            {{$post->title}}
                        </h1>
                        <div class="flex mt-3">
                            <img src="{{$post->author->profile_photo_url}}" class="h-10 w-10 rounded-full mr-2 object-cover"
                                alt="{{$post->author->name}}" />
                            <div>
                                <p class="font-semibold text-gray-200 text-sm"> {{$post->author->name}} </p>
                                <p class="font-semibold text-gray-400 text-xs">
                                    <time datetime=" {{$post->publish_date}}">
                                        <i class='bx bxs-calendar'></i>
                                        {{ Carbon\Carbon::parse($post->publish_date)->isoFormat('D MMMM') }}
                                    </time>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="mb-2 md:mb-0 w-full mx-auto pb-1">
                    <h1 class="text-5xl my-6 font-semibold text-gray-800 leading-tight text-center w-full inline-block">
                        {{$post->title}}
                    </h1>
                    <hr class="mt-1" />
                    <ul class="flex justify-between mt-1">
                        <li class="flex items-center">
                            <img src="{{$post->author->profile_photo_url}}" class="mr-1 h-6 w-6 rounded-full object-cover"
                                alt="{{$post->author->name}}" />
                            <p class="font-semibold text-gray-400 text-xs"> {{$post->author->name}} </p>
                        </li>
                        <li class="font-semibold text-gray-400 text-xs flex items-center">
                            <time datetime=" {{$post->publish_date}}">
                                <i class='bx bxs-calendar'></i>
                                {{ Carbon\Carbon::parse($post->publish_date)->isoFormat('D MMMM') }}
                            </time>
                        </li>
                    </ul>
                </div>
            @endif

            {{--  Contenido del Post  --}}
            <div class="ck-editor__main">
                <div class="ck-content mt-2">
                    {!!$post->body!!}
                </div>
            </div>
        </article>

        {{-- Tabla de contenido --}}
        <aside class="relative">
            <section class="bg-white rounded-md shadow-lg py-4 px-5 sticky top-1" id="containerTableOfContents">
                <h2 class="text-xl font-semibold text-gray-700">Tabla de Contenido</h2>
                <div id="tableOfContents">
                </div>

                <p class="text-red-700 text-sm leading-6 mt-2" id="notify">No ahí titulos para generar una tabla de contenidos.</p>

            </section>
        </aside>
    </div>
</div>

@endsection

@section('scripts')
    <script src="{{ asset('vendor/prism/prism.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const preElements = document.querySelectorAll('pre');
            preElements.forEach(function(preElement) {
                const copyIcon = document.createElement('span');
                copyIcon.innerHTML = '<i class="bx bx-copy-alt"></i>'; // Ícono de copiado (Unicode)
                copyIcon.className = 'copy-icon flex'; // Clase para estilos CSS
                copyIcon.title = 'Copiar al portapapeles'; // Texto de información
                preElement.appendChild(copyIcon);
                copyIcon.addEventListener('click', function() {
                    copyToClipboard(preElement.textContent);
                    // Cambia el ícono a la marca de verificación durante 2 segundos
                    copyIcon.innerHTML = '<i class="bx bxs-check-circle bx-burst text-green-500"></i>';
                    //copyIcon.innerHTML = '<span class="inline-blog text-base font-semibold text-green-500 px-2">Copiado</span> <i class="bx bxs-check-circle bx-burst text-green-500"></i>';
                    setTimeout(function() {
                        copyIcon.style.opacity = '0'; // Desvanece gradualmente
                        setTimeout(function() {
                            copyIcon.style.opacity = '1'; // Vuelve a mostrar el ícono original
                            copyIcon.innerHTML = '<i class="bx bx-copy-alt"></i>';
                        }, 500); // 500 ms = 0.5 segundos
                    }, 4000); // 2000 ms = 2 segundos
                });
            });
        });


        function copyToClipboard(text) {
            const tempInput = document.createElement('input');
            tempInput.value = text;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Obtener el contenido del elemento <div>
            // Identificar las etiquetas de título
            const divContent = document.querySelector('.ck-content');
            const titles = divContent.querySelectorAll('h2, h3, h4, h5');

            if(titles.length > 0) {
                // Obtener el elemento por su ID
                const notify = document.getElementById('notify');

                // Verificar si se encontró el elemento
                if (notify) {
                    // Obtener el padre del elemento a eliminar
                    const padreElemento = notify.parentNode;

                    // Eliminar el elemento del DOM
                    padreElemento.removeChild(notify);
                } else {
                    console.error('No se pudo encontrar el elemento con el ID especificado.');
                }

                //Crea el elemento de lista ul y agrega los estilos y asigna un ID
                const tableOfContents = document.createElement('ul');
                tableOfContents.classList.add('text-slate-700', 'text-sm', 'leading-6','mt-2');// Agrega tu clase aquí
                tableOfContents.id = "tableOfContents";

                // Iterar sobre las etiquetas de título y asignarles un id y
                // Generar la tabla de contenido
                titles.forEach((title, index) => {
                    // Obtener el contenido de la etiqueta de título
                    const titleContent = title.textContent.trim();

                    // Reemplazar espacios en blanco y caracteres especiales para obtener un id válido
                    const id = titleContent.replace(/\s+/g, '-').toLowerCase();

                    // Asignar el id a la etiqueta de título
                    title.id = id;

                    const level = parseInt(title.tagName.toLowerCase().replace('h', ''), 10);
                    const listItem = document.createElement('li');
                    const link = document.createElement('a');
                    listItem.classList.add('py-0.5');
                    link.classList.add('hover:text-blue-600');
                    link.href = `#${title.id || `title-${index + 1}`}`;
                    link.textContent = title.textContent;
                    listItem.appendChild(link);

                    // Calcular el padding-left basado en el nivel
                    const paddingLeft = level - 2; // 5px por nivel
                    link.style.paddingLeft = `${paddingLeft}rem`;


                    tableOfContents.appendChild(listItem);
                });

                // Agregar la tabla de contenido al DOM (por ejemplo, dentro de un elemento con id "toc")
                const tocContainer = document.getElementById('tableOfContents');

                tocContainer.appendChild(tableOfContents);
            }
        });
    </script>

    <script>
        const tableOfContents = document.getElementById('tableOfContents');
        const divElements = document.querySelector('.ck-content');
        const sections = divElements.querySelectorAll('h2, h3, h4, h5');

        window.addEventListener('scroll', () => {
            const currentSection = Array.from(sections).find(section => {
                const rect = section.getBoundingClientRect();
                return rect.top <= window.innerHeight / 2 && rect.bottom >= window.innerHeight / 2;
            });

            if (currentSection) {
                // Elimina la clase "text-blue-600" de todos los enlaces
                tableOfContents.querySelectorAll('a').forEach(link => {
                link.classList.remove('text-blue-600');
                });

                // Agrega la clase "text-blue-600" al enlace correspondiente
                const link = tableOfContents.querySelector(`[href="#${currentSection.id}"]`);
                if (link) {
                link.classList.add('text-blue-600');
                }
            }
        });
    </script>
@endsection

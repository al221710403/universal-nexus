@push('styles')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Alfa+Slab+One&family=Antic+Didone&family=Bebas+Neue&family=Berkshire+Swash&family=Caveat:wght@400..700&family=Cedarville+Cursive&family=Cinzel+Decorative:wght@400;700;900&family=Cinzel:wght@400..900&family=Comfortaa:wght@300..700&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Dancing+Script:wght@400..700&family=Indie+Flower&family=Italiana&family=La+Belle+Aurore&family=League+Script&family=Lobster&family=Lobster+Two:ital,wght@0,400;0,700;1,400;1,700&family=Montserrat+Subrayada:wght@400;700&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Noto+Serif+Georgian:wght@100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Pacifico&family=Raleway:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Shadows+Into+Light+Two&display=swap');
    </style>

    <link rel="stylesheet" href="{{ asset('plugins/ckeditor/ckeditor_base.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/ckeditor/ckeditor_view.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/prism/prism.css') }}">

@endpush

<div class="container mx-auto py-4 mb-4">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

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
                <span class="absolute z-20 top-0 right-0  bg-blue-500 text-white px-2 py-1">
                    {{$post->public ? 'Público' : 'Privado'}}
                </span>
            @endif

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

            <div class="ck-editor__main">
                <div class="ck-content mt-2">
                    {!!$post->body!!}
                </div>
            </div>

            @if (!empty($keywords))
            <hr>
                <section class="pl-4 mt-1.5">
                    <header class="text-2xl font-semibold text-gray-700"># Palabras clave</header>
                    <ul class="w-3/4 px-4 mt-1">
                        @foreach ($keywords as $word)
                            <li class="text-gray-500 p-1 text-base border-b flex items-center">
                                <span class="mr-1"><i class='bx bxl-slack-old'></i></span>
                                <p class="inline-block w-full">{{ $word }}</p>
                            </li>
                        @endforeach
                    </ul>
                </section>
            @endif
        </article>

        {{-- Articulos similares --}}
        <aside class="relative">
            <section class="bg-white rounded-md shadow-lg py-4 px-5 sticky top-1 z-10" id="containerTableOfContents">
                <h2 class="text-xl font-semibold text-gray-700">Tabla de Contenido</h2>
                <div id="tableOfContents">
                </div>
            </section>

             {{-- Articulos similares --}}
            <section id="otherPosts">
                <h2 class="text-xl font-semibold text-gray-600 mb-4">
                    Artículos similares
                </h2>

                <ul>
                    @forelse ($similares as $item)
                        <li class="mb-4 h-32 overflow-hidden bg-white shadow-lg">
                            <a href="{{ route('publish.posts.show', $item->slug) }}" class="flex" title="{{$item->title}}">
                                <img class="w-36 h-32 object-cover object-center" src="{{Storage::url($item->featured_image)}}"
                                    alt="portada: {{$item->title}}">
                                <div class="flex-1 ml-2 flex flex-col overflow-hidden py-1">
                                    <h3 class="block mb-1 text-gray-700 font-semibold text-base truncate">
                                        {{-- {{Str::limit($item->title,
                                        30)}} --}}
                                        {{$item->title}}
                                    </h3>
                                    <p class="text-clip max-w-full max-h-32 text-sm flex-1 flex-wrap">
                                        {{$item->featured_image_caption}}
                                    </p>
                                </div>
                            </a>
                        </li>
                    @empty
                        <li>
                            No ahí artículos similares
                        </li>
                    @endforelse
                </ul>
            </section>
        </aside>

    </div>
    <div id="back-to-top" class="back-to-top">
        <span class="text-2xl"><i class='bx bxs-up-arrow-alt'></i></span>
    </div>

</div>


@push('scripts')
    <script src="{{ asset('plugins/prism/prism.js') }}"></script>

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
                const otherPosts = document.getElementById('otherPosts');
                otherPosts.classList.add('mt-5');

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
                    const textItem = document.createElement('p');
                    const link = document.createElement('a');

                    listItem.classList.add('py-0.5');
                    link.classList.add('hover:text-blue-600');
                    link.href = `#${title.id || `title-${index + 1}`}`;

                    // Añadir el texto
                    link.textContent = title.textContent;

                    // Añadir el enlace <a> al <p> y luego al <li>
                    textItem.appendChild(link);
                    listItem.appendChild(textItem);


                    // Calcular el padding-left basado en el nivel
                    const paddingLeft = level - 2; // 5px por nivel
                    textItem.style.paddingLeft = `${paddingLeft}rem`;


                    tableOfContents.appendChild(listItem);
                });

                // Agregar la tabla de contenido al DOM (por ejemplo, dentro de un elemento con id "toc")
                const tocContainer = document.getElementById('tableOfContents');

                tocContainer.appendChild(tableOfContents);
            }else{
                // Obtener el elemento por su ID
                const elementoEliminar = document.getElementById('containerTableOfContents'); // Reemplaza 'tu-id-a-eliminar' con el ID del elemento que deseas eliminar

                // Verificar si se encontró el elemento
                if (elementoEliminar) {
                    // Obtener el padre del elemento a eliminar
                    const padreElemento = elementoEliminar.parentNode;

                    // Eliminar el elemento del DOM
                    padreElemento.removeChild(elementoEliminar);
                } else {
                    console.error('No se pudo encontrar el elemento con el ID especificado.');
                }
            }

            //console.log(titles);
            //console.log(titles.length);
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

    {{--  Botón de desplazamiento hacia arriba  --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const backToTopButton = document.getElementById('back-to-top');

            window.addEventListener('scroll', function () {
                if (window.scrollY > 200) {
                    backToTopButton.classList.add('show');
                } else {
                    backToTopButton.classList.remove('show');
                }
            });

            backToTopButton.addEventListener('click', function () {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        });

    </script>
@endpush

@push('styles')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Alfa+Slab+One&family=Antic+Didone&family=Bebas+Neue&family=Berkshire+Swash&family=Caveat:wght@400..700&family=Cedarville+Cursive&family=Cinzel+Decorative:wght@400;700;900&family=Cinzel:wght@400..900&family=Comfortaa:wght@300..700&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Dancing+Script:wght@400..700&family=Indie+Flower&family=Italiana&family=La+Belle+Aurore&family=League+Script&family=Lobster&family=Lobster+Two:ital,wght@0,400;0,700;1,400;1,700&family=Montserrat+Subrayada:wght@400;700&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Noto+Serif+Georgian:wght@100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Pacifico&family=Raleway:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Shadows+Into+Light+Two&display=swap');
    </style>

    <link rel="stylesheet" href="{{ asset('plugins/tagify/tagify.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/ckeditor/ckeditor_base.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/ckeditor/ckeditor_create.css') }}">

@endpush

    <div class="container mx-auto py-4 mb-4" x-data>
        <div wire:loading wire:target="save,saveSetting,deletePost,publishedPost,preview,featured_image"
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


        {{--  Sección del encabezado  --}}
        <div class="mb-2" x-data="{ open: false }">
            <section class="flex justify-between p-4 bg-white rounded-lg shadow-lg">
                <h2 class="text-xl font-bold text-gray-700"> <span><i class='bx bxs-label'></i></span> {{$labelAction}}
                    <span class="ml-4 text-gray-500 text-base">Draft</span>
                </h2>
                <ul class="flex text-xl text-gray-700">
                    @if (!$published)
                        <li class="mr-3">
                            <button wire:click="$set('published_modal', true)"
                                class="btn-mdl text-xs rounded-lg border border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white px-2 py-1"
                                title="Publicar Post" data-action="open">
                                Publicar
                            </button>
                        </li>
                    @endif

                    <li class="mr-3">
                        <button wire:click="save" x-data="shortcutHandler" x-on:keydown.ctrl.shift.s.window="save" class="hover:text-indigo-700" title="Guardar">
                            <i class='bx bxs-save'></i>
                        </button>
                    </li>
                    <li class="mr-3">
                        <span class="btn-mdl hover:text-indigo-700 cursor-pointer" wire:click="preview"
                            title="Vista previa">
                            <i class='bx bxs-low-vision'></i>
                        </span>
                    </li>

                    <li class="mr-3">
                        <a href="{{ route('publish.posts.index') }}" class=" hover:text-indigo-700" title="Regresar">
                            <i class='bx bxs-log-out-circle'></i>
                        </a>
                    </li>

                    <li class="mr-3">
                        <button onclick="Confirm('el post','deletePost')" class="hover:text-red-700" title="Eliminar">
                            <i class='bx bxs-trash'></i>
                        </button>
                    </li>

                    <li>
                        <button wire:click="$set('settings', true)" data-action="open" class="btn-mdl hover:text-indigo-700"
                            title="Ajustes">
                            <i class='bx bxs-cog'></i>
                        </button>
                    </li>
                </ul>
            </section>

            @include('livewire.publish.post.parts.modal-settings')
            @include('livewire.publish.post.parts.modal-published')
            @include('livewire.publish.post.parts.modal-recovery-file')
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{--  Sección de la creación del post  --}}
            <div class="lg:col-span-2 bg-white rounded-md shadow-lg p-3 relative">

                <p class="bg-white shadow-lg absolute rounded-full text-2xl text-blue-600 px-2 py-1 -top-2 -right-2">
                    <span>
                        <i class='bx bxs-pencil bx-tada'></i>
                    </span>
                </p>
                <form action="">
                    <div>
                        <input id="title" type="text" wire:model="title" placeholder="New Title"
                            class="w-full border-0 text-5xl font-semibold text-gray-800 leading-tight text-center">
                        <x-jet-input-error for="title" />
                    </div>


                    <div class="mt-4" wire:ignore wire:key="CKEditorBody">
                        <div id="editor">
                            {!! $body !!}
                        </div>
                    </div>

                </form>

            </div>

            {{-- Artículos similares --}}
            <aside>
                <h2 class="text-xl font-bold text-gray-600 mb-4">
                    Post similares
                </h2>

                <ul>
                    @forelse ($similares as $item)
                        <li class="mb-4 h-32 overflow-hidden bg-white shadow-lg">
                            <a href="{{ route('publish.posts.show', $item->slug) }}" class="flex" title="{{$item->title}}">
                                <img class="w-36 h-32 object-cover object-center" src="{{Storage::url($item->featured_image)}}"
                                    alt="portada: {{$item->title}}">
                                <div class="flex-1 ml-2 flex flex-col overflow-hidden py-1">
                                    <h3 class="block mb-1 text-gray-700 font-semibold text-base truncate">
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
            </aside>
        </div>

        <div id="back-to-top" class="back-to-top">
            <span class="text-2xl"><i class='bx bxs-up-arrow-alt'></i></span>
        </div>

    </div>

@push('scripts')
    <script src="{{ asset('vendor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>
    <script src="{{ asset('plugins/tagify/tagify.js') }}"></script>
    <script src="{{ asset('plugins/tagify/tagify.polyfills.min.js') }}"></script>

    {{-- Inicialización CkEditor   --}}
    <script>
        const inputTitle = document.getElementById('title');
        let autosaveTimeout; // Variable para almacenar el ID del timeout

        inputTitle.addEventListener('input', () => {
            // Cancelar el timeout anterior (si existe)
            clearTimeout(autosaveTimeout);

            // Configurar un nuevo timeout para ejecutar la función después de 1 segundo
            autosaveTimeout = setTimeout(() => {
                window.livewire.emit('autoSaveBlog');
            }, 15000); // Espera 15 segundo después de que el usuario deje de escribir
        });

        ClassicEditor
            .create( document.querySelector( '#editor' ),{
                mediaEmbed: {
                    previewsInData:true
                },
                simpleUpload: {
                    // The URL that the images are uploaded to.
                    uploadUrl: "{{ route('publish.posts.image.uplodad') }}",
                },
                placeholder: 'My custom placeholder for the body'
            } )
            .then( function(editor){
                editor.model.document.on( 'change:data', () => {
                    @this.set('body',editor.getData());

                    // Cancelar el timeout anterior (si existe)
                    clearTimeout(autosaveTimeout);

                    // Configurar un nuevo timeout para ejecutar la función después de 1 segundo
                    autosaveTimeout = setTimeout(() => {
                        window.livewire.emit('autoSaveBlog');
                    }, 1000); // Espera 15 segundo después de que el usuario deje de escribir
                    //15000
                });
            })
            .catch( error => {
                console.error( error );
            } );
    </script>

    {{--  Funciones del tag  --}}
    <script>
        // The DOM element you wish to replace with Tagify
        var input = document.querySelector('input[name=tags]');
        var tagify = new Tagify(input, {
            addTagOnBlur: false,
            dropdown: {
                maxItems: 5,
                enabled: 1,
            },
            whitelist:@json($all_tags),
        });

        tagify.addTags(@json($tags));

        tagify.on('change', (e) => {
            const tags = [];
            const parts = e.detail.value ? JSON.parse(e.detail.value) : [];

            parts.forEach((item) => {
                tags.push(item.value);
            });

            //console.log(tags);
            @this.set('tags', tags);
        });

    </script>

    {{--  Funciones del preview  --}}
    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.on('previewPost', url => {
                window.open(url, '_blank');
            });
        });
    </script>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('shortcutHandler', () => ({
                init() {
                    this.$watch('show', value => {
                        if (value) {
                            console.log('Show is true');
                        }
                    });
                },
                show: false,
                save() {
                    this.$wire.save();
                }
            }));
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

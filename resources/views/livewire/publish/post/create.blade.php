@push('scripts')
<style>
    .ck-content p>span {
        display: inline-block !important;
        float: left !important;
        padding-right: 0.75rem !important;
        max-width: 100% !important;
        min-width: 50% !important;
    }

    .ck-content p>span>img {
        height: 18rem !important;
        width: 100% !important;
    }
</style>
<link href="https://unpkg.com/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
@endpush


<div class="container mx-auto py-4 mb-4">
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
                    <button wire:click="save" class="hover:text-indigo-700" title="Guardar">
                        <i class='bx bxs-save'></i>
                    </button>
                </li>
                {{-- <li class="mr-3">
                    <button wire:click="$set('preview_modal', true)" class="btn-mdl hover:text-indigo-700"
                        title="Vista previa" data-action="open">
                        <i class='bx bxs-low-vision'></i>
                    </button>
                </li> --}}

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
        @include('livewire.publish.post.parts.modal-preview')

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 bg-white rounded-md shadow-lg p-3 relative">

            <p class="bg-white shadow-lg absolute rounded-full text-2xl text-blue-600 px-2 py-1 -top-2 -right-2">
                <span>
                    <i class='bx bxs-pencil bx-tada'></i>
                </span>
            </p>
            <form action="">
                <div>
                    <input type="text" wire:model="title" placeholder="New Title"
                        class="w-full border-0 text-3xl font-sans font-semibold text-gray-800">
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
</div>



@push('scripts')
<script src="{{ asset('vendor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>
<script src="{{ asset('vendor/prism/prism.js') }}"></script>
<script src="https://unpkg.com/@yaireo/tagify"></script>
<script src="https://unpkg.com/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>


<script>
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
            })
        })
        .catch( error => {
            console.error( error );
        } );

</script>


<script>
    // The DOM element you wish to replace with Tagify
    var input = document.querySelector('input[name=tags]');
    var tagify = new Tagify(input, {
      addTagOnBlur: false,
      dropdown: {
        enabled: 0,
        closeOnSelect: false,
      },
      whitelist:@json($all_tags),
      templates: {
        dropdownItem(item) {
          return `<div ${this.getAttributes(item)}
                  class='tagify__dropdown__item ${item.class ? item.class : ''}'
                  tabindex="0"
                  role="option">
          ${item.value}
          <button tabindex="0" data-value="${
            item.value
          }" class="ml-4 text-indigo-500">Agregar</button>
        </div>`;
        },
      },
      hooks: {
        suggestionClick(e) {
          var isAction = e.target.classList.contains('removeBtn'),
            suggestionElm = e.target.closest('.tagify__dropdown__item'),
            value = suggestionElm.getAttribute('value');

          return new Promise(function (resolve, reject) {
            if (isAction) {
              removeWhitelistItem(value);
              tagify.dropdown.refilter.call(tagify);
              reject();
            }
            resolve();
          });
        },
      },
    });

    tagify.addTags(@json($old_tags));

    tagify
    .on('change', (e) => {
        let parts = JSON.parse(e.detail.value);
        let tags = [];

        parts.forEach(function(item) {
            //console.log(item.value);
            tags.push(item.value);
        });
        console.log(tags);

        @this.set('tags',tags);
    })

    function removeWhitelistItem(value) {
      var index = tagify.settings.whitelist.indexOf(value);
      if (value && index > -1) tagify.settings.whitelist.splice(index, 1);
    }
</script>

@endpush

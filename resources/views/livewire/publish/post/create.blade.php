@push('scripts')
{{-- <style>
    .ck-editor__main h2 {
        color: red;
        font-size: 2rem;
    }

    .ck-editor__main p {
        color: blue;
    }
</style> --}}
<link href="https://unpkg.com/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />

@endpush


<div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4" x-data="{ open: false }">
        <section class="flex justify-between p-4 bg-white rounded-lg shadow-lg">
            <h2 class="text-xl font-bold text-gray-700"> <span><i class='bx bxs-label'></i></span> {{$labelAction}}
                <span class="ml-4 text-gray-500 text-base">Draft</span>
            </h2>
            <ul class="flex text-xl text-gray-700">
                <li class="mr-3">
                    <button wire:click="$set('published_modal', true)"
                        class="btn-mdl text-xs rounded-lg border border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white px-2 py-1"
                        title="Publicar Post" data-action="open">
                        Publicar
                    </button>
                </li>

                <li class="mr-3">
                    <button wire:click="save" class="hover:text-indigo-700" title="Guardar">
                        <i class='bx bxs-save'></i>
                    </button>
                </li>
                <li class="mr-3">
                    <button wire:click="$set('preview_modal', true)" class="btn-mdl hover:text-indigo-700"
                        title="Vista previa" data-action="open">
                        <i class='bx bxs-low-vision'></i>
                    </button>
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

                {{-- <li>
                    <button class="hover:text-indigo-700" title="Información">
                        <i class='bx bxs-info-circle'></i>
                    </button>
                </li> --}}

            </ul>
        </section>

        @include('livewire.publish.post.parts.modal-settings')
        @include('livewire.publish.post.parts.modal-published')
        @include('livewire.publish.post.parts.modal-preview')

    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
        <div class="p-4 bg-white rounded-lg shadow-lg relative">
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
                    <textarea id="editor" class="w-full h-96">{!! $body !!}</textarea>
                    <x-jet-input-error for="body" />
                </div>
            </form>
        </div>
    </div>

    <div class="text-indigo-500 hidden">
    </div>
</div>



@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>
<script src="https://unpkg.com/@yaireo/tagify"></script>
<script src="https://unpkg.com/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>

<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
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

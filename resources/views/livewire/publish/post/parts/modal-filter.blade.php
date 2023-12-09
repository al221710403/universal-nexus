<x-modal wire:model="filters" maxWidth="md" index="30">
    <x-slot name="title">
        Filtros
    </x-slot>

    <x-slot name="content">
        <div>
            <label for="author" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Seleccione un
                author</label>
            <select id="author" wire:model.defer="author_id"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                <option value="Elegir">Seleccione un author</option>
                @foreach ($authors_select as $author)
                <option value="{{$author->id}}">{{$author->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="mt-4">
            <label for="author" class="block mb-2 text-sm font-medium text-gray-900">Tags</label>
            <ul class="h-48 px-3 pb-3 overflow-y-auto flex flex-wrap text-sm text-gray-700 ">
                @foreach ($tags_select as $tag)
                <li>
                    <div class="flex items-center p-2 rounded hover:bg-gray-100">
                        <input id="{{$tag->id}}" type="checkbox" value="{{$tag->id}}" wire:model.defer="tags"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded text-sm focus:ring-2 hover:bg-slate-200">
                        <label for="{{$tag->id}}"
                            class="w-full ml-2 text-sm font-medium text-gray-900 rounded hover:text-blue-600">{{$tag->name}}
                            {{-- <span class="ml-1 rounded-md border border-gray-200 p-1">{{$tag->used}}</span> --}}
                        </label>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </x-slot>

    <x-slot name="footer">
        <button data-action="close" wire:click.prevent="saveFilters()" type="button"
            class="btn-mdl mr-0 md:mr-2 mt-2 md:mt-0 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Guardar
        </button>
        <button data-action="close" wire:click="$set('filters', false)" @click="show = false" type="button"
            class="btn-mdl px-3 py-2 text-sm tracking-wide text-white capitalize transition-colors duration-200 transform bg-red-400 rounded-md hover:bg-red-600 focus:outline-none focus:bg-red-500 focus:ring focus:ring-red-300 focus:ring-opacity-50">
            Cerrar
        </button>
    </x-slot>
    </x-modal.modal-lg>

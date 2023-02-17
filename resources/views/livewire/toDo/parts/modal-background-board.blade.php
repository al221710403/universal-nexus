<x-modal wire:model="changeBackgroundBoard" maxWidth="lg" close="closeViewBackgroundBoard">
    <x-slot name="title">
        Fondo de la lista
    </x-slot>

    <x-slot name="content">
        @if ($uploadBackground)
        <section>
            <header class="flex justify-between items-center mb-2">
                <h3 class="text-gray-600 text-lg">Subir imagen</h3>
                <div class="flex items-center justify-center">
                    <input id="add_bakground" type="checkbox" wire:model="uploadBackground"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 ">
                    <label for="add_bakground" class="ml-2 text-sm font-medium text-gray-900 ">
                        Subir imagen
                    </label>
                </div>
            </header>
            <hr />
            <div class="mt-2 grid grid-cols-1 md:grid-cols-3 gap-3 pt-2">
                <div class="col-span-2">
                    @if ($link)
                    <div class="relative z-0 group">
                        <input type="url" id="imageLink" wire:model.debounce.500ms="backgroundImage"
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none  focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            autocomplete="off">
                        <label for="imageLink"
                            class="peer-focus:font-medium absolute text-sm text-gray-500  duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                            Link de Imagen
                        </label>
                        @error('backgroundImage') <span class="text-red-500 text-sm">{{ $message}}</span>@enderror
                    </div>
                    @else
                    <input type="file" accept="image/png, image/jpeg, image/jpg" id="imageFile"
                        wire:model="backgroundImage" placeholder="Subir imagen"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none  focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                    @error('backgroundImage') <span class="text-red-500 text-sm">{{ $message}}</span>@enderror
                    @endif
                </div>
                <div class="flex items-center justify-center">
                    <input id="image_extarna" type="checkbox" wire:model="link"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 ">
                    <label for="image_extarna" class="ml-2 text-sm font-medium text-gray-900 ">
                        Imagen externa
                    </label>
                </div>
            </div>

            @if ($backgroundImage)
            <div class="mt-3">
                <h4 class="text-gray-500 text-lg mb-2 block w-full text-left">Preview</h4>
                <hr />
                <figure class="mt-2 w-80 h-40 mx-auto">
                    @if ($link)
                    <img class="w-full h-full" src="{{$backgroundImage}}" alt="Preview">
                    @else
                    <img class="w-full h-full" src="{{ $backgroundImage->temporaryUrl() }}" alt="Preview">
                    @endif
                </figure>
            </div>
            @endif

        </section>
        @else
        <section>
            <header class="flex justify-between items-center mb-2">
                <h3 class="text-gray-600 text-lg">Imagenes de fondo</h3>
                <div class="lex items-center justify-center">
                    <input id="add_bakground" type="checkbox" wire:model="uploadBackground"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 ">
                    <label for="add_bakground" class="ml-2 text-sm font-medium text-gray-900 ">
                        Subir imagen
                    </label>
                </div>
            </header>
            <hr />
            <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2">
                @foreach ($backgrounds as $background)
                <figure class="cursor-pointer hover:shadow-2xl hover:scale-125 h-40"
                    wire:click="$set('backgroundImage','{{$background->url_file}}')">
                    <img class="w-full h-full" src="{{ asset('storage/'.$background->url_file) }}"
                        alt="{{$background->name}}">
                </figure>
                @endforeach
            </div>
        </section>
        @endif
    </x-slot>

    <x-slot name="footer">
        @if ($backgroundImage)
        <button data-action="close" type="button" wire:click="saveBackgroundBoard()"
            class="btn-mdl mr-0 md:mr-2 mt-2 md:mt-0 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
            Guardar
        </button>
        @endif
        <button data-action="close" wire:click="closeViewBackgroundBoard()" @click="show = false" type="button"
            class="btn-mdl px-3 py-2 text-sm tracking-wide text-white capitalize transition-colors duration-200 transform bg-red-400 rounded-md hover:bg-red-600 focus:outline-none focus:bg-red-500 focus:ring focus:ring-red-300 focus:ring-opacity-50">
            Cerrar
        </button>
    </x-slot>
</x-modal>

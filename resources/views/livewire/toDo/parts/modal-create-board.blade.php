<x-modal wire:model="crateBoard" maxWidth="md" label="true" close="closeViewCreateBoard()">
    <x-slot name="title">
        Crea una nueva lista
    </x-slot>

    <x-slot name="content">
        <div class="mt-4">
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 mb-6 w-full group">
                    <input type="text" name="name" id="name_board" wire:model.defer="nameBoard"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none  focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " autocomplete="off">
                    <label for="name_board"
                        class="required peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nombre</label>
                    @error('nameBoard') <span class="text-red-500 text-sm">{{ $message}}</span>@enderror
                </div>

                <div class="mb-6 w-full group flex">
                    <div class="relative z-0 w-full group">
                        <input type="text" name="icon" id="icon_board" wire:model="iconBoard"
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none  focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            placeholder=" " autocomplete="off">
                        <label for="icon_board"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                            Icono
                        </label>
                        <span data-action="open" wire:click="$set('modalBoxicon',true)"
                            class="btn-mdl absolute right-0 my-auto text-gray-500 text-lg top-2 cursor-pointer"
                            title="Buscar icono">
                            <i class='bx bx-search-alt'></i>
                        </span>
                        @error('iconBoard') <span class="text-red-500 text-sm">{{ $message}}</span>@enderror
                    </div>
                </div>
            </div>

            <div class="relative z-0 mb-6 w-full group">
                <textarea id="coment_board" name="coment" rows="2" wire:model.defer="commentBoard"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none  focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    placeholder=" " autocomplete="off"></textarea>
                <label for="coment_board"
                    class="peer-focus:font-medium absolute text-sm text-gray-500  duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                    Comentario
                </label>
                @error('commentBoard') <span class="text-red-500 text-sm">{{ $message}}</span>@enderror
            </div>

        </div>
    </x-slot>

    <x-slot name="footer">
        <button data-action="close" wire:click.prevent="saveBoard()" type="button"
            class="btn-mdl mr-0 md:mr-2 mt-2 md:mt-0 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Guardar
        </button>
        <button data-action="close" wire:click="closeViewCreateBoard()" @click="show = false" type="button"
            class="btn-mdl px-3 py-2 text-sm tracking-wide text-white capitalize transition-colors duration-200 transform bg-red-400 rounded-md hover:bg-red-600 focus:outline-none focus:bg-red-500 focus:ring focus:ring-red-300 focus:ring-opacity-50">
            Cerrar
        </button>
    </x-slot>
</x-modal>

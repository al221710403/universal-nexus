<x-modal wire:model="settings" maxWidth="md" label="true">
    <x-slot name="title">
        Configuración del post
    </x-slot>

    <x-slot name="content">
        <div class="mt-4">
            <div class="relative z-0 mb-6 w-full group">
                <input wire:model.defer="featured_image" type="file" name="image" id="background_image" accept="image/*"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none  focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    placeholder=" " autocomplete="off">
                <label for="background_image"
                    class="peer-focus:font-medium absolute text-sm text-gray-500  duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Imagen
                    de portada</label>
                @error('featured_image') <span class="text-red-500 text-sm">{{ $message}}</span>@enderror
            </div>

            <div class="relative z-0 mb-6 w-full group">
                <textarea wire:model.defer="featured_image_caption" id="featured_image_caption"
                    name="featured_image_caption" rows="2"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none  focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                    placeholder=" " autocomplete="off"></textarea>
                <label for="featured_image_caption"
                    class="peer-focus:font-medium absolute text-sm text-gray-500  duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Descripción
                    del post</label>
                @error('featured_image_caption') <span class="text-red-500 text-sm">{{ $message}}</span>@enderror
            </div>

            <div class="grid md:grid-cols-2 md:gap-6">

                <div class="relative z-0 mb-6 w-full group">
                    <input wire:model.defer="publish_date" type="datetime-local" name="publish_date" id="publish_date"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none  focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        autocomplete="off" value="2018-06-12T19:30">
                    <label for="publish_date"
                        class="peer-focus:font-medium absolute text-sm text-gray-500  duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Fecha
                        de publicación</label>
                    @error('publish_date') <span class="text-red-500 text-sm">{{ $message}}</span>@enderror
                </div>
            </div>

            <div class="mb-6 w-full" wire:ignore>
                <label for="tags" class="text-sm text-gray-500 block mb-2">Tags del post</label>
                <input type="text" name="tags"
                    class="capitalize block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none  focus:outline-none focus:ring-0 focus:border-blue-600 peer">
            </div>
        </div>
    </x-slot>

    <x-slot name="footer">
        <button wire:click.prevent="saveSetting()" type="button"
            class="mr-0 md:mr-2 mt-2 md:mt-0 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Guardar
        </button>
        <button data-action="close" wire:click="$set('settings', false)" @click="show = false" type="button"
            class="btn-mdl px-3 py-2 text-sm tracking-wide text-white capitalize transition-colors duration-200 transform bg-red-400 rounded-md hover:bg-red-600 focus:outline-none focus:bg-red-500 focus:ring focus:ring-red-300 focus:ring-opacity-50">
            Cerrar
        </button>
    </x-slot>
    </x-modal.modal-lg>
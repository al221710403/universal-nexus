<x-modal wire:model="modal_files" maxWidth="lg">
    <x-slot name="title">
        Archivos
    </x-slot>

    <x-slot name="content">
        Contenido de los archivos
    </x-slot>

    <x-slot name="footer">
        {{-- <button data-action="close" type="button" wire:click="saveBackgroundBoard()"
            class="btn-mdl mr-0 md:mr-2 mt-2 md:mt-0 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
            Guardar
        </button> --}}
        <button data-action="close" wire:click="$set('modal_files',false)" @click="show = false" type="button"
            class="btn-mdl px-3 py-2 text-sm tracking-wide text-white capitalize transition-colors duration-200 transform bg-red-400 rounded-md hover:bg-red-600 focus:outline-none focus:bg-red-500 focus:ring focus:ring-red-300 focus:ring-opacity-50">
            Cerrar
        </button>
    </x-slot>
</x-modal>

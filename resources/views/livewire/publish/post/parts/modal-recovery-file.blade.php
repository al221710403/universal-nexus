<x-modal wire:model="recovery_file" maxWidth="sm">
    <x-slot name="title">
        Archivo de recuperación
    </x-slot>

    <x-slot name="content">
        <article class="body-content">
            <p class="mb-1">Se encontró un archivo de recuperación.</p>
            @if ($dataJson)
                <p>Última fecha de modificación: <span class="font-semibold"> {{$dataJson['created_at']}} </span></p>
            @endif
        </article>
    </x-slot>

    <x-slot name="footer">
        <button wire:click.prevent="autoSaveDeleteOrSave('save')" type="button"
            class="mr-0 md:mr-2 mt-2 md:mt-0 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Recuperar
        </button>

        <a href="{{ route('publish.posts.preview', ['post' => $post_id, 'action' => 'recovery']) }}" type="button" target="_blank"
            class="mr-0 md:mr-2 mt-2 md:mt-0 text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
            Ver
        </a>

        <button data-action="close" wire:click.prevent="autoSaveDeleteOrSave('delete')" @click="show = false" type="button"
            class="btn-mdl px-3 py-2 text-sm tracking-wide text-white capitalize transition-colors duration-200 transform bg-red-400 rounded-md hover:bg-red-600 focus:outline-none focus:bg-red-500 focus:ring focus:ring-red-300 focus:ring-opacity-50">
            Cancelar
        </button>
    </x-slot>
</x-modal.modal-lg>

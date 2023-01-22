<x-modal wire:model="preview_modal" maxWidth="full_screen">
    <x-slot name="title">
        Vista previa
    </x-slot>

    <x-slot name="content">
        <article class="body-content">
            <header class="text-2xl font-bold mb-4">
                {{$title}}
            </header>

            {!! $body !!}
        </article>
    </x-slot>

    <x-slot name="footer">
        <button data-action="close" wire:click="$set('preview_modal', false)" @click="show = false" type="button"
            class="btn-mdl px-3 py-2 text-sm tracking-wide text-white capitalize transition-colors duration-200 transform bg-red-400 rounded-md hover:bg-red-600 focus:outline-none focus:bg-red-500 focus:ring focus:ring-red-300 focus:ring-opacity-50">
            Cerrar
        </button>
    </x-slot>
    </x-modal.modal-lg>

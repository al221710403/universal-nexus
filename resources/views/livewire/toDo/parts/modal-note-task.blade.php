<x-modal wire:model="modalNoteTask" maxWidth="md" close="closeModalEditNote">
    <x-slot name="title">
        Nota de la tarea
    </x-slot>

    <x-slot name="content">
        <div class="mt-4" wire:ignore wire:key="CKEditorBodyTask">
            <textarea class="form-control" id="editor" name="editor"></textarea>
        </div>
    </x-slot>

    <x-slot name="footer">
        <button data-action="close" type="button" onclick="saveNoteTask()" {{-- <button data-action="close"
            type="button"
            onclick="Confirm('la tarea, esta acción eliminara tambien las subtareas','setViewDeleteTask',{{$subtask->id}})"
            wire:click="saveNoteTask()" --}}
            class="btn-mdl mr-0 md:mr-2 mt-2 md:mt-0 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
            Guardar
        </button>
        <button data-action="close" wire:click="closeModalEditNote()" @click="show = false" type="button"
            class="btn-mdl px-3 py-2 text-sm tracking-wide text-white capitalize transition-colors duration-200 transform bg-red-400 rounded-md hover:bg-red-600 focus:outline-none focus:bg-red-500 focus:ring focus:ring-red-300 focus:ring-opacity-50">
            Cerrar
        </button>
    </x-slot>
</x-modal>

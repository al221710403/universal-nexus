<x-modal wire:model="showCommentBoard" maxWidth="sm">
    <x-slot name="title">
        Comentario de tu lista: {{is_numeric($title) ? $this->board->name :
        $title}}
    </x-slot>

    <x-slot name="content">
        <div class="relative text-gray-700 text-base w-full h-full" style="min-height: 50px;" x-data="{ open:false }">
            <div x-show="!open">
                <p style="word-wrap: break-word;">{{$this->board->comment}}</p>
            </div>

            <div x-cloak x-show="open">
                <textarea rows="8" class="w-full pr-8" wire:model.defer="descriptionBoard"></textarea>
            </div>


            {{-- Botones --}}
            <div class="absolute -top-3.5 -right-1 flex flex-col items-end justify-end">
                {{-- Guardar descripción--}}
                <button wire:click="saveComment" x-on:click="open = false"
                    class="rounded-full h-10 w-10 bg-blue-600 hover:bg-blue-800 text-white mb-2.5" x-show="open">
                    <i class='bx bxs-save'></i>
                </button>

                {{-- Cancelar --}}
                <button class="rounded-full h-10 w-10 bg-red-600 hover:bg-red-900 text-white mb-2.5"
                    x-on:click="open = false" x-show="open">
                    <i class='text-lg bx bxs-x-circle'></i>
                </button>

                @if($board->comment == null)
                <button class="rounded-full h-10 w-10 bg-blue-600 hover:bg-blue-800 text-white mb-2.5"
                    title="Agregar comentario" x-on:click="open = true" x-show="!open">
                    <i class='bx bxs-comment-add'></i>
                </button>
                @else
                <button class="rounded-full h-10 w-10 bg-green-600 hover:bg-green-800 text-white mb-2.5"
                    title="Editar comentario" x-on:click="open = true" x-show="!open">
                    <i class='bx bxs-edit-alt'></i>
                </button>
                @endif
            </div>
        </div>
    </x-slot>

    <x-slot name="footer">
        <button data-action="close" wire:click="$set('showCommentBoard',false)" @click="show = false" type="button"
            class="btn-mdl px-3 py-2 text-sm tracking-wide text-white capitalize transition-colors duration-200 transform bg-red-400 rounded-md hover:bg-red-600 focus:outline-none focus:bg-red-500 focus:ring focus:ring-red-300 focus:ring-opacity-50">
            Cerrar
        </button>
    </x-slot>
</x-modal>

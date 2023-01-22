@push('scripts')
<style>
    .content_items {
        display: grid;
        grid-template-columns: repeat(auto-fit,
                minmax(150px,
                    1fr));
    }
</style>
<style>
    .card--background__opacity {
        visibility: hidden;
    }

    .card-effect:hover .card--background__opacity {
        visibility: visible;
    }

    .card-effect:hover .card--background__zoom {
        transform: scale(1.3)
    }

    .item--zoom:hover {
        transform: scale(1.1)
    }

    .card--descripction {
        position: absolute;
        top: 0.25rem;
        /** left: 80%;
            height: 95%;**/
        visibility: hidden;
    }

    .card-effect:hover .card--descripction {
        opacity: 1;
        visibility: visible;
    }
</style>

@endpush

<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-2 pb-4">
    <div class="my-3 p-2 bg-white rounded-lg shadow-lg flex justify-between flex-row-reverse items-center relative">
        <div class="relative w-2/5">
            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                <span class="w-5 h-5 text-gray-500">
                    <i class='bx bx-search'></i>
                </span>
            </div>
            <input type="text" wire:model="search"
                class="block p-2 pl-10 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-gray-500 focus:border-gray-500"
                placeholder="Buscar artículo">
        </div>
        <div class="inline-flex items-center rounded-md shadow-sm font-semibold">
            <a href="{{ route('publish.posts.store') }}" title="Agregar artículo"
                class="mr-2 btn-mdl text-white bg-blue-700 hover:bg-blue-800 focus:outline-none text-sm border-y border-slate-200 font-medium px-4 py-2 inline-flex space-x-1 items-center rounded-lg">
                <span><i class='bx bxs-add-to-queue'></i></span>
                <span>Nuevo post</span>
            </a>

            <button wire:click="clearAll"
                class="text-slate-800 hover:text-blue-600 text-sm bg-white hover:bg-slate-100 border border-slate-200 rounded-l-lg font-medium px-4 py-2 inline-flex space-x-1 items-center">
                <span><i class='bx bxs-brush-alt'></i>
                </span>
                <span>Clear all</span>
            </button>
            <button data-action="open" wire:click="$set('filters', true)"
                class="btn-mdl text-slate-800 hover:text-blue-600 text-sm bg-white hover:bg-slate-100 border-y border-slate-200 font-medium px-4 py-2 inline-flex space-x-1 items-center">
                <span>
                    <i class='bx bx-filter-alt'></i>
                </span>
                <span>Filters</span>
            </button>

            <div class="inline" x-data="{ option:false }">
                <button x-on:click="option = !option"
                    class="btn-mdl text-slate-800 hover:text-blue-600 text-sm bg-white hover:bg-slate-100 border border-slate-200 font-medium px-4 py-2 inline-flex space-x-1 items-center">
                    <span>
                        <i class='bx bx-sort'></i>
                    </span>
                    <span>Sort By</span>
                </button>
                <section
                    class="w-56 absolute p-2 top-14 mt-1 bg-white rounded-lg shadow-2xl text-gray-600 text-sm font-normal"
                    x-show="option">
                    <header class=" text-base text-gray-600 font-semibold">
                        Sort By
                    </header>
                    <hr class="my-1 border border-slate-100">

                    <div>
                        <label for="column"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Seleccione una
                            columna</label>
                        <select id="column" wire:model="column"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                            <option value="title">Título</option>
                            <option value="publish_date">Fecha de publicación</option>
                            <option value="created_at">Fecha de creación</option>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label for="order"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Ordenado por</label>
                        <select id="order" wire:model="order"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                            <option value="asc">Ascendente</option>
                            <option value="desc">Descendente</option>
                        </select>
                    </div>
                </section>
            </div>

            <button data-action="open" wire:click="$set('my_posts', true)"
                class="btn-mdl text-slate-800 hover:text-blue-600 text-sm bg-white hover:bg-slate-100 border border-slate-200 rounded-r-lg font-medium px-4 py-2 inline-flex space-x-1 items-center">
                <span>
                    <i class='bx bxs-notepad'></i>
                </span>
                <span>Mis post</span>
            </button>
        </div>
    </div>
    @include('livewire.publish.post.parts.modal-filter')
    @include('livewire.publish.post.parts.modal-my-post')


    <div class="grid grid-cols-3 gap-6">
        @forelse ($posts as $post)
        <article class="rounded-sm shadow-2xl w-full h-80 bg-cover bg-center @if($loop->first) col-span-2 @endif"
            style="background-image: url({{ asset('storage/'.$post->featured_image) }})">
            <div class="w-full h-full px-8 py-2 felx flex-col justify-center">
                <header class="flex flex-wrap">
                    @foreach ($post->tags as $tag)
                    <span wire:click="getTags({{$tag->id}})"
                        class=" cursor-pointer inline-blog px-3 mt-2 mr-2 h-6 bg-{{$tag->color}}-600 text-white rounded-full">
                        # {{$tag->name}}
                    </span>
                    @endforeach
                </header>

                <h2 class="text-4xl text-gray-300 leading-8 font-bold mt-4">
                    <a href="{{ route('publish.posts.show', $post->slug) }}">
                        {{$post->title}}
                    </a>
                </h2>
            </div>
        </article>
        @empty
        No ahy registros
        @endforelse
    </div>
    <div class="mt-4 flex">
        {{$posts->links()}}
    </div>

</div>

@push('scripts')

@endpush

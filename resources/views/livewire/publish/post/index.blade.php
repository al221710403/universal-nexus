@push('styles')
@endpush

<div class="container mx-auto mt-2 pb-4">

    {{-- Header - buscador y botones --}}
    <div class="my-3 p-2 bg-white rounded-lg shadow-lg flex flex-col lg:flex-row-reverse lg:justify-between relative">
        <div class="block mb-2 lg:w-4/12 lg:inline-block lg:mb-0 relative">
            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                <span class="w-5 h-5 text-gray-500">
                    <i class='bx bx-search'></i>
                </span>
            </div>
            <input type="text" wire:model="search"
                class="my-auto block p-2 pl-10 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-gray-500 focus:border-gray-500"
                placeholder="Buscar artículo">
        </div>

        <div class="flex flex-col lg:flex-row rounded-md shadow-sm font-semibold">
            <div class="mb-2 lg:mb-0">
                <a href="{{ route('publish.posts.store') }}" title="Agregar artículo"
                    class="block lg:mr-2 btn-mdl text-white bg-blue-700 hover:bg-blue-800 focus:outline-none text-sm border-y border-slate-200 font-medium px-4 py-2 lg:inline-flex space-x-1 items-center text-center rounded-lg">
                    <span><i class='bx bxs-add-to-queue'></i></span>
                    Nuevo artículo
                </a>
            </div>

            <div class="grid grid-cols-4">
                <button wire:click="clearAll"
                    class="col-span-2 sm:col-span-1 text-slate-800 hover:text-blue-600 text-sm bg-white hover:bg-slate-100 border border-slate-200 rounded-tl-lg sm:rounded-l-lg font-medium px-4 py-2 inline-flex items-center">
                    <span><i class='bx bxs-brush-alt'></i>
                    </span>
                    <span>Clear all</span>
                </button>

                <button data-action="open" wire:click="$set('filters', true)"
                    class="col-span-2 sm:col-span-1 rounded-tr-lg sm:rounded-none btn-mdl text-slate-800 hover:text-blue-600 text-sm bg-white hover:bg-slate-100 border border-slate-200 font-medium px-4 py-2 inline-flex items-center">
                    <span>
                        <i class='bx bx-filter-alt'></i>
                    </span>
                    <span>Filters</span>
                </button>

                <div class="col-span-2 sm:col-span-1 inline" x-data="{ option:false }" @click.away="option = false"
                    @close.stop="option = false">
                    <button x-on:click="option = !option"
                        class="h-full w-full btn-mdl text-slate-800 hover:text-blue-600 text-sm bg-white hover:bg-slate-100
                     border rounded-bl-lg sm:rounded-none border-slate-200 font-medium px-4 py-2 inline-flex space-x-1 items-center">
                        <span>
                            <i class='bx bx-sort'></i>
                        </span>
                        <span>Sort By</span>
                    </button>
                    <section x-cloak
                        class=" z-50 w-56 absolute p-2 top-14 mt-1 bg-white rounded-lg shadow-2xl text-gray-600 text-sm font-normal"
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
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Ordenado
                                por</label>
                            <select id="order" wire:model="order"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                                <option value="asc">Ascendente</option>
                                <option value="desc">Descendente</option>
                            </select>
                        </div>
                    </section>
                </div>

                <button data-action="open" wire:click="$set('my_posts', true)"
                    class="col-span-2 sm:col-span-1 btn-mdl text-slate-800 hover:text-blue-600 text-sm bg-white hover:bg-slate-100 border border-slate-200 rounded-br-lg sm:rounded-r-lg font-medium px-4 py-2 inline-flex space-x-1 items-center">
                    <span>
                        <i class='bx bxs-notepad'></i>
                    </span>
                    <span>Mis artículos</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Modal para los filtros y mis artículos --}}
    @include('livewire.publish.post.parts.modal-filter')
    @include('livewire.publish.post.parts.modal-my-post')

    {{-- Container --}}
    <div class="mx-2 md:mx-0 grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-6">
        @forelse ($posts as $post)
        <article class="rounded-sm shadow-2xl w-full h-80 relative @if($loop->first) col-span-1 md:col-span-2 @endif">
            <div class="absolute left-0 bottom-0 w-full h-full z-10"
                style="background-image: linear-gradient(180deg,transparent,rgba(0,0,0,.8));"></div>
            <img src="{{Storage::url($post->featured_image)}}"
                class="absolute left-0 top-0 w-full h-full z-0 object-cover" />
            <div class="p-4 absolute bottom-0 left-0 z-20">
                <div class="flex flex-wrap">
                    @foreach ($post->tags as $tag)
                    <span wire:click="getTags({{$tag->id}})"
                        class="cursor-pointer px-2 py-1 bg-black text-gray-200 inline-flex items-center justify-center mb-1 mr-1 rounded-lg">
                        # {{$tag->name}}
                    </span>
                    @endforeach
                </div>

                <h2 class="text-2xl font-semibold text-gray-100 leading-tight">
                    <a href="{{ route('publish.posts.show', $post->slug) }}">
                        {{$post->title}}
                    </a>
                </h2>
                <div class="flex mt-3">
                    <img src="{{$post->author->profile_photo_url}}" class="h-10 w-10 rounded-full mr-2 object-cover" />
                    <div>
                        <p class="font-semibold text-gray-200 text-sm cursor-pointer"
                            wire:click="$set('author_id', {{$post->author->id}})"> {{$post->author->name}} </p>
                        <p class="font-semibold text-gray-400 text-xs">
                            <time datetime=" {{$post->publish_date}}">
                                <i class='bx bxs-calendar'></i>
                                {{ Carbon\Carbon::parse($post->publish_date)->isoFormat('D MMMM') }}
                            </time>
                        </p>
                    </div>
                </div>
            </div>
        </article>
        @empty
        @if (strlen($search) > 0)
        <div class="md:col-start-2 md:col-end-3 p-4 mt-4 md:mt-12 bg-white rounded-lg shadow-xl">
            <div class="py-2 mb-3 text-gray-700 px-3">
                <p class="text-sm mb-3">No ahí artículos que coinciden con la busqueda <span
                        class="font-bold">{{$search}}</span>.</p>
                <img src="{{ asset('img/search_not.svg') }}" alt="not search">
            </div>
        </div>
        @else
        <div class="md:col-start-2 md:col-end-3 p-4 mt-4 md:mt-12 bg-white rounded-lg shadow-xl">
            <div class="py-2 mb-3 text-gray-700 px-3">
                <p class="text-sm mb-3">No ahí artíclos que coinciden con la busqueda, agregue uno nuevo con
                    el botón
                    <span><i class='bx bxs-add-to-queue'></i></span> que se euncuentra en la parte superior.
                </p>
                <img src="{{ asset('img/articles.svg') }}" alt="no ahi articulos">
            </div>
        </div>
        @endif
        @endforelse
    </div>

    {{-- Paginador --}}
    <div class="mt-4 flex">
        {{$posts->links()}}
    </div>
</div>

@push('scripts')
@endpush

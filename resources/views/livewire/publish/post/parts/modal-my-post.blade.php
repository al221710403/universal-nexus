<x-modal wire:model="my_posts" maxWidth="full" index="30">
    <x-slot name="title">
        <span class="mr-2"><i class='bx bxs-notepad'></i></span> Mis artículos
    </x-slot>

    <x-slot name="content">
        <div class="pb-2 border-b border-gray-200 rounded-lg flex justify-between items-center relative">

            <div class="inline-flex items-center rounded-md shadow-sm font-semibold">
                <button wire:click="$set('status', 'all')"
                    class="{{$status == 'all' ? 'text-white bg-blue-600' : 'text-slate-800 hover:text-blue-600 bg-white hover:bg-slate-100' }}  text-sm  border border-slate-200 rounded-l-lg font-medium px-4 py-2 inline-flex space-x-1 items-center">
                    <span><i class='bx bx-grid-small'></i></span>
                    <span>All</span>
                </button>
                <button wire:click="$set('status', 'draft')"
                    class="{{$status == 'draft' ? 'text-white bg-blue-700' : 'text-slate-800 hover:text-blue-600 bg-white hover:bg-slate-100' }} text-sm border-y border-slate-200 font-medium px-4 py-2 inline-flex space-x-1 items-center">
                    <span>
                        <i class='bx bxs-pencil'></i>
                    </span>
                    <span>Draft</span>
                </button>
                <button wire:click="$set('status', 'published')"
                    class="{{$status == 'published' ? 'text-white bg-blue-700' : 'text-slate-800 hover:text-blue-600 bg-white hover:bg-slate-100' }} mr-3 text-sm border border-slate-200 rounded-r-lg font-medium px-4 py-2 inline-flex space-x-1 items-center">
                    <span>
                        <i class='bx bxs-notepad'></i>
                    </span>
                    <span>Published</span>
                </button>

                <div class="ml-1 inline" x-data="{ option:false }">
                    <button x-on:click="option = !option"
                        class="btn-mdl text-slate-800 hover:text-blue-600 text-sm bg-white hover:bg-slate-100 rounded-md border border-slate-200 font-medium px-4 py-2 inline-flex space-x-1 items-center">
                        <span>
                            <i class='bx bx-sort'></i>
                        </span>
                        <span>Sort By</span>
                    </button>
                    <section
                        class="w-56 absolute p-2 top-14 bg-white rounded-lg shadow-2xl text-gray-600 text-sm font-normal"
                        x-show="option">
                        <header class="text-base text-gray-600 font-semibold">
                            Sort By
                        </header>
                        <hr class="my-1 border border-slate-100">

                        <div>
                            <label for="my_column"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Seleccione una
                                columna</label>
                            <select id="my_column" wire:model="my_column"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                                <option value="title">Título</option>
                                <option value="publish_date">Fecha de publicación</option>
                                <option value="created_at">Fecha de creación</option>
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="my_order"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Ordenado
                                por</label>
                            <select id="my_order" wire:model="my_order"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                                <option value="asc">Ascendente</option>
                                <option value="desc">Descendente</option>
                            </select>
                        </div>
                    </section>
                </div>
            </div>
            <div class="relative w-1/3">
                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                    <span class="w-5 h-5 text-gray-500">
                        <i class='bx bx-search'></i>
                    </span>
                </div>
                <input type="text" wire:model="searchMyPost"
                    class="block p-2 pl-10 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-gray-500 focus:border-gray-500"
                    placeholder="Buscar artículo">
            </div>
        </div>

        <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-md mt-3 mb-2">
            <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                <thead class="bg-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-medium text-gray-900">Título</th>
                        <th scope="col" class="px-6 py-4 font-medium text-gray-900">Público</th>
                        <th scope="col" class="px-6 py-4 font-medium text-gray-900">Status</th>
                        <th scope="col" class="px-6 py-4 font-medium text-gray-900">Fecha de publicación</th>
                        <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                    @forelse ($all_post as $post)
                    <tr class="hover:bg-gray-50">
                        <th class="flex gap-3 px-6 py-4 font-normal text-gray-900">
                            <a href="{{ route('publish.posts.show', $post->slug) }}" class=" text-lg font-medium text-gray-700">
                                {{$post->title ?? 'Title Draft'}}
                            </a>
                        </th>
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-{{$post->public ? 'green' : 'red'}}-50 px-2 py-1 text-xs font-semibold text-{{$post->public ? 'green' : 'red'}}-600">
                                <span
                                    class="h-1.5 w-1.5 rounded-full bg-{{$post->public ? 'green' : 'red'}}-600"></span>
                                {{$post->public ? 'Publico' : 'Privado'}}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-{{$post->published ? 'green' : 'red'}}-50 px-2 py-1 text-xs font-semibold text-{{$post->published ? 'green' : 'red'}}-600">
                                <span
                                    class="h-1.5 w-1.5 rounded-full bg-{{$post->published ? 'green' : 'red'}}-600"></span>
                                {{$post->published ? 'Published' : 'Draft'}}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <time datetime=" {{$post->publish_date}} " class="text-sm">
                                {{ Carbon\Carbon::parse($post->publish_date)->isoFormat('D MMMM YYYY') }}
                                <i class='bx bxs-calendar'></i>
                            </time>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-end gap-4">
                                <button onclick="Confirm('la publicación','deleteMyPost',{{$post->id}})"
                                    class="text-2xl hover:text-red-500" title="Eliminar">
                                    <i class='bx bxs-trash'></i>
                                </button>
                                <a href="{{ route('publish.posts.edit', $post) }}" title="Editar post"
                                    class="text-2xl hover:text-green-500">
                                    <i class='bx bxs-edit-alt'></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <p class="text-center text-sm mb-3 py-3">No ahí artículos, agregue uno nuevo con
                                el botón
                                <span><i class='bx bxs-add-to-queue'></i></span> que se euncuentra en la parte superior
                                de la pantalla principal.
                            </p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{$all_post->links()}}
    </x-slot>

    <x-slot name="footer">
        <button data-action="close" wire:click="$set('my_posts', false)" @click="show = false" type="button"
            class="btn-mdl px-3 py-2 text-sm tracking-wide text-white capitalize transition-colors duration-200 transform bg-red-400 rounded-md hover:bg-red-600 focus:outline-none focus:bg-red-500 focus:ring focus:ring-red-300 focus:ring-opacity-50">
            Cerrar
        </button>
    </x-slot>
    </x-modal.modal-lg>

@push('styles')
@endpush
<x-app-layout>
    {{-- Message --}}

    <div class="container mx-auto mt-2 pb-4">
        @if (Session::has('success'))
        <div class="bg-indigo-100 border-l-4 border-indigo-500 text-indigo-700 p-4" role="alert">
            <p class="font-bold">Success</p>
            <p>{{ session('success') }}</p>
        </div>
        @endif

        @if (Session::has('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
            <p class="font-bold">Error</p>
            <p>{{ session('error') }}</p>
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <section class=" my-3 p-4 bg-white rounded-lg shadow-lg overflow-hidden">
                <header class="text-gray-600 text-xl font-semibold mb-2">
                    <h2>Sube un nuevo archivo predefinido</h2>
                </header>
                <hr />

                <form class="mt-2" action="{{ route('predefined.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4 w-full group">
                        <x-jet-label class="text-gray-500 text-base required" value="Archivos(s)" />
                        <x-jet-input type="file" name="files[]" class="mt-2 block" multiple
                            placeholder="{{ __('Seleccionar archivo') }}" />
                        <x-jet-input-error for="files" class="mt-2" />
                    </div>

                    <div class="mb-4 w-full group">
                        <x-jet-label class="text-gray-500 text-base required" value="Seleccione un modulo" />
                        <select name="modulo" required
                            class="form-select appearance-none block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none">
                            <option {{old('modulo') ? '' : 'selected' }} value="Elegir">Seleccione una opción</option>
                            <option value="blog" {{old('modulo')=='blog' ? 'selected' : '' }}>Blog</option>
                            <option value="todo-list" {{old('modulo')=='todo-list' ? 'selected' : '' }}>To Do List
                            </option>
                        </select>
                        <x-jet-input-error for="modulo" class="mt-2" />
                    </div>

                    <div class="mb-4 w-full group">
                        <x-jet-label class="text-gray-500 text-base required" value="Seleccione un uso" />
                        <select name="use"
                            class="form-select appearance-none block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none">
                            <option {{old('use') ? '' : 'selected' }} value="Elegir">Seleccione una opción</option>
                            <option value="background" {{old('use')=='background' ? 'selected' : '' }}>Fondo</option>
                            <option value="info" {{old('use')=='info' ? 'selected' : '' }}>Informativo</option>
                        </select>
                        <x-jet-input-error for="use" class="mt-2" />
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                            Guardar
                        </button>
                    </div>
                </form>
            </section>

            <section class="md:col-span-2 my-3 p-2 bg-white rounded-lg shadow-lg">
                <header class="text-gray-600 text-xl font-semibold mb-2">
                    <h2>Lista de archivos por defecto</h2>
                </header>
                <hr />

                <div class="block w-full overflow-x-auto">
                    <table class="items-center bg-transparent w-full border-collapse ">
                        <thead>
                            <tr>
                                <th
                                    class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Nombre
                                </th>
                                <th
                                    class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Path
                                </th>
                                <th
                                    class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Tipo
                                </th>
                                <th
                                    class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Modúlo
                                </th>
                                <th
                                    class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Uso
                                </th>
                                <th
                                    class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Acciones
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($files as $file)
                            <tr>
                                <td
                                    class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                    {{$file->name}}
                                </td>
                                <td
                                    class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                    <a href="http://">
                                        {{$file->url_file}}
                                    </a>
                                </td>
                                <td
                                    class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                    {{$file->type}}
                                </td>
                                <td
                                    class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                    {{$file->module}}
                                </td>
                                <td
                                    class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                    {{$file->use}}
                                </td>
                                <td
                                    class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                    acciones
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </section>
        </div>
    </div>

</x-app-layout>
@push('scripts')

@endpush

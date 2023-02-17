<x-modal wire:model="setColorTask" maxWidth="sm" index="30" close="closeSetColor">
    <x-slot name="title">
        Cambiar color
    </x-slot>

    <x-slot name="content">
        <div class="mt-4">
            <div>
                <div class="grid md:grid-cols-2 md:gap-6 mb-3">
                    <div class="relative z-0 w-full group">
                        <input wire:model="backgroundColor" type="color" id="background_color"
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none  focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            autocomplete="off">
                        <label for="background_color"
                            class="peer-focus:font-medium absolute text-sm text-gray-500  duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Color
                            de fondo</label>
                    </div>
                    <div class="relative z-0 w-full group">
                        <span class="w-4 h-4 rounde-full" style="background-color: {{$backgroundColor}};"></span>
                        <input wire:model="textColor" type="color" id="text_color"
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none  focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            autocomplete="off">
                        <label for="text_color"
                            class="peer-focus:font-medium absolute text-sm text-gray-500  duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Color
                            de texto</label>
                    </div>
                </div>
                <hr />
                <h3 class="text-lg text-gray-700 font-semibold my-3">Preview</h3>
                <div>
                    <div class="w-full h-48 flex items-center justify-center" style="
                        background-image: linear-gradient(45deg,#efefef 25%,hsla(0,0%,94%,0) 0,hsla(0,0%,94%,0) 75%,#efefef 0,#efefef),linear-gradient(45deg,#efefef 25%,hsla(0,0%,94%,0) 0,hsla(0,0%,94%,0) 75%,#efefef 0,#efefef);
                        background-color: #fff;
                        background-position: 0 0,10px 10px;
                        background-size: 20px 20px;">
                        <div class="w-3/4 rounded-lg shadow-lg px-3 py-2"
                            style="background-color: {{$backgroundColor}}; color: {{$textColor}};">
                            <div class="mb-3">
                                <h4>Lorem ipsum dolor sit amet.</h4>
                            </div>
                            <hr />
                            <ul class="flex items-center mt-2 flex-wrap">
                                <li class="mr-3" title="Mi día">
                                    <span class="text-xl">
                                        <i class='bx bx-sun'></i>
                                    </span>
                                </li>
                                <li class="mr-3" title="Compartido">
                                    <span class="text-xl">
                                        <i class='bx bxs-user-plus'></i>
                                    </span>
                                </li>
                                <li class="mr-3" title="Fecha de vencimiento">
                                    <span class="text-xl">
                                        <i class='bx bx-calendar'></i>
                                    </span>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <x-slot name="footer">
        <button type="button" wire:click="defaultColor"
            class="btn-mdl mr-0 md:mr-2 mt-2 md:mt-0 text-white bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
            Default
        </button>
        <button data-action="close" type="button" wire:click="saveColor()"
            class="btn-mdl mr-0 md:mr-2 mt-2 md:mt-0 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
            Guardar
        </button>
        <button data-action="close" wire:click="closeSetColor()" @click="show = false" type="button"
            class="btn-mdl px-3 py-2 text-sm tracking-wide text-white capitalize transition-colors duration-200 transform bg-red-400 rounded-md hover:bg-red-600 focus:outline-none focus:bg-red-500 focus:ring focus:ring-red-300 focus:ring-opacity-50">
            Cerrar
        </button>
    </x-slot>
</x-modal>

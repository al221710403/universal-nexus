<div class="box-border container md:w-3/4 mx-auto mt-4 relative">
    <div class="w-full mb-4 relative">
        <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none text-gray-400">
            <i class='bx bx-search-alt bx-sm'></i>
        </div>
        <input type="text" id="voice-search" wire:model="search"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-md rounded-lg border-none focus:font-semibold focus:shadow-2xl focus:border-2 focus:border-gray-600 block w-full pl-10 p-2.5"
            placeholder="Buscar icono...">

        <button type="button" wire:click="resetUI"
            class="flex absolute inset-y-0 right-0 items-center pr-3 text-gray-300 hover:text-gray-500">
            <i class='bx bxs-x-circle bx-sm'></i>
        </button>
    </div>

    <div class="w-full mb-4 flex justify-between">
        <div class=" w-1/3">
            <select wire:model="category"
                class="form-select appearance-none block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-none">
                <option value="Elegir">All Categories</option>
                @foreach ($categories as $category)
                <option value="{{$category['id']}}">{{$category['name']}}</option>
                @endforeach
            </select>

        </div>


        <ul class="flex">
            <li wire:click="$set('type','ALL')"
                class="mr-2 cursor-pointer rounded-lg text-sm py-2 px-3 {{$type == 'ALL' ? 'font-semibold text-white bg-blue-700 shadow-md' : 'text-gray-400 hover:text-gray-600 hover:font-semibold'}}">
                All
            </li>
            <li wire:click="$set('type','SOLID')"
                class="mr-2 cursor-pointer rounded-lg text-sm py-2 px-3 {{$type == 'SOLID' ? 'font-semibold text-white bg-blue-700 shadow-md' : 'text-gray-400 hover:text-gray-600 hover:font-semibold'}}">
                Solid
            </li>
            <li wire:click="$set('type','REGULAR')"
                class="mr-2 cursor-pointer rounded-lg text-sm py-2 px-3 {{$type == 'REGULAR' ? 'font-semibold text-white bg-blue-700 shadow-md' : 'text-gray-400 hover:text-gray-600 hover:font-semibold'}}">
                Regular
            </li>
            <li wire:click="$set('type','LOGO')"
                class="cursor-pointer rounded-lg text-sm py-2 px-3 {{$type == 'LOGO' ? 'font-semibold text-white bg-blue-700 shadow-md' : 'text-gray-400 hover:text-gray-600 hover:font-semibold'}}">
                Logos
            </li>
        </ul>
    </div>

    <div class="grid grid-cols-5 gap-2 md:grid-cols-6 lg:grid-cols-9 md:gap-4 overflow-y-auto overflow-x-hidden"
        style="max-height: 400px;">
        @forelse ($boxicons as $icon)
        <div wire:click="getIcon('{{$icon['icon_text']}}')"
            class="h-28 flex items-center justify-center cursor-pointer rounded-lg hover:shadow-2xl text-gray-500 hover:text-gray-700 hover:bg-white">
            <div class="block px-2 py-4">
                <div class="text-center text-4xl block">
                    {!!$icon['icon_element']!!}
                </div>
                <div class="text-center text-xs" style="text-overflow: ellipsis; overflow: hidden; white-space: nowrap">
                    {{Str::limit($icon['name'], 12)}}
                </div>
            </div>
        </div>
        @empty
        Hubo un problema no se pudo cargar los iconos
        @endforelse

    </div>

    @if ($selectIcon)
    <div class="absolute bottom-4 right-4 rounded-xl shadow-xl bg-white p-3 flex">
        <div class="flex flex-col items-center flex-wrap mr-2 w-8">
            {{-- <input type="color" value="rgba( 0, 0, 0, 1 )" class="rounded-full w-6 h-6 cursor-pointer"> --}}
            <div class="flex items-center mt-2 text-2xl text-gray-400 cursor-pointer" wire:click="changeRotate">
                <i class="bx bx-rotate-right"></i>
            </div>

            <div x-data="{ open: false }" @click="open = ! open"
                class="flex items-center mt-2 text-2xl text-gray-400 cursor-pointer relative">
                <i class="bx bxs-zap"></i>
                <div x-show="open"
                    class=" z-20 flex bg-white shadow-2xl p-0.5 rounded-lg text-gray-700 absolute left-0 -bottom-10">
                    @php
                    $animationValue = [
                    'bx-spin',
                    'bx-tada',
                    'bx-flashing',
                    'bx-burst',
                    'bx-fade-left',
                    'bx-fade-right',
                    'bx-fade-up',
                    'bx-fade-down'
                    ];
                    @endphp
                    @foreach ($animationValue as $animation)
                    <div class="m-2 text-base text-gray-500 cursor-pointer"
                        wire:click="changeAnimation('{{$animation}}')">
                        <i class="{{$selectIcon}} {{$animation}}"></i>
                    </div>
                    @endforeach
                    <div class="m-2 text-sm text-gray-700 cursor-pointer text-center" wire:click="changeAnimation('')">
                        None
                    </div>
                </div>
            </div>
            <div class="flex items-center mt-2 text-2xl text-gray-400 cursor-pointer" wire:click="changeFlip">
                <i class="bx bx-sync"></i>
            </div>
        </div>

        <div class="relative flex">
            <div class="text-gray-800 w-48 h-48 flex items-center justify-center icon_selected" style="
            background-image: linear-gradient(45deg,#efefef 25%,hsla(0,0%,94%,0) 0,hsla(0,0%,94%,0) 75%,#efefef 0,#efefef),linear-gradient(45deg,#efefef 25%,hsla(0,0%,94%,0) 0,hsla(0,0%,94%,0) 75%,#efefef 0,#efefef);
            background-color: #fff;
            background-position: 0 0,10px 10px;
            background-size: 20px 20px;
            font-size: 132px;">
                <i
                    class="{{$selectIcon}} @if($rotate){{$rotate}}@endif @if($animationIcon){{$animationIcon}}@endif @if($flip){{$flip}}@endif"></i>
            </div>

            <div class="mx-2 w-56 flex flex-col justify-between">
                <div>
                    <h3 class="text-gray-700 font-semibold text-lg mb-1.5">{{$selectIcon}}</h3>
                    <hr />
                    <div id="show_icon_i" wire:click="$emit('copyToIcon')"
                        class="mt-1 bg-gray-300 overflow-auto px-3 py-2 text-gray-500 text-sm rounded-md cursor-pointer"
                        style="max-height: 55px;">

                    </div>
                </div>
                <div>
                    @if ($nameComponent)
                    <button wire:click="$emit('readyToSend')"
                        class="mt-1 rounded-lg text-white font-semibold w-full py-1 bg-gray-900">
                        Usar Icono
                    </button>
                    @endif
                    <button wire:click="$emit('copyToIcon')"
                        class="mt-1 rounded-lg text-white font-semibold w-full py-1 bg-gray-900">
                        Copiar Icono
                    </button>
                </div>
            </div>


            <span class="absolute text-3xl text-gray-500 -top-6 -right-6 cursor-pointer" wire:click="closeViewIcon">
                <i class='bx bxs-x-circle'></i>
            </span>
        </div>

    </div>
    @endif
</div>

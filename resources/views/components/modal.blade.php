@props(['id', 'maxWidth','label','close','index'])

@php
$id = $id ?? md5($attributes->wire('model'));
$label = $label ?? false;
$close = $close ?? false;
$full = $maxWidth != 'full_screen' ? 'px-4 py-10' : '';
$index = $index ?? 20;

$maxWidth = [
'max' => 'w-max', //Width se ajusta al maximo del contenido
'auto' => 'w-auto', //Width automatico
'sm' => 'w-full md:w-2/5', //40% de la pantalla
'md' => 'w-full md:w-1/2', //50% de la pantalla
'lg' => 'w-full md:w-9/12', //75% de la pantalla
'full' => 'min-w-full w-full', // 100% de la pantalla
'full_screen' => 'min-w-full w-full min-h-screen max-h-full', // toda la pantalla
][$maxWidth ?? 'md'];
@endphp


<div x-cloak x-data="{ show: @entangle($attributes->wire('model')).defer }">
    <div x-show="show" class="inset-0 h-full w-full fixed overflow-x-hidden overflow-y-auto"
        style="z-index: {{$index}}; background-color: rgba(0, 0, 0, 0.5)" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-start justify-center {{$full}} text-center md:items-center sm:block min-h-screen">
            <div x-cloak x-show="show" x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="flex flex-col mx-auto font-quick bg-white text-left transition-all transform rounded-lg overflow-hidden shadow-xl
                {{ $maxWidth }}" id="{{ $id }}">

                {{-- Encabezado --}}
                <header class="border-b-2 border-gray-300 px-5 pt-4 pb-2 flex items-center justify-between space-x-4">
                    <h2 class="text-xl font-medium text-gray-800 ">
                        {{ $title }}
                    </h2>
                    <button data-action="close" @if($close !=false) wire:click="{{$close}}" @endif @click="show = false"
                        class="btn-mdl text-2xl text-gray-600 focus:outline-none hover:text-red-600" title="Cerrar">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>
                </header>

                <div class="px-5 py-3 flex-1">
                    @if ($label)<p class="text-xs mb-1">Los campos con un <code class="text-red-500">*</code> son
                        obligatorios.</p>@endif
                    {{ $content }}
                </div>

                @if (isset($footer))
                <footer class="flex flex-col-reverse md:flex-row justify-end px-6 py-2 bg-gray-200 text-right">
                    {{ $footer }}
                </footer>
                @endif

            </div>
        </div>
    </div>
</div>

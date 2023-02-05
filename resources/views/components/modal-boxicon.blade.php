@props(['id' => null, 'maxWidth' => null,'index' => null,'nameComponent' => null])

@php
$id = $id ?? md5($attributes->wire('model'));
@endphp

<x-modal :id="$id" :maxWidth="$maxWidth" :index="$index" {{ $attributes }}>
    <x-slot name="title">
        Buscador de Iconos Boxicons
    </x-slot>

    <x-slot name="content">
        <livewire:boxicon :nameComponent="$nameComponent" />
    </x-slot>

</x-modal>

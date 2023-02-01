<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo-white-background.svg')}}" />
    @include('layouts.app.styles')
</head>

<body class="body-mdl font-sans antialiased min-h-screen max-h-full bg-gray-100">
    <x-jet-banner />
    {{-- <div class="overflow-hidden hidden"></div> --}}
    <div class="flex flex-col min-h-screen">
        @livewire('navigation-menu')

        {{--
        <!-- Page Heading -->
        @if (isset($header))
        <header class="bg-white shadow border-gray-700 border-4">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endif --}}

        <!-- Page Content -->
        <main class="flex-1 flex">
            {{ $slot }}
        </main>
    </div>

    @stack('modals')

    @include('layouts.app.scripts')
</body>

</html>

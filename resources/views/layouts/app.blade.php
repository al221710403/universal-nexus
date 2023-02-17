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

<body class="body-mdl font-sans antialiased min-h-screen max-h-full bg-gray-100 relative">
    {{--
    <x-jet-banner /> --}}
    {{-- <div class="overflow-hidden hidden"></div> --}}
    <div class="min-h-screen" id="main">
        {{-- <div class="flex flex-col min-h-screen"> --}}
            @livewire('navigation-menu')

            <!-- Page Content -->
            <main class="flex">
                {{-- <main class="flex-1 flex"> --}}
                    <div id="loader_main" class="inset-0 h-full w-full fixed overflow-x-hidden overflow-y-auto bg-white"
                        style="z-index: 90;">
                        <div class="h-full w-full flex justify-center items-center">
                            <div class="lds-ripple">
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                    {{ $slot }}
                </main>
        </div>

        @stack('modals')

        @include('layouts.app.scripts')
</body>

</html>

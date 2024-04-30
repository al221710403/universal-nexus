<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo-white-background.svg')}}" />
    @include('layouts.app.styles')
    @yield('styles')
</head>

<body class="body-mdl font-sans antialiased min-h-screen max-h-full bg-gray-100 relative">

    <div class="min-h-screen" id="main">

        <!-- Page Content -->
        <main class="flex">
            <div id="loader_main" class="inset-0 h-full w-full fixed overflow-x-hidden overflow-y-auto bg-white" style="z-index: 90;">
                <div class="h-full w-full flex justify-center items-center">
                    <div class="lds-ripple">
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>

            @yield('content')

        </main>
    </div>

    @stack('modals')

    @include('layouts.app.scripts')
    @yield('scripts')
</body>

</html>

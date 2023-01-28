<!-- Fonts -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

<link rel="stylesheet" href="{{ asset('css/boxicons.min.css') }}">
<link href="{{ asset('plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('plugins/notification/snackbar/snackbar.min.css') }}" rel="stylesheet" type="text/css" />

<style>
    [x-cloak] {
        display: none !important;
    }

    textarea:focus,
    input:focus,
    input[type]:focus {
        outline: none;
        box-shadow: none;
    }
</style>

<link rel="stylesheet" href="{{ mix('css/app.css') }}">
<script src="{{ mix('js/app.js') }}" defer></script>


@stack('styles')
<script src="https://cdn.tailwindcss.com"></script>

<!-- Styles -->
@livewireStyles

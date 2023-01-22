<!-- Fonts -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

{{--
<link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'> --}}

<link rel="stylesheet" href="{{ asset('css/boxicons.min.css') }}">

<link href="{{ asset('plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('plugins/notification/snackbar/snackbar.min.css') }}" rel="stylesheet" type="text/css" />

<style>
    textarea:focus,
    input:focus,
    input[type]:focus {
        outline: none;
        box-shadow: none;
    }
</style>

<style>
    [x-cloak] {
        display: none !important;
    }
</style>

<link rel="stylesheet" href="{{ mix('css/app.css') }}">
<script src="{{ mix('js/app.js') }}" defer></script>

@stack('styles')

<!-- Styles -->
@livewireStyles

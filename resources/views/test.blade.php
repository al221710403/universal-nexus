<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    {{--
    <link rel="stylesheet" href="{{ mix('css/app.css') }}"> --}}

</head>

<body class="font-sans antialiased">

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-2 ">
        <div class="p-4 bg-white rounded-lg shadow-lg" style="max-height: 100vh;min-height:100vh;">
            <form action="{{ route('test.store') }}" method="POST">
                @csrf
                <label for="env">Env</label>
                <textarea name="env">{{$datos}}</textarea>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
        </div>
    </div>
</body>

</html>

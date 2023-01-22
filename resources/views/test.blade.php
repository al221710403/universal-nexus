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
            <form action="{{ route('test') }}" method="POST">
                @csrf
                <div>
                    <input type="text" name="title" value="Draf" class="w-full border-0 text-3xl font-sans font-bold">
                </div>

                <div id="editor"></div>


                <textarea name="editor1"></textarea>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
        </div>
    </div>



    <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>



    <script>
        ClassicEditor
            .create( document.querySelector( '#editor' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>


</body>

</html>

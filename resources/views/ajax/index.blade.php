<x-app-layout>
    @push('styles')
    @endpush

    <div class="mx-auto bg-white rounded-md shadow-lg mt-4 p-10">

        <h1 class="mb-4">Prueba de Ajax</h1>

        <form class="w-full max-w-lg" onsubmit="return false;">
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="name">
                        Nombre
                    </label>
                    <input
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                        id="name" type="text" placeholder="Jane">
                </div>
                <div class="w-full md:w-1/2 px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="lastName">
                        Apellido
                    </label>
                    <input
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        id="lastName" type="text" placeholder="Doe">
                </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="password">
                        Contraseña
                    </label>
                    <input
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        id="password" type="password" placeholder="******************">
                    <p class="text-gray-600 text-xs italic">Make it as long and as crazy as youd like</p>
                </div>
            </div>

            {{-- <button type="submit" class="text-white bg-blue-700 px-2 py-1 rounded-md mt-2">Guardar</button> --}}
            <button class="text-white bg-blue-700 px-2 py-1 rounded-md mt-2" id='myajax'>Ajax</button>
        </form>
    </div>




    @push('scripts')
    <script>
        let nombre;
        let apellido;
        let contrasena;
        let data;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#myajax').click(function(){
            if(validate()){
                $.ajax({
                    url:'miJqueryAjax',
                    data:data,
                    type:'post',
                    success: function (response) {
                        console.log(response);
                                alert(response.success);
                    },
                    statusCode: {
                    404: function() {
                        alert('web not found');
                    }
                    },
                    error:function(x,xs,xt){
                        //nos dara el error si es que hay alguno
                        window.open(JSON.stringify(x));
                        //alert('error: ' + JSON.stringify(x) +"\n error string: "+ xs + "\n error throwed: " + xt);
                    }
                });
            }
        });

        function validate(){
            getData();
            let messages='';

            if(nombre == ''){
                messages = "El campo nombre esta vacio\n"
            }

            if(apellido == ''){
                messages += "El campo apellido esta vacio\n"
            }

            if(contrasena == ''){
                messages += "El campo contraseña esta vacio"
            }

            if(messages == ''){
                return true;
            }else{
                alert(messages);
                return false;
            }
        }

        function getData(){
            nombre = document.getElementById('name').value;
            apellido = document.getElementById('lastName').value;
            contrasena = document.getElementById('password').value;

            data={
                nombre,
                apellido,
                contrasena,
            };
            //return data;
        }
    </script>
    @endpush
</x-app-layout>

<script src="{{ asset('js/boxicons.js') }}"></script>

<script src="{{ asset('plugins/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('plugins/notification/snackbar/snackbar.min.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.3.min.js"
    integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>

<script>
    function noty(msg, option = 1){
        Snackbar.show({
            text:msg.toUpperCase(),
            actionText: 'CERRAR',
            actionTextColor: '#fff',
            backgroundColor: option == 1 ? '#1FC237' :
                option == 2 ? '#e7515a' : option == 3 ? '#e2a03f' : '#1b55e2' ,
            pos: 'top-right'
        });
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        window.livewire.on('noty-success', msg=>{
            noty(msg);
        });

        window.livewire.on('noty-danger', msg=>{
            noty(msg,2);
        });

        window.livewire.on('noty-warning', msg=>{
            noty(msg,3);
        });

        window.livewire.on('noty-primary', msg=>{
            noty(msg,4);
        });
    });
</script>

<script>
    function Confirm(msg,emit,id){
        id = id || 0;
        swal({
            title: 'Confirmar',
            text: '¿Confirmas eliminar '+msg+'?',
            type: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#fff',
            confirmButtonText: 'Aceptar'
        }).then(function(result){
            if(result.value){
                if(id == 0){
                    window.livewire.emit(emit)
                }else{
                    window.livewire.emit(emit,id)
                }
                swal.close()
            }
        })
    }

        // Obtener referencia a botones
        // Recuerda: el punto . indica clases
        const srcollBody = document.querySelector('.body-mdl');
        const botones = document.querySelectorAll(".btn-mdl");
        // Definir función y evitar definirla de manera anónima
        const cuandoSeHaceClick = function (evento) {
            // Recuerda, this es el elemento
            console.log("Click en boton :" ,this.dataset.action);

            if (this.dataset.action == 'open')
                srcollBody.classList.add('overflow-hidden')
            else
                srcollBody.classList.remove('overflow-hidden');
            endif


        }
        // botones es un arreglo así que lo recorremos
        botones.forEach(boton => {
            //Agregar listener
            boton.addEventListener("click", cuandoSeHaceClick);
        });
</script>

@stack('scripts')
@livewireScripts

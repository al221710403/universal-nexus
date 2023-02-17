<script src="{{ asset('js/boxicons.js') }}"></script>

<script src="https://unpkg.com/@popperjs/core@2.9.1/dist/umd/popper.min.js" charset="utf-8"></script>
<script src="{{ asset('plugins/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('plugins/notification/snackbar/snackbar.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.3.min.js"
    integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>

{{-- Función y eventos para generar y recibir alertas de notify --}}
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


{{-- Funcion para confirmar eliminar un modelo --}}
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

            if (this.dataset.action == 'open'){
                srcollBody.classList.add('overflow-hidden');
            }else{
                srcollBody.classList.remove('overflow-hidden');
            }
        }
        // botones es un arreglo así que lo recorremos
        botones.forEach(boton => {
            //Agregar listener
            boton.addEventListener("click", cuandoSeHaceClick);
        });
</script>


<script type="text/javascript">
    var tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
  );
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new Tooltip(tooltipTriggerEl);
  });
</script>

@livewireScripts
@stack('scripts')

{{-- Metodos y funciones de boxicons --}}
<script>
    document.addEventListener('DOMContentLoaded', function(){
        Livewire.on('copyToIcon', function () {
            let iconElement = document.getElementsByClassName('icon_selected');
            const clipboard = document.createElement("textarea");

            // PASO 2
            clipboard.value = iconElement[0].innerHTML.trim();
            clipboard.setAttribute("readonly", "");
            // PASO 3
            clipboard.style.position = "absolute";
            clipboard.style.left = "-9999px";
            document.body.appendChild(clipboard);
            // PASO 4
            clipboard.select();

            document.execCommand("copy");
            // PASO 6
            document.body.removeChild(clipboard);
            //alert('copiado');
            console.log('copiado al portapapeles')
            window.livewire.emit('noty-success','Icono copiado')
        });

        Livewire.on('updateIconContainer', function () {
            updateIconShow();
        });

        Livewire.on('readyToSend', function () {
            let iconElement = document.getElementsByClassName('icon_selected');
            let getIconClean = iconElement[0].innerHTML.trim();
            window.livewire.emit('sendIconComponent',getIconClean);
            console.log(getIconClean);
        });
    });


    function updateIconShow(){
        let iconElement = document.getElementsByClassName('icon_selected');
        let iconContainer = document.getElementById('show_icon_i');

        while(iconContainer.hasChildNodes()){
            iconContainer.removeChild(iconContainer.firstChild);
        }

        const iconShow = document.createElement('code');
        iconShow.textContent = iconElement[0].innerHTML;

        iconContainer.appendChild(iconShow);
        //console.log(iconContainer);
    }
</script>

{{-- Quitar cuando el spinner cuando esta lista la pagina --}}
<script>
    window.onload = function() {
      const loader = document.getElementById('loader_main');
      loader.className = 'hidden';
    };
</script>

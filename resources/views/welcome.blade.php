<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificaciones en JavaScript</title>
</head>
<body>
    <button onclick="mostrarNotificacion()">Mostrar Notificación</button>

    <script>

        self.addEventListener("notificationclick", (event) => {
            console.log(event);
            console.log("On notification click: ", event.notification.tag);
            event.notification.close();

            // This looks to see if the current is already open and
            // focuses if it is
            event.waitUntil(
              clients
                .matchAll({
                  type: "window",
                })
                .then((clientList) => {
                  for (const client of clientList) {
                    if (client.url === "/" && "focus" in client) return client.focus();
                  }
                  if (clients.openWindow) return clients.openWindow("/");
                }),
            );
          });

        function mostrarNotificacion() {
            // Verificar si las notificaciones son compatibles con el navegador
            if ('Notification' in window) {
                // Solicitar permiso al usuario si aún no se ha solicitado
                if (Notification.permission !== 'granted') {
                    Notification.requestPermission().then(function (permission) {
                        if (permission === 'granted') {
                            crearNotificacion();
                        }
                    });
                } else {
                    // Si ya se otorgó el permiso, crear y mostrar la notificación
                    crearNotificacion();
                }
            } else {
                alert('Las notificaciones no son compatibles en este navegador.');
            }
        }

        function crearNotificacion() {
            // Crear y mostrar la notificación
            var title = 'Notas de ejemplo';
            var notificacion = new Notification('All in one', {
                body: `HEY! tu tarea "${title}" esta apunto de vencer.`,
                tag:'tags_example',
                data: title,
                requireInteraction: true,
                actions: [
                    { action: 'accion1', title: 'Acción 1' },
                    { action: 'accion2', title: 'Acción 2' }
                ],
                icon: 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/6b/Picture_icon_BLACK.svg/1200px-Picture_icon_BLACK.svg.png' // URL de la imagen del icono
            });

            // Puedes agregar eventos para manejar acciones del usuario, como hacer clic en la notificación
            notificacion.onclick = function () {
                console.log('El usuario hizo clic en la notificación');
            };
        }

    </script>
</body>
</html>

<div id="nav_menu">
        <div id="cont_nombre_vista">
                <h1>
                <?php
                        $titulo = str_replace("-", " ", $url[0]);
                        $titulo = ucwords(strtolower($titulo));
                        $palabras = explode(" ", $titulo);
                        $titulo = implode(" ", array_slice($palabras, 0, 2));
                        echo $titulo;
                ?>
                </h1>
        </div>
        <div id="cont_info_usuario">
                <div id="cont_contador_multitud">
                        <ion-icon name="people-outline"></ion-icon>
                        <p id="titulo_multitud">Multitud: 0</p>
                </div>
                <div id="cont_icon_notificaciones">
                        <ion-icon name="notifications-outline" ></ion-icon>

                        <span id="notification_count">5</span> 
                </div>
               
                <div id="cont_perfil_user">
                        <ion-icon name="person-outline"></ion-icon>
                       <p>Dilan Zapata</p>
                       <ion-icon name="chevron-forward-outline"></ion-icon>
                </div>
        






<script>
   /*  let modalEstadoActual = false;

    function openModal(title, content, datos?) {
        const modal = document.createElement('div');
        modal.classList.add('contenedor-ppal-modal');
        let urlfinal = content
        fetch(urlfinal) // Llamada al archivo PHP con el formulario
        .then(response => response.text()) // Obtener el contenido como texto
        .then(data => {
                
                console.log(data);  // Verifica el contenido que se recibe
                if (data.trim() === "") {
                console.error("El archivo está vacío o no se ha cargado correctamente.");
                } else {
                modal.innerHTML = `
                        <div class="contenedor-titulo-modal">
                        <h2 class="titulo-modal">${title}</h2>
                        <ion-icon name="close-outline" class="close-btn" onclick="closeModal(this)"></ion-icon>
                        </div>
                        <div class="contenedor-info-modal">
                        ${data}
                        </div>
                `;
                }
        })
        .catch(error => console.error('Error:', error));

        // Agrega el modal al contenedor
        document.getElementById('contenedor-modales').appendChild(modal);

        // Mostrar el fondo del modal
        modalEstadoActual = true;
        document.getElementById('contenedor-modales').classList.add('mostrar');
    }

    function closeModal(closeBtn) {
        const modal = closeBtn.closest('.contenedor-ppal-modal');
        modal.remove();

        // Oculta el fondo si ya no hay modales
        if (document.getElementById('contenedor-modales').children.length === 0) {
            document.getElementById('contenedor-modales').classList.remove('mostrar');
            modalEstadoActual = false;
        }
    }

    function getMaxZIndex() {
        const modals = document.querySelectorAll('.contenedor-ppal-modal');
        let maxZIndex = 1000; 
        modals.forEach((modal) => {
            const zIndex = parseInt(window.getComputedStyle(modal).zIndex, 10);
            if (!isNaN(zIndex)) {
                maxZIndex = Math.max(maxZIndex, zIndex);
            }
        });
        return maxZIndex;
    } */
</script>
        </div>
</div>


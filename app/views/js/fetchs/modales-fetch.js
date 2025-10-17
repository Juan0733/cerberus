const contenedorSpinner = document.getElementById('contenedor_spinner');

async function consultarModalActualizarContrasena(urlBase){
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/views/inc/modales/modal-actualizar-contrasena.php', {
            method: 'GET'
        });

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const data = await response.text();
        const respuesta = {
            tipo: 'OK',
            modal: data
        };
        contenedorSpinner.classList.remove("mostrar_spinner");
        return respuesta;

    }catch(error){
        contenedorSpinner.classList.remove("mostrar_spinner");
        console.error('Hubo un error:', error);

        const respuesta = {
            tipo: 'ERROR',
            titulo: '',
            mensaje: ''
        };

        if(!navigator.onLine){
            respuesta.titulo = 'Error Internet';
            respuesta.mensaje = 'Lo sentimos, pero parece que no tienes conexión a internet.';

        }else{
            respuesta.titulo = 'Error Modal';
            respuesta.mensaje = 'Error al cargar modal actualizar contrasena.';
        }
    }
}
export{consultarModalActualizarContrasena}

async function consultarModalAgenda(urlBase){
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/views/inc/modales/modal-agenda.php', {
            method: 'GET'
        });

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const data = await response.text();
        const respuesta = {
            tipo: 'OK',
            modal: data
        };
        contenedorSpinner.classList.remove("mostrar_spinner");
        return respuesta;

    }catch(error){
        contenedorSpinner.classList.remove("mostrar_spinner");
        console.error('Hubo un error:', error);

        const respuesta = {
            tipo: 'ERROR',
            titulo: '',
            mensaje: ''
        };

        if(!navigator.onLine){
            respuesta.titulo = 'Error Internet';
            respuesta.mensaje = 'Lo sentimos, pero parece que no tienes conexión a internet.';

        }else{
            respuesta.titulo = 'Error Modal';
            respuesta.mensaje = 'Error al cargar modal agenda.';
        }
    }
}
export{consultarModalAgenda}

async function consultarModalAprendiz(urlBase){
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/views/inc/modales/modal-aprendiz.php', {
            method: 'GET'
        });

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const data = await response.text();
        const respuesta = {
            tipo: 'OK',
            modal: data
        };
        contenedorSpinner.classList.remove("mostrar_spinner");
        return respuesta;

    }catch(error){
        contenedorSpinner.classList.remove("mostrar_spinner");
        console.error('Hubo un error:', error);

        const respuesta = {
            tipo: 'ERROR',
            titulo: '',
            mensaje: ''
        };

        if(!navigator.onLine){
            respuesta.titulo = 'Error Internet';
            respuesta.mensaje = 'Lo sentimos, pero parece que no tienes conexión a internet.';

        }else{
            respuesta.titulo = 'Error Modal';
            respuesta.mensaje = 'Error al cargar modal aprendiz.';
        }
    }
}
export{consultarModalAprendiz}

async function consultarModalBrigadistas(urlBase){
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/views/inc/modales/modal-brigadistas.php', {
            method: 'GET'
        });

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const data = await response.text();
        const respuesta = {
            tipo: 'OK',
            modal: data
        };
        contenedorSpinner.classList.remove("mostrar_spinner");
        return respuesta;

    }catch(error){
        contenedorSpinner.classList.remove("mostrar_spinner");
        console.error('Hubo un error:', error);

        const respuesta = {
            tipo: 'ERROR',
            titulo: '',
            mensaje: ''
        };

        if(!navigator.onLine){
            respuesta.titulo = 'Error Internet';
            respuesta.mensaje = 'Lo sentimos, pero parece que no tienes conexión a internet.';

        }else{
            respuesta.titulo = 'Error Modal';
            respuesta.mensaje = 'Error al cargar modal funcionarios brigadistas.';
        }
    }
}
export{consultarModalBrigadistas}

async function consultarModalDetalleAgenda(urlBase){
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/views/inc/modales/modal-detalle-agenda.php', {
            method: 'GET'
        });

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const data = await response.text();
        const respuesta = {
            tipo: 'OK',
            modal: data
        };
        contenedorSpinner.classList.remove("mostrar_spinner");
        return respuesta;

    }catch(error){
        contenedorSpinner.classList.remove("mostrar_spinner");
        console.error('Hubo un error:', error);

        const respuesta = {
            tipo: 'ERROR',
            titulo: '',
            mensaje: ''
        };

        if(!navigator.onLine){
            respuesta.titulo = 'Error Internet';
            respuesta.mensaje = 'Lo sentimos, pero parece que no tienes conexión a internet.';

        }else{
            respuesta.titulo = 'Error Modal';
            respuesta.mensaje = 'Error al cargar modal detalle agenda.';
        }
    }
}
export{consultarModalDetalleAgenda}

async function consultarModalDetalleAprendiz(urlBase){
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/views/inc/modales/modal-detalle-aprendiz.php', {
            method: 'GET'
        });

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const data = await response.text();
        const respuesta = {
            tipo: 'OK',
            modal: data
        };
        contenedorSpinner.classList.remove("mostrar_spinner");
        return respuesta;

    }catch(error){
        contenedorSpinner.classList.remove("mostrar_spinner");
        console.error('Hubo un error:', error);

        const respuesta = {
            tipo: 'ERROR',
            titulo: '',
            mensaje: ''
        };

        if(!navigator.onLine){
            respuesta.titulo = 'Error Internet';
            respuesta.mensaje = 'Lo sentimos, pero parece que no tienes conexión a internet.';

        }else{
            respuesta.titulo = 'Error Modal';
            respuesta.mensaje = 'Error al cargar modal detalle aprendiz.';
        }
    }
}
export{consultarModalDetalleAprendiz}

async function consultarModalDetalleFuncionario(urlBase){
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/views/inc/modales/modal-detalle-funcionario.php', {
            method: 'GET'
        });

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const data = await response.text();
        const respuesta = {
            tipo: 'OK',
            modal: data
        };
        contenedorSpinner.classList.remove("mostrar_spinner");
        return respuesta;

    }catch(error){
        contenedorSpinner.classList.remove("mostrar_spinner");
        console.error('Hubo un error:', error);

        const respuesta = {
            tipo: 'ERROR',
            titulo: '',
            mensaje: ''
        };

        if(!navigator.onLine){
            respuesta.titulo = 'Error Internet';
            respuesta.mensaje = 'Lo sentimos, pero parece que no tienes conexión a internet.';

        }else{
            respuesta.titulo = 'Error Modal';
            respuesta.mensaje = 'Error al cargar modal detalle funcionario.';
        }
    }
}
export{consultarModalDetalleFuncionario}

async function consultarModalDetalleMovimiento(urlBase){
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/views/inc/modales/modal-detalle-movimiento.php', {
            method: 'GET'
        });

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const data = await response.text();
        const respuesta = {
            tipo: 'OK',
            modal: data
        };
        contenedorSpinner.classList.remove("mostrar_spinner");
        return respuesta;

    }catch(error){
        contenedorSpinner.classList.remove("mostrar_spinner");
        console.error('Hubo un error:', error);

        const respuesta = {
            tipo: 'ERROR',
            titulo: '',
            mensaje: ''
        };

        if(!navigator.onLine){
            respuesta.titulo = 'Error Internet';
            respuesta.mensaje = 'Lo sentimos, pero parece que no tienes conexión a internet.';

        }else{
            respuesta.titulo = 'Error Modal';
            respuesta.mensaje = 'Error al cargar modal detalle movimiento.';
        }
    }
}
export{consultarModalDetalleMovimiento}

async function consultarModalDetalleNovedadUsuario(urlBase){
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/views/inc/modales/modal-detalle-novedad-usuario.php', {
            method: 'GET'
        });

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const data = await response.text();
        const respuesta = {
            tipo: 'OK',
            modal: data
        };
        contenedorSpinner.classList.remove("mostrar_spinner");
        return respuesta;

    }catch(error){
        contenedorSpinner.classList.remove("mostrar_spinner");
        console.error('Hubo un error:', error);

        const respuesta = {
            tipo: 'ERROR',
            titulo: '',
            mensaje: ''
        };

        if(!navigator.onLine){
            respuesta.titulo = 'Error Internet';
            respuesta.mensaje = 'Lo sentimos, pero parece que no tienes conexión a internet.';

        }else{
            respuesta.titulo = 'Error Modal';
            respuesta.mensaje = 'Error al cargar modal detalle novedad usuario.';
        }
    }
}
export{consultarModalDetalleNovedadUsuario}

async function consultarModalDetalleNovedadVehiculo(urlBase){
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/views/inc/modales/modal-detalle-novedad-vehiculo.php', {
            method: 'GET'
        });

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const data = await response.text();
        const respuesta = {
            tipo: 'OK',
            modal: data
        };
        contenedorSpinner.classList.remove("mostrar_spinner");
        return respuesta;

    }catch(error){
        contenedorSpinner.classList.remove("mostrar_spinner");
        console.error('Hubo un error:', error);

        const respuesta = {
            tipo: 'ERROR',
            titulo: '',
            mensaje: ''
        };

        if(!navigator.onLine){
            respuesta.titulo = 'Error Internet';
            respuesta.mensaje = 'Lo sentimos, pero parece que no tienes conexión a internet.';

        }else{
            respuesta.titulo = 'Error Modal';
            respuesta.mensaje = 'Error al cargar modal detalle novedad vehículo.';
        }
    }
}
export{consultarModalDetalleNovedadVehiculo}

async function consultarModalDetallePermisoUsuario(urlBase){
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/views/inc/modales/modal-detalle-permiso-usuario.php', {
            method: 'GET'
        });

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const data = await response.text();
        const respuesta = {
            tipo: 'OK',
            modal: data
        };
        contenedorSpinner.classList.remove("mostrar_spinner");
        return respuesta;

    }catch(error){
        contenedorSpinner.classList.remove("mostrar_spinner");
        console.error('Hubo un error:', error);

        const respuesta = {
            tipo: 'ERROR',
            titulo: '',
            mensaje: ''
        };

        if(!navigator.onLine){
            respuesta.titulo = 'Error Internet';
            respuesta.mensaje = 'Lo sentimos, pero parece que no tienes conexión a internet.';

        }else{
            respuesta.titulo = 'Error Modal';
            respuesta.mensaje = 'Error al cargar modal detalle permiso usuario.';
        }
    }
}
export{consultarModalDetallePermisoUsuario}

async function consultarModalDetallePermisoVehiculo(urlBase){
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/views/inc/modales/modal-detalle-permiso-vehiculo.php', {
            method: 'GET'
        });

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const data = await response.text();
        const respuesta = {
            tipo: 'OK',
            modal: data
        };
        contenedorSpinner.classList.remove("mostrar_spinner");
        return respuesta;

    }catch(error){
        contenedorSpinner.classList.remove("mostrar_spinner");
        console.error('Hubo un error:', error);

        const respuesta = {
            tipo: 'ERROR',
            titulo: '',
            mensaje: ''
        };

        if(!navigator.onLine){
            respuesta.titulo = 'Error Internet';
            respuesta.mensaje = 'Lo sentimos, pero parece que no tienes conexión a internet.';

        }else{
            respuesta.titulo = 'Error Modal';
            respuesta.mensaje = 'Error al cargar modal detalle permiso vehículo.';
        }
    }
}
export{consultarModalDetallePermisoVehiculo}

async function consultarModalDetalleVigilante(urlBase){
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/views/inc/modales/modal-detalle-vigilante.php', {
            method: 'GET'
        });

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const data = await response.text();
        const respuesta = {
            tipo: 'OK',
            modal: data
        };
        contenedorSpinner.classList.remove("mostrar_spinner");
        return respuesta;

    }catch(error){
        contenedorSpinner.classList.remove("mostrar_spinner");
        console.error('Hubo un error:', error);

        const respuesta = {
            tipo: 'ERROR',
            titulo: '',
            mensaje: ''
        };

        if(!navigator.onLine){
            respuesta.titulo = 'Error Internet';
            respuesta.mensaje = 'Lo sentimos, pero parece que no tienes conexión a internet.';

        }else{
            respuesta.titulo = 'Error Modal';
            respuesta.mensaje = 'Error al cargar modal detalle vigilante.';
        }
    }
}
export{consultarModalDetalleVigilante}

async function consultarModalDetalleVisitante(urlBase){
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/views/inc/modales/modal-detalle-visitante.php', {
            method: 'GET'
        });

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const data = await response.text();
        const respuesta = {
            tipo: 'OK',
            modal: data
        };
        contenedorSpinner.classList.remove("mostrar_spinner");
        return respuesta;

    }catch(error){
        contenedorSpinner.classList.remove("mostrar_spinner");
        console.error('Hubo un error:', error);

        const respuesta = {
            tipo: 'ERROR',
            titulo: '',
            mensaje: ''
        };

        if(!navigator.onLine){
            respuesta.titulo = 'Error Internet';
            respuesta.mensaje = 'Lo sentimos, pero parece que no tienes conexión a internet.';

        }else{
            respuesta.titulo = 'Error Modal';
            respuesta.mensaje = 'Error al cargar modal detalle visitante.';
        }
    }
}
export{consultarModalDetalleVisitante}

async function consultarModalFuncionario(urlBase){
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/views/inc/modales/modal-funcionario.php', {
            method: 'GET'
        });

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const data = await response.text();
        const respuesta = {
            tipo: 'OK',
            modal: data
        };
        contenedorSpinner.classList.remove("mostrar_spinner");
        return respuesta;

    }catch(error){
        contenedorSpinner.classList.remove("mostrar_spinner");
        console.error('Hubo un error:', error);

        const respuesta = {
            tipo: 'ERROR',
            titulo: '',
            mensaje: ''
        };

        if(!navigator.onLine){
            respuesta.titulo = 'Error Internet';
            respuesta.mensaje = 'Lo sentimos, pero parece que no tienes conexión a internet.';

        }else{
            respuesta.titulo = 'Error Modal';
            respuesta.mensaje = 'Error al cargar modal funcionario.';
        }
    }
}
export{consultarModalFuncionario}

async function consultarModalNovedadUsuario(urlBase){
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/views/inc/modales/modal-novedad-usuario.php', {
            method: 'GET'
        });

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const data = await response.text();
        const respuesta = {
            tipo: 'OK',
            modal: data
        };
        contenedorSpinner.classList.remove("mostrar_spinner");
        return respuesta;

    }catch(error){
        contenedorSpinner.classList.remove("mostrar_spinner");
        console.error('Hubo un error:', error);

        const respuesta = {
            tipo: 'ERROR',
            titulo: '',
            mensaje: ''
        };

        if(!navigator.onLine){
            respuesta.titulo = 'Error Internet';
            respuesta.mensaje = 'Lo sentimos, pero parece que no tienes conexión a internet.';

        }else{
            respuesta.titulo = 'Error Modal';
            respuesta.mensaje = 'Error al cargar modal novedad usuario.';
        }
    }
}
export{consultarModalNovedadUsuario}

async function consultarModalNovedadVehiculo(urlBase){
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/views/inc/modales/modal-novedad-vehiculo.php', {
            method: 'GET'
        });

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const data = await response.text();
        const respuesta = {
            tipo: 'OK',
            modal: data
        };
        contenedorSpinner.classList.remove("mostrar_spinner");
        return respuesta;

    }catch(error){
        contenedorSpinner.classList.remove("mostrar_spinner");
        console.error('Hubo un error:', error);

        const respuesta = {
            tipo: 'ERROR',
            titulo: '',
            mensaje: ''
        };

        if(!navigator.onLine){
            respuesta.titulo = 'Error Internet';
            respuesta.mensaje = 'Lo sentimos, pero parece que no tienes conexión a internet.';

        }else{
            respuesta.titulo = 'Error Modal';
            respuesta.mensaje = 'Error al cargar modal novedad vehiculo.';
        }
    }
}
export{consultarModalNovedadVehiculo}

async function consultarModalPermisoUsuario(urlBase){
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/views/inc/modales/modal-permiso-usuario.php', {
            method: 'GET'
        });

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const data = await response.text();
        const respuesta = {
            tipo: 'OK',
            modal: data
        };
        contenedorSpinner.classList.remove("mostrar_spinner");
        return respuesta;

    }catch(error){
        contenedorSpinner.classList.remove("mostrar_spinner");
        console.error('Hubo un error:', error);

        const respuesta = {
            tipo: 'ERROR',
            titulo: '',
            mensaje: ''
        };

        if(!navigator.onLine){
            respuesta.titulo = 'Error Internet';
            respuesta.mensaje = 'Lo sentimos, pero parece que no tienes conexión a internet.';

        }else{
            respuesta.titulo = 'Error Modal';
            respuesta.mensaje = 'Error al cargar modal permiso usuario.';
        }
    }
}
export{consultarModalPermisoUsuario}

async function consultarModalPermisoVehiculo(urlBase){
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/views/inc/modales/modal-permiso-vehiculo.php', {
            method: 'GET'
        });

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const data = await response.text();
        const respuesta = {
            tipo: 'OK',
            modal: data
        };
        contenedorSpinner.classList.remove("mostrar_spinner");
        return respuesta;

    }catch(error){
        contenedorSpinner.classList.remove("mostrar_spinner");
        console.error('Hubo un error:', error);

        const respuesta = {
            tipo: 'ERROR',
            titulo: '',
            mensaje: ''
        };

        if(!navigator.onLine){
            respuesta.titulo = 'Error Internet';
            respuesta.mensaje = 'Lo sentimos, pero parece que no tienes conexión a internet.';

        }else{
            respuesta.titulo = 'Error Modal';
            respuesta.mensaje = 'Error al cargar modal permiso vehiculo.';
        }
    }
}
export{consultarModalPermisoVehiculo}

async function consultarModalPropietariosVehiculo(urlBase){
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/views/inc/modales/modal-propietarios-vehiculo.php', {
            method: 'GET'
        });

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const data = await response.text();
        const respuesta = {
            tipo: 'OK',
            modal: data
        };
        contenedorSpinner.classList.remove("mostrar_spinner");
        return respuesta;

    }catch(error){
        contenedorSpinner.classList.remove("mostrar_spinner");
        console.error('Hubo un error:', error);

        const respuesta = {
            tipo: 'ERROR',
            titulo: '',
            mensaje: ''
        };

        if(!navigator.onLine){
            respuesta.titulo = 'Error Internet';
            respuesta.mensaje = 'Lo sentimos, pero parece que no tienes conexión a internet.';

        }else{
            respuesta.titulo = 'Error Modal';
            respuesta.mensaje = 'Error al cargar modal propietarios vehículo.';
        }
    }
}
export{consultarModalPropietariosVehiculo}

async function consultarModalScanerQr(urlBase){
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/views/inc/modales/modal-scaner-qr.php', {
            method: 'GET'
        });

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const data = await response.text();
        const respuesta = {
            tipo: 'OK',
            modal: data
        };
        contenedorSpinner.classList.remove("mostrar_spinner");
        return respuesta;

    }catch(error){
        contenedorSpinner.classList.remove("mostrar_spinner");
        console.error('Hubo un error:', error);

        const respuesta = {
            tipo: 'ERROR',
            titulo: '',
            mensaje: ''
        };

        if(!navigator.onLine){
            respuesta.titulo = 'Error Internet';
            respuesta.mensaje = 'Lo sentimos, pero parece que no tienes conexión a internet.';

        }else{
            respuesta.titulo = 'Error Modal';
            respuesta.mensaje = 'Error al cargar modal scaner qr.';
        }
    }
}
export{consultarModalScanerQr}

async function consultarModalSeleccionPuerta(urlBase){
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/views/inc/modales/modal-seleccion-puerta.php', {
            method: 'GET'
        });

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const data = await response.text();
        const respuesta = {
            tipo: 'OK',
            modal: data
        };
        contenedorSpinner.classList.remove("mostrar_spinner");
        return respuesta;

    }catch(error){
        contenedorSpinner.classList.remove("mostrar_spinner");
        console.error('Hubo un error:', error);

        const respuesta = {
            tipo: 'ERROR',
            titulo: '',
            mensaje: ''
        };

        if(!navigator.onLine){
            respuesta.titulo = 'Error Internet';
            respuesta.mensaje = 'Lo sentimos, pero parece que no tienes conexión a internet.';

        }else{
            respuesta.titulo = 'Error Modal';
            respuesta.mensaje = 'Error al cargar modal selección puerta.';
        }
    }
}
export{consultarModalSeleccionPuerta}

async function consultarModalVehiculo(urlBase){
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/views/inc/modales/modal-vehiculo.php', {
            method: 'GET'
        });

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const data = await response.text();
        const respuesta = {
            tipo: 'OK',
            modal: data
        };
        contenedorSpinner.classList.remove("mostrar_spinner");
        return respuesta;

    }catch(error){
        contenedorSpinner.classList.remove("mostrar_spinner");
        console.error('Hubo un error:', error);

        const respuesta = {
            tipo: 'ERROR',
            titulo: '',
            mensaje: ''
        };

        if(!navigator.onLine){
            respuesta.titulo = 'Error Internet';
            respuesta.mensaje = 'Lo sentimos, pero parece que no tienes conexión a internet.';

        }else{
            respuesta.titulo = 'Error Modal';
            respuesta.mensaje = 'Error al cargar modal vehículo.';
        }
    }
}
export{consultarModalVehiculo}

async function consultarModalVigilante(urlBase){
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/views/inc/modales/modal-vigilante.php', {
            method: 'GET'
        });

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const data = await response.text();
        const respuesta = {
            tipo: 'OK',
            modal: data
        };
        contenedorSpinner.classList.remove("mostrar_spinner");
        return respuesta;

    }catch(error){
        contenedorSpinner.classList.remove("mostrar_spinner");
        console.error('Hubo un error:', error);

        const respuesta = {
            tipo: 'ERROR',
            titulo: '',
            mensaje: ''
        };

        if(!navigator.onLine){
            respuesta.titulo = 'Error Internet';
            respuesta.mensaje = 'Lo sentimos, pero parece que no tienes conexión a internet.';

        }else{
            respuesta.titulo = 'Error Modal';
            respuesta.mensaje = 'Error al cargar modal vigilante.';
        }
    }
}
export{consultarModalVigilante}

async function consultarModalVisitante(urlBase){
    try {
        contenedorSpinner.classList.add("mostrar_spinner");
        const response = await fetch(urlBase+'app/views/inc/modales/modal-visitante.php', {
            method: 'GET'
        });

        if(!response.ok) throw new Error('Hubo un error en la solicitud');

        const data = await response.text();
        const respuesta = {
            tipo: 'OK',
            modal: data
        };
        contenedorSpinner.classList.remove("mostrar_spinner");
        return respuesta;

    }catch(error){
        contenedorSpinner.classList.remove("mostrar_spinner");
        console.error('Hubo un error:', error);

        const respuesta = {
            tipo: 'ERROR',
            titulo: '',
            mensaje: ''
        };

        if(!navigator.onLine){
            respuesta.titulo = 'Error Internet';
            respuesta.mensaje = 'Lo sentimos, pero parece que no tienes conexión a internet.';

        }else{
            respuesta.titulo = 'Error Modal';
            respuesta.mensaje = 'Error al cargar modal visitante.';
        }
    }
}
export{consultarModalVisitante}
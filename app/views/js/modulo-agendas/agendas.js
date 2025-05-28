document.addEventListener('DOMContentLoaded', function () {

    const calendarioEl = document.getElementById('calendario-mes');

    if (!calendarioEl) {
        console.error('No se encontró el elemento con ID "calendario-mes" en el DOM.');
        return;
    }

    // Inicializar el calendario
    const calendario = new FullCalendar.Calendar(calendarioEl, {
        initialView: 'dayGridMonth',
        locale: 'es', // Configuración de idioma
        headerToolbar: {
            left: 'prev,next', // Botones de navegación
            center: 'title', // Título del mes
            right: '' // Sin botones adicionales
        },
        dateClick: function (info) {
            
            seleccionarDia(info.date); // Cambiar a vista solo de sábado y domingo al hacer clic en una fecha

        },
        
    });

    calendario.render(); // Renderizar el calendario
});

const diasSemana = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
const horas = ["7am", "8am", "9am", "10am", "11am", "12pm", "1pm", "2pm", "3pm", "4pm", "5pm", "6pm"];

// Función para mostrar solo sábado y domingo
function seleccionarDia(fecha) {
    const encabezadoSemana = document.getElementById('encabezado-semana');
    const cuadriculaSemana = document.getElementById('cuadricula-semana');

    // Verificar que ambos elementos existan
    if (!encabezadoSemana || !cuadriculaSemana) {
        console.error('No se encontraron los elementos "encabezado-semana" o "cuadricula-semana" en el DOM.');
        return;
    }

    // Limpiar contenido previo
    encabezadoSemana.innerHTML = '';
    cuadriculaSemana.innerHTML = '';

    const diaSeleccionado = fecha.getDay();

    const fechas = [];
    for (let i = 0; i < 7; i++) {
        
        const nuevoDia = new Date(fecha);
        nuevoDia.setDate(fecha.getDate() - diaSeleccionado + i);
        const anio = nuevoDia.getFullYear(); // Obtiene el año
        const mes = String(nuevoDia.getMonth() + 1).padStart(2, '0'); // Obtiene el mes (0-11) y agrega un 0 si es necesario
        const dia = String(nuevoDia.getDate()).padStart(2, '0'); // Obtiene el día del mes (1-31) y agrega un 0 si es necesario


        const formato = `${anio}-${mes}-${dia}`;
        if (i == 0 || i == 6){
            fechas.push(formato)
            
        }

    }
    listarAgenda(fechas[0],fechas[1])
    
    
}


function listarAgenda(fechainicio,fechafin) {
    
    
    let cuerpo = document.getElementById("cuadricula-semana")
    let formData = new FormData()
    
    formData.append('modulo_agenda', "listar")
    formData.append('fechainicio', fechainicio)
    formData.append('fechafin', fechafin)
    
    
    

    fetch("../app/ajax/agendaAjax.php",{
        method:"POST",
        body: formData
    }).then(response => {
        if (!response.ok) {
            throw new Error("Error en la respuesta del servidor");
        }
        return response.json();
    })
    .then(data => {
        cuerpo.innerHTML = data.data
    }).catch(err => console.log(err))

}


document.addEventListener('DOMContentLoaded',()=>{
    let btn_continuar = document.getElementById('btn_continuar')
    let grupo_1 = document.getElementById('grupo_1')
    let grupo_2 = document.getElementById('grupo_2_formularios')
    let btn_aterior = document.getElementById('btn_anterior_formularios')
    
    
    
    btn_continuar.addEventListener('click', ()=>{
        const inputs = grupo_1.querySelectorAll('input, select');
        let valid = true;
        inputs.forEach(input => {
            if (!input.checkValidity()) {
                input.reportValidity();
                valid = false;
            }
        });
        if (valid) {
            grupo_1.style.display = "none"
            grupo_2.style.display = "block"
            
        }
    })
    btn_aterior.addEventListener('click', ()=>{
        grupo_2.style.display = "none"
        grupo_1.style.display = "block"
        
        
    })
    
    window.addEventListener('resize', function() {
        if(this.window.innerWidth>767){
            grupo_1.style.display = "block"
            grupo_2.style.display = "block"
        } else{
            grupo_2.style.display = "none"
        }
        
        // console.log('El tamaño de la pantalla ha cambiado!'); console.log(`Ancho: ${window.innerWidth}, Alto: ${window.innerHeight}`); 
    });
})

document.getElementById("nombre_programa_s").addEventListener("change", function () {
    const div = document.getElementById("secundario");
    if (this.value === "otro") {
        div.style.display = "block"; // Muestra el div
    } else {
        div.style.display = "none"; // Oculta el div
    }
});

// Obtener los elementos de los campos de fecha
const fechaInicio = document.getElementById('fecha_inicio');
const fechaFin = document.getElementById('fecha_fin');

// Función que actualiza el campo fecha_fin cuando se selecciona una fecha en fecha_inicio
fechaInicio.addEventListener('change', function() {
    // Obtener la fecha de inicio seleccionada
    const fechaSeleccionada = new Date(fechaInicio.value);
    
    // Sumar un mes a la fecha seleccionada para la fecha máxima de fecha_fin
    fechaSeleccionada.setMonth(fechaSeleccionada.getMonth() + 3);
    
    // Formatear la fecha máxima en formato YYYY-MM-DD
    const fechaMinima = fechaSeleccionada.toISOString().split('T')[0];
        
    fechaSeleccionada.setMonth(fechaSeleccionada.getMonth() + 24);

    // Formatear la fecha máxima en formato YYYY-MM-DD
    const fechaMaxima = fechaSeleccionada.toISOString().split('T')[0];
    
    // Establecer el valor mínimo de fecha_fin como la fecha seleccionada en fecha_inicio
    fechaFin.setAttribute('min', fechaMinima);
    
    // Establecer el valor máximo de fecha_fin como un mes después de fecha_inicio
    fechaFin.setAttribute('max', fechaMaxima);
        });
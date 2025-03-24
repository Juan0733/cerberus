getListadoUltimosRegistrosInformes()


function getListadoUltimosRegistrosInformes() {
    var contenedorListado = document.getElementById('contenedor_tabla')
    let formData = new FormData()
    if (window.innerWidth > 780) {
        formData.append('tipoListado', 'tabla')
    }else{
        formData.append('tipoListado', 'card')
    }
    
    formData.append('modulo_conteo', 'listadoUltimosRegistros')
    fetch('../app/ajax/conteos-fetch.php',{
        method: 'POST',
        body: formData,
        mode: 'cors', 
        cache: 'no-cache',
    }).then(response => {
        if (!response.ok) {
            throw new Error("Error en la respuesta del servidor");
        }
        return response.json();
    })
    .then(resultado => {
        contenedorListado.innerHTML = resultado.listado
    }).catch(err => console.log(err))

    
}


function generarInforme(url, tipoInforme) {
    if (tipoInforme == "persona") {
        var idPersona = document.getElementById('persona-identificacion-informes').value;
        var fechaInicio = document.getElementById('fecha_inicio_input').value;
        var fechaFinal = document.getElementById('fecha_final_input').value;

        // Verificar cuáles campos están vacíos
        var camposFaltantes = [];
        if (!idPersona) {
            alert(document.getElementById('persona-identificacion-informes').value)
            camposFaltantes.push('Identificación de la persona');
        }
        if (!fechaInicio) {
            camposFaltantes.push('Fecha de inicio');
        }
        if (!fechaFinal) {
            camposFaltantes.push('Fecha final');
        }

        if (camposFaltantes.length > 0) {
            alert('Los siguientes campos son obligatorios: \n' + camposFaltantes.join('\n'));
            return;
        }

        var url = url + `?id_persona=${idPersona}&fecha_inicio=${fechaInicio}&fecha_final=${fechaFinal}`;
        window.open(url, 'Imprimir factura', 'width=820,height=720,top=0,left=100,menubar=NO,toolbar=YES');
    }
}

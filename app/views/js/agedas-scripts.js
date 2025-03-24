
alert('hola')
// Agregar una persona a la tabla grupal
document.getElementById('btnAgregarPersona').addEventListener('click', function () {
    const documento = document.getElementById('documentoPersona').value;
    var tabla = document.getElementById('grupal_tabla_personas')
    var formData = new FormData();
    formData.append('modulo_agenda', 'buscar_persona')
    formData.append('documento', documento)
    
    if (documento) {
        fetch('../app/ajax/agendaAjax.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.nombre && data.apellidos && data.tipo_documento && data.num_identificacion) {
                const nuevaFila = `
                    <tr data-documento="${data.num_identificacion}">
                        <td>${data.tipo_documento}</td>
                        <td>${data.num_identificacion}</td>
                        <td>${data.nombre}</td>
                        <td>${data.apellidos}</td>
                    </tr>
                `;
                tabla.innerHTML += nuevaFila;
            } else {
                console.log(data);
                if(data.codigo == 'UNEBD'){
                    Swal.fire({
                        icon: data.icono,
                        title: data.titulo,
                        text: data.mensaje,
                        showCancelButton: true,
                        confirmButtonText: 'Aceptar',
                        cancelButtonText: 'Cancelar',
                        customClass: {
                            popup: 'alerta-contenedor',
                            confirmButton: 'btn-confirmar',
                            cancelButton: 'btn-cancelar' 
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            console.log(data.adaptar)
                            openModal(data.tituloModal, data.url, data.adaptar) 
                        } 
                    });
                }
            }
            
        })
        .catch(error => console.error('Error al buscar persona:', error));
    } else {
        alert('Por favor ingresa un número de documento.');
    }
});

document.getElementById('formularioAgenda').addEventListener('submit', function (e) {
    e.preventDefault();
     var checkAgenda = document.getElementById('grupalCheckbox');
    var checkVehiculo = document.getElementById('vehiculoCheckbox')
    if (!checkAgenda.checked) {
        if (!checkVehiculo.checked) {
            /* Agenda sin vehiculo y sin grupal */

        }else{
            /* Agenda con vehiculo */
        }
    }else{/* Agenda grupal check Box esta activo */
        var personas = [];
        var registroGrupal = document.querySelectorAll('#tablaResultados tbody tr');
        registroGrupal.forEach(function(registro) {
            var numeroIdentidad = registro.cells[3].textContent;
            personas.push(numeroIdentidad);
        })

        console.log(personas);
        if (!checkVehiculo.checked) {
            /* Agenda sin vehiculo pero grupal */
            var formData = new FormData(this);
            formData.append('modulo_agenda', 'registrar')
            formData.append('registroGrupal', JSON.stringify(personas));
            fetch('../app/ajax/agendaAjax.php',{
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                  // Si la respuesta no es 2xx, muestra el código de error
                  throw new Error(`HTTP error! Status: ${response.status}`);
                }else{
                    console.log(response)
                }
                return response.json(); // Intentar convertir a JSON
              })
            .then(respuesta => {
                console.log(respuesta)
                
            })
            .catch(error => console.error('Error encontrado> ', error))

        }else{
            /* Agenda con vehiculo y grupal */
        }
    }
});
document.getElementById('archivoExcel').addEventListener('change', function(event) {
    const archivo = event.target.files[0];

    if (archivo) {
        const lector = new FileReader();

        lector.onload = function(event) {
            const datos = new Uint8Array(event.target.result);
            const workbook = XLSX.read(datos, { type: 'array' });

            const hojaNombre = workbook.SheetNames[0];
            const hoja = workbook.Sheets[hojaNombre];

            const datosJSON = XLSX.utils.sheet_to_json(hoja, { header: 1 });

            const identidadesVistas = new Set();
            const registrosDuplicados = [];

            const tbody = document.getElementById('grupal_tabla_personas');
            tbody.innerHTML = '';

            let registrosProcesados = 0; 
            let totalRegistros = datosJSON.length - 3; 
            const promesas = []; 

            datosJSON.slice(1).forEach(fila => {
               
                if (fila.every(celda => celda === "" || celda === null || celda === undefined)) {
                    return; 
                }

                const numIdentidad = fila[1];
                
                if (identidadesVistas.has(numIdentidad)) {
                    registrosDuplicados.push(fila); 
                    return; 
                }

                
                identidadesVistas.add(numIdentidad);
                

                
                var formData = new FormData();
                formData.append('modulo_agenda', 'buscar_persona');
                formData.append('masivo', 'masivo');
                formData.append('documento', numIdentidad);

                fila.forEach((celda, index) => {
                    formData.append(`campo_${index}`, celda); 
                });

                
                const promesa = fetch('../app/ajax/agendaAjax.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Respuesta del backend:', data);
                    if (data.codigo == 'RVAEX') {
                        identidadesVistas.add(numIdentidad);
                    } else if(data.codigo == 'UNEBD'){
                        Swal.fire({
                            icon: data.icono,
                            title: data.titulo,
                            text: data.mensaje,
                            showCancelButton: true,
                            confirmButtonText: 'Aceptar',
                            cancelButtonText: 'Cancelar',
                            customClass: {
                                popup: 'alerta-contenedor',
                                confirmButton: 'btn-confirmar',
                                cancelButton: 'btn-cancelar' 
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                console.log(data.adaptar)
                                openModal(data.tituloModal, data.url, data.adaptar) 
                            } 
                        });
                    }else{
                        


                        Swal.fire({
                            icon: 'error',
                            title: 'Error al Registrar',
                            text: 'Ocurrio un error al intentar registrar ' + numIdentidad ,
                            confirmButtonText: 'Aceptar',
                            customClass: {
                                popup: 'alerta-contenedor',
                                confirmButton: 'btn-confirmar'
                            }
                        });
                    }

                    registrosProcesados++; 
                    
                    
                    if (registrosProcesados === totalRegistros) {


                            Swal.fire({
                                icon: 'success',
                                title: 'Carga Completada',
                                text: 'El excel con las persona para agendar a sido procesado con exito',
                                confirmButtonText: 'Aceptar',
                                customClass: {
                                    popup: 'alerta-contenedor',
                                    confirmButton: 'btn-confirmar'
                                }
                            });
                    }
                    
                })
                .catch(error => {
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al cargar uno de los datos',
                        text: 'ERROR',
                        confirmButtonText: 'Aceptar',
                        customClass: {
                            popup: 'alerta-contenedor',
                            confirmButton: 'btn-confirmar'
                        }
                    });
                    registrosProcesados++; 
                });

                
                promesas.push(promesa);

                const filaHTML = document.createElement('tr');
                fila.forEach(celda => {
                    const celdaHTML = document.createElement('td');
                    celdaHTML.textContent = celda || ''; 
                    filaHTML.appendChild(celdaHTML);
                });

                
                tbody.appendChild(filaHTML);
            });


            Promise.all(promesas).then(() => {
                if (registrosDuplicados.length > 0) {
                    
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al cargar uno de los datos',
                        text: 'ERROR',
                        confirmButtonText: 'Aceptar',
                        customClass: {
                            popup: 'alerta-contenedor',
                            confirmButton: 'btn-confirmar'
                        }
                    });
                    

                    Swal.fire({
                        icon: 'error',
                        title: 'Datos Duplicados',
                        text: 'Se encontraron personas duplicadas, ten en cuenta que se saltanron los registros duplicados y se dejo un unico registro, si deseas descargar un excel con esas personas da click en aceptar si no es asi da click fuera de la modal.',
                        confirmButtonText: 'Aceptar',
                        cancelButtonText: 'Cancelar',
                        customClass: {
                            popup: 'alerta-contenedor',
                            confirmButton: 'btn-confirmar',
                            cancelButton: 'btn-cancelar' 
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
               
                            const wsDuplicados = XLSX.utils.aoa_to_sheet(registrosDuplicados);
                            const wbDuplicados = XLSX.utils.book_new();
                            XLSX.utils.book_append_sheet(wbDuplicados, wsDuplicados, "Registros Duplicados");
        
                          
                            const excelData = XLSX.write(wbDuplicados, { bookType: 'xlsx', type: 'array' });
        
                            
                            const blob = new Blob([excelData], { type: 'application/octet-stream' });
        
                            
                            const enlace = document.createElement('a');
                            enlace.href = URL.createObjectURL(blob);
                            enlace.download = 'registros_duplicados.xlsx';
                            enlace.click();
                        } 
                    });

                }
            });
        };

        lector.readAsArrayBuffer(archivo);
    }
});
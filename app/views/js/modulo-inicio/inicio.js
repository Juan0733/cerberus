import {conteoTipoUsuario} from '../fetchs/usuarios-fetch.js'
import {conteoTipoVehiculo} from '../fetchs/vehiculos-fetch.js'

let urlBase;

function dibujarConteoUsuarios(){
    
    conteoTipoUsuario(urlBase).then(datos => {
        if(datos.tipo == 'OK'){
            datos.usuarios.forEach(usuario => {
                if(usuario.tipo_usuario == 'aprendices'){
                    document.getElementById('conteo_aprendices').innerHTML = usuario.cantidad+" Aprendices en el CAB";
                    document.getElementById('barra_aprendices').style.width = usuario.porcentaje+"%";
                    document.getElementById('subtitle_barra_aprendices').innerHTML = usuario.porcentaje+"% son Aprendices";
                }else if(usuario.tipo_usuario == 'funcionarios'){
                    document.getElementById('conteo_funcionarios').innerHTML = usuario.cantidad+" Funcionarios en el CAB";
                    document.getElementById('barra_funcionarios').style.width = usuario.porcentaje+"%";
                    document.getElementById('subtitle_barra_funcionarios').innerHTML = usuario.porcentaje+"% son Funcionarios";
                }else if(usuario.tipo_usuario == 'visitantes'){
                    document.getElementById('conteo_visitantes').innerHTML = usuario.cantidad+" Visitantes en el CAB";
                    document.getElementById('barra_visitantes').style.width = usuario.porcentaje+"%";
                    document.getElementById('subtitle_barra_visitantes').innerHTML = usuario.porcentaje+"% son Visitantes";
                }else if(usuario.tipo_usuario == 'vigilantes'){
                    document.getElementById('conteo_vigilantes').innerHTML = usuario.cantidad+" Vigilantes en el CAB";
                    document.getElementById('barra_vigilantes').style.width = usuario.porcentaje+'%';
                    document.getElementById('subtitle_barra_vigilantes').innerHTML = usuario.porcentaje+"% son Vigilantes";
                    
                }
            });
        }
    })
}

function dibujarConteoVehiculos(){
    conteoTipoVehiculo(urlBase).then(datos => {
        if(datos.tipo == 'OK'){
            datos.vehiculos.forEach(vehiculo => {
                if(vehiculo.tipo_vehiculo == 'carros'){
                    document.getElementById('conteo_carros').innerHTML = vehiculo.cantidad+" Carros en el CAB";
                    document.getElementById('barra_carros').style.width = vehiculo.porcentaje+"%";
                    document.getElementById('subtitle_barra_carros').innerHTML = vehiculo.porcentaje+"% son Carros";
                }else if(vehiculo.tipo_vehiculo == 'motos'){
                    document.getElementById('conteo_motos').innerHTML = vehiculo.cantidad+" Motos en el CAB";
                    document.getElementById('barra_motos').style.width = vehiculo.porcentaje+"%";
                    document.getElementById('subtitle_barra_motos').innerHTML = vehiculo.porcentaje+"% son Motos";
                }
            })
        }
    })
}


document.addEventListener('DOMContentLoaded', () => {
    urlBase = document.getElementById('url_base').value;
    dibujarConteoUsuarios();
    dibujarConteoVehiculos();

    setInterval(() => {
        dibujarConteoUsuarios();
        dibujarConteoVehiculos();
    }, 60000);
});


import {conteoTipoUsuario} from '../fetchs/usuarios-fetch.js'
import {conteoTipoVehiculo} from '../fetchs/vehiculos-fetch.js'
import {modalFuncionariosBrigadistas} from '../modales/modal-funcionarios-brigadistas.js'


let urlBase;

function dibujarConteoUsuarios(){
    
    conteoTipoUsuario(urlBase).then(datos => {
        if(datos.tipo == 'OK'){
            datos.usuarios.forEach(usuario => {
                if(usuario.tipo_usuario == 'aprendices'){
                    document.getElementById('conteo_aprendices').innerHTML = usuario.cantidad+" Aprendices en el CAB";
                    document.getElementById('barra_aprendices').style.width = usuario.porcentaje+"%";
                    document.getElementById('subtitle_barra_aprendices').innerHTML = usuario.porcentaje+"% son Aprendices";
                }else if(usuario.tipo_usuario == 'funcionarios_comunes'){
                    document.getElementById('conteo_funcionarios_comunes').innerHTML = usuario.cantidad+" Funcionarios Comúnes en el CAB";
                    document.getElementById('barra_funcionarios_comunes').style.width = usuario.porcentaje+"%";
                    document.getElementById('subtitle_barra_funcionarios_comunes').innerHTML = usuario.porcentaje+"% son Funcionarios Comúnes";
                }else if(usuario.tipo_usuario == 'funcionarios_brigadistas'){
                    document.getElementById('conteo_funcionarios_brigadistas').innerHTML = usuario.cantidad+" Funcionarios Brigadistas en el CAB";
                    document.getElementById('barra_funcionarios_brigadistas').style.width = usuario.porcentaje+"%";
                    document.getElementById('subtitle_barra_funcionarios_brigadistas').innerHTML = usuario.porcentaje+"% son Funcionarios Brigadistas";
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

function eventoCardBrigadistas(){
    document.getElementById('card_brigadistas').addEventListener('click', ()=>{
        modalFuncionariosBrigadistas(urlBase);
    })
}



document.addEventListener('DOMContentLoaded', () => {
    urlBase = document.getElementById('url_base').value;
    eventoCardBrigadistas();
    dibujarConteoUsuarios();
    dibujarConteoVehiculos();

    setInterval(() => {
        dibujarConteoUsuarios();
        dibujarConteoVehiculos();
    }, 60000);
});


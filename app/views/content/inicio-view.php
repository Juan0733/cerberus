<?php 
    date_default_timezone_set('America/Bogota');
    $meses = [
        'January' => 'enero',
        'February' => 'febrero',
        'March' => 'marzo',
        'April' => 'abril',
        'May' => 'mayo',
        'June' => 'junio',
        'July' => 'julio',
        'August' => 'agosto',
        'September' => 'septiembre',
        'October' => 'octubre',
        'November' => 'noviembre',
        'December' => 'diciembre'
    ];
    $fecha = new DateTime();
    $mes = $meses[$fecha->format('F')];
    $fecha = $mes . ' ' . $fecha->format('d').' '.$fecha->format('Y'); 
?>

<input type="hidden" id="url_base" value="<?php echo $urlBaseVariable; ?>">

<div class="contenedor-bienvenida">
    <div class="cont_saludo">
        <h1 id="saludo_home">Hola <?php echo $_SESSION['datos_usuario']['nombres']?>!</h1>
        <p id="bienvenida">Bienvenido a Cerberus</p>
    </div>

    <div id="contenedor-ppal-panel">
        <h3 class="titulo_multi_detalle"></h3>
        <div id="contenedor_cartas_multitudes">
            <div class="caja">

                <!-- Tarjetas dinámicas -->
                <?php
                    $tarjetas = [
                        ['id' => 'aprendices', 'icon' => 'people-outline', 'titulo' => 'Aprendices'],
                        ['id' => 'funcionarios', 'icon' => 'people-outline', 'titulo' => 'Funcionarios'],
                        ['id' => 'visitantes', 'icon' => 'people-outline', 'titulo' => 'Visitantes'],
                        ['id' => 'vigilantes', 'icon' => 'people-outline', 'titulo' => 'Vigilantes'],
                        ['id' => 'carros', 'icon' => 'car-outline', 'titulo' => 'Carros'],
                        ['id' => 'motos', 'icon' => 'bicycle-outline', 'titulo' => 'Motos'],
                    ];

                    foreach ($tarjetas as $t) {
                        echo "
                        <div class='card activada'>
                            <p class='fecha-card'>{$fecha}</p>
                            <div class='titulo-card'>
                                <ion-icon name='{$t['icon']}'></ion-icon>
                                <h3>{$t['titulo']}</h3>
                            </div>
                            <h4 class='cantidad-titulo'>Cantidad</h4>
                            <h5 class='cantidad' id='conteo_{$t['id']}'></h5>
                            <div class='cantidad-barra'>
                                <div class='barra' id='barra_{$t['id']}'></div>
                            </div>
                            <p class='subtitle' id='subtitle_barra_{$t['id']}'></p>
                        </div>";
                    }
                ?>
            </div>
        </div>
    </div>
</div>

<script type="module">
import {conteoTipoUsuario} from '../fetchs/usuarios-fetch.js';
import {conteoTipoVehiculo} from '../fetchs/vehiculos-fetch.js';

let urlBase;

function dibujarConteoUsuarios(){
    conteoTipoUsuario(urlBase).then(datos => {
        if(datos.tipo == 'OK'){
            datos.usuarios.forEach(usuario => {
                const tipo = usuario.tipo_usuario;
                document.getElementById(`conteo_${tipo}`).innerHTML = usuario.cantidad + " en el CAB";
                document.getElementById(`barra_${tipo}`).style.width = usuario.porcentaje + "%";
                document.getElementById(`subtitle_barra_${tipo}`).innerHTML = usuario.porcentaje + "% son " + tipo.charAt(0).toUpperCase() + tipo.slice(1);
            });
        }
    });
}

function dibujarConteoVehiculos(){
    conteoTipoVehiculo(urlBase).then(datos => {
        if(datos.tipo == 'OK'){
            datos.vehiculos.forEach(vehiculo => {
                const tipo = vehiculo.tipo_vehiculo;
                document.getElementById(`conteo_${tipo}`).innerHTML = vehiculo.cantidad + " en el CAB";
                document.getElementById(`barra_${tipo}`).style.width = vehiculo.porcentaje + "%";
                document.getElementById(`subtitle_barra_${tipo}`).innerHTML = vehiculo.porcentaje + "% son " + tipo.charAt(0).toUpperCase() + tipo.slice(1);
            });
        }
    });
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
</script>

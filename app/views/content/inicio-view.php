<?php 
    $fecha = new DateTime();
    $mes = MESES[$fecha->format('F')];
    $fecha = $mes . ' ' . $fecha->format('d').' '.$fecha->format('Y');  
    $primerNombreUsuario = explode(' ', $_SESSION['datos_usuario']['nombres'])[0];
?>

<input type="hidden" id="url_base" value="<?php echo $urlBaseVariable; ?>">

<?php if(($_SESSION['datos_usuario']['rol'] == 'JEFE VIGILANTES' || $_SESSION['datos_usuario']['rol'] == 'VIGILANTE RASO') && !isset($_SESSION['datos_usuario']['puerta'])): ?>
    <input type="hidden" id="puerta" >
<?php endif; ?>

<div id="contenedor_principal">
    <div id="contenedor_saludo">
        <h1>Hola <?php echo $primerNombreUsuario; ?>!</h1>
        <p id="bienvenida">Bienvenido a Cerberus</p>
    </div>

    <p id="contador_multitud_mobile"></p>

    <div id="contenedor_cartas_multitudes">
        <div id="contenedor_cards">

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
                    <div class='card-multitud'>
                        <p>{$fecha}</p>
                        <div class='contenedor-titulo'>
                            <ion-icon name='{$t['icon']}'></ion-icon>
                            <h2>{$t['titulo']}</h2>
                        </div>
                        <h4>Cantidad</h4>
                        <h3 id='conteo_{$t['id']}'></h3>
                        <div class='contenedor-barra'>
                            <div class='barra' id='barra_{$t['id']}'></div>
                        </div>
                        <p class='subtitle' id='subtitle_barra_{$t['id']}'></p>
                    </div>";
                }
            ?>
        </div>
    </div>
</div>



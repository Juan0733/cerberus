<?php 
    $fecha = new DateTime();
    $mes = MESES[$fecha->format('F')];
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

<?php
    $titulo = str_replace("-", " ", $url[0]);
    $titulo = ucwords(strtolower($titulo));
    if($titulo == 'Informes Grafica'){
        $titulo = 'Informes Gráfica';

    }elseif($titulo == 'Novedades Vehiculo'){
        $titulo = 'Novedades Vehículo';
    }
    
    $primerNombre = explode(" ", $_SESSION['datos_usuario']['nombres'])[0];
    $primerApellido = explode(" ", $_SESSION['datos_usuario']['apellidos'])[0];
    $nombreUsuario = $primerNombre.' '.$primerApellido;
?>

<div id="nav_menu">
    <div id="cont_nombre_vista">
        <h1>
            <?php echo $titulo; ?>
        </h1>
    </div>
    <div id="cont_info_usuario">
        <div id="cont_contador_multitud">
            <ion-icon name="people-outline"></ion-icon>
            <p id="contador_multitud"></p>
        </div>
        <div id="cont_perfil_user">
            <ion-icon name="person-outline"></ion-icon>
            <p><?php echo $nombreUsuario; ?></p>
        </div>
        <button id="btn_brigadistas">
            <ion-icon name="medkit"></ion-icon>
            <p id="contador_brigadistas"></p>
        </button>
        <?php if($_SESSION['datos_usuario']['rol'] == 'JEFE VIGILANTES' || $_SESSION['datos_usuario']['rol'] == 'VIGILANTE RASO'): ?>
            <div id="btn_puerta">
                <i class='bx  bxs-door'  style='color:#4b3a3a'></i>   
            </div>
        <?php endif; ?>
        <?php if($_SESSION['datos_usuario']['rol'] == 'JEFE VIGILANTES' || $_SESSION['datos_usuario']['rol'] == 'SUBDIRECTOR'): ?>
            <div id="btn_notificaciones">
                <ion-icon name="notifications-outline" ></ion-icon>
                <span id="contador_notificaciones">0</span> 
            </div>
        <?php endif; ?>
        
    </div>
</div>


<?php
    $titulo = str_replace("-", " ", $url[0]);
    $titulo = ucwords(strtolower($titulo));
    if($titulo == 'Informes Grafica'){
        $titulo = 'Informes Gráfica';

    }elseif($titulo == 'Novedades Vehiculo'){
        $titulo = 'Novedades Vehículo';

    }elseif($titulo == 'Permisos Vehiculo'){
        $titulo = 'Permisos Vehículo';

    }elseif($titulo == 'Vehiculos'){
        $titulo = 'Vehículos';
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
        <div id="linea"></div>
    </div>
    <div id="cont_info_usuario">
        <div id="cont_perfil_user">
            <ion-icon name="person"></ion-icon>
            <p><?php echo $nombreUsuario; ?></p>
        </div>
        <div id="cont_contador_multitud">
            <ion-icon name="people"></ion-icon>
            <p>Multitud: <span id="contador_multitud">0</span></p>
        </div>
        <button type="button" id="btn_brigadistas">
            <ion-icon name="medkit"></ion-icon>
            <p>Brigadistas: <span id="contador_brigadistas">0</span></p>
        </button>
        <?php if($_SESSION['datos_usuario']['rol'] == 'SUPERVISOR' || $_SESSION['datos_usuario']['rol'] == 'VIGILANTE'): ?>
            <button type="button" id="btn_puerta">
                <svg  xmlns="http://www.w3.org/2000/svg" width="24" height="24"  
                fill="#b64810" viewBox="0 0 24 24" >
                <!--Boxicons v3.0 https://boxicons.com | License  https://docs.boxicons.com/free-->
                <path d="M2 20H22V22H2z"></path><path d="m20,4c0-1.1-.9-2-2-2H6c-1.1,0-2,.9-2,2v15h16V4Zm-3,8h-2v-2h2v2Z"></path>
                </svg>
            </button>
        <?php endif; ?>
        <?php if($_SESSION['datos_usuario']['rol'] == 'SUPERVISOR' || $_SESSION['datos_usuario']['rol'] == 'SUBDIRECTOR'): ?>
            <button type="button" id="btn_notificaciones">
                <ion-icon name="notifications" ></ion-icon>
                <span id="contador_notificaciones">0</span> 
            </button>
        <?php endif; ?>
        
    </div>
</div>


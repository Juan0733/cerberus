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
                <svg  xmlns="http://www.w3.org/2000/svg" width="24" height="24"  
                fill="#4b3a3a" viewBox="0 0 24 24" >
                <!--Boxicons v3.0 https://boxicons.com | License  https://docs.boxicons.com/free-->
                <path d="M2 20H22V22H2z"></path><path d="m20,4c0-1.1-.9-2-2-2H6c-1.1,0-2,.9-2,2v15h16V4Zm-3,8h-2v-2h2v2Z"></path>
                </svg>  
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


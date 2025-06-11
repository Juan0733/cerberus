<div id="nav_menu">
    <div id="cont_nombre_vista">
        <h1>
            <?php
                $titulo = str_replace("-", " ", $url[0]);
                $titulo = ucwords(strtolower($titulo));
                if($titulo == 'Informes Grafica'){
                    $titulo = 'Informes Gráfica';
                }
                echo $titulo;
            ?>
        </h1>
    </div>
    <div id="cont_info_usuario">
        <div id="cont_contador_multitud">
            <ion-icon name="people-outline"></ion-icon>
            <p id="contador_multitud"></p>
        </div>
        <div id="cont_perfil_user">
            <ion-icon name="person-outline"></ion-icon>
            <p><?php echo $_SESSION['datos_usuario']['nombres'].' '.$_SESSION['datos_usuario']['apellidos']; ?></p>
        </div>
        <button id="btn_brigadistas">
            <ion-icon name="medkit"></ion-icon>
            <p id="contador_brigadistas"></p>
        </button>
        <div id="cont_icon_notificaciones">
            <ion-icon name="notifications-outline" ></ion-icon>
            <span id="notification_count">5</span> 
        </div>
    </div>
</div>


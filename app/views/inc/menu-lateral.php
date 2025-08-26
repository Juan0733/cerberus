<?php
    $urlActual = $url[0];
    $titulo = explode("-", $url[0])[0];
    $titulo = ucwords(strtolower($titulo));

    if($titulo == 'Vehiculos'){
        $titulo = 'Vehículos';
    }
?>

<div class="menu">
    <div class="cont-menu-icon">
        <ion-icon name="grid-outline" class="icon-menu"></ion-icon>
        <ion-icon name="close-outline" class="icon-close-menu"></ion-icon>
    </div>
    
    <div id="cont_nombre_vista_menu">
        <h1><?php echo $titulo; ?></h1>
    </div>

    <div id="cont_info_usuario-mobil">
        <div id="btn_brigadistas_mobile">
            <ion-icon name="medkit"></ion-icon>
        </div>

        <?php if($_SESSION['datos_usuario']['rol'] == 'SUPERVISOR' || $_SESSION['datos_usuario']['rol'] == 'VIGILANTE'): ?>
            <div id="btn_puerta_mobile">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"  
                fill="#ffffff" viewBox="0 0 24 24" >
                <path d="M2 20H22V22H2z"></path><path d="m20,4c0-1.1-.9-2-2-2H6c-1.1,0-2,.9-2,2v15h16V4Zm-3,8h-2v-2h2v2Z"></path>
                </svg>   
            </div>
        <?php endif; ?>

        <?php if($_SESSION['datos_usuario']['rol'] == 'SUPERVISOR' || $_SESSION['datos_usuario']['rol'] == 'SUBDIRECTOR'): ?>
            <div id="btn_notificaciones_mobile">
                <ion-icon name="notifications" ></ion-icon>
                <span id="contador_notificaciones_mobile">0</span> 
            </div>
        <?php endif; ?>
    </div>
</div>

    <div class="barra-lateral mini-barra-lateral">
        <div>
            <div class="nombre-pagina">
                <article id="logo_sena">
                    <figure id="marca">
                        <img src="<?php echo $urlBaseVariable; ?>app/views/img/logo-sena-verde-png-sin-fondo.webp" alt="">
                    </figure>
                </article>
            </div>
        </div>

        <nav class="navegacion">
            <ul>
                <?php foreach($opcionesMenu as $clave => $opcion): ?>
                    <li class=" <?php echo $opcion['CLASE']; ?>">
                        <a href="<?php echo $opcion['URL'] == '#' ? $opcion['URL'] : $urlBaseVariable.$opcion['URL']; ?>" class="<?php echo $opcion['CLASE02']; ?>
                            <?php if ($clave == 'USUARIOS' || $clave == 'INFORMES' || $clave == 'NOVEDADES' || $clave == 'PERMISOS'): ?>
                                <?php foreach ($opcion['SUBMENU'] as $subClave => $subOpcion): ?>
                                    <?php if ($subOpcion['URL'] == $urlActual): ?>
                                        <?php echo 'inbox'; ?>
                                        <?php break; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php elseif ($opcion['URL'] == $urlActual): ?>
                                <?php echo 'inbox'?>
                            <?php endif; ?>">

                            <ion-icon name="<?php echo $opcion['ICON']; ?>"></ion-icon>
                            <span><?php echo $opcion['TITULO']; ?></span>
                        </a>

                        <?php if ($clave == 'USUARIOS' || $clave == 'INFORMES' || $clave == 'NOVEDADES' || $clave == 'PERMISOS'): ?>
                            <ul class="<?php echo $opcion['CLASE03']; ?>">
                                <?php foreach ($opcion['SUBMENU'] as $subClave => $subOpcion): ?>
                                    <li>
                                        <a href="<?php echo $urlBaseVariable.$subOpcion['URL'];?>">
                                            <ion-icon name="<?php echo $subOpcion['ICON']; ?>"></ion-icon>
                                            <span class="links_nombre"><?php echo $subOpcion['TITULO']; ?></span>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>

        <div id="contenedor_sesion_autor">
            <div id="contenedor_cerrar_sesion">
                <ion-icon id="cerrar_sesion" name="exit-outline"></ion-icon>           
            </div>
            <div class="linea"></div>
            <div id="contenedor_autor">
                <ion-icon id="btn_autor" name="code-slash-outline"></ion-icon>
                <div id="informacion_autor">
                    <h2>CERBERUS</h2>
                    <h3>Análisis y Desarrollo de Software 2714805</h3>
                    <p>Laura Daniela Canizales</p>
                    <p>Juan David Tilmans</p>
                </div>
            </div>
        </div>

    </div> 

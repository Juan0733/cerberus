<?php
    $urlActual = $url[0];
    $titulo = explode("-", $url[0])[0];
    $titulo = ucwords(strtolower($titulo));
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

        <?php if($_SESSION['datos_usuario']['rol'] == 'JEFE VIGILANTES' || $_SESSION['datos_usuario']['rol'] == 'VIGILANTE RASO'): ?>
            <div id="btn_puerta_mobile">
                <i class='bx  bxs-door'></i>   
            </div>
        <?php endif; ?>

        <?php if($_SESSION['datos_usuario']['rol'] == 'JEFE VIGILANTES' || $_SESSION['datos_usuario']['rol'] == 'SUBDIRECTOR'): ?>
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
                            <?php if ($clave == 'USUARIOS' || $clave == 'INFORMES' || $clave == 'NOVEDADES'): ?>
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

                        <?php if ($clave == 'USUARIOS' || $clave == 'INFORMES' || $clave == 'NOVEDADES'): ?>
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

        <div>
            <div class="linea"></div>
            <div class="usuario">
                <a id="cerrar_sesion">
                    <ion-icon name="exit-outline"></ion-icon>               
                </a>
            </div>
        </div>

    </div> 

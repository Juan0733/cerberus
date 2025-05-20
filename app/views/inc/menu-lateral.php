
<div class="menu">
        <div class="cont-menu-icon">

            <ion-icon name="grid-outline" class="icon-menu"></ion-icon>
            <ion-icon name="close-outline" class="icon-close-menu"></ion-icon>
        </div>
        
        <div id="cont_nombre_vista_menu">
            <h1>
                <?php
                        $titulo = str_replace("-", " ", $url[0]);
                        $titulo = ucwords(strtolower($titulo));
                        $palabras = explode(" ", $titulo);
                        $titulo = implode(" ", array_slice($palabras, 0, 2));
                        echo $titulo;
                ?>
            </h1>
        </div>
        <div id="cont_info_usuario-mobil">
            
            <div id="cont_icon_notificaciones-mobil">
                    <ion-icon name="notifications-outline" ></ion-icon>
                    <span id="notification_count">5</span> 
            </div>
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
            <?php 
                $titulo = str_replace("-", " ", $url[0]);
                $titulo = ucwords(strtolower($titulo));
            ?>
            <ul>
                <?php foreach ($opcMenu as $clave => $opcion) { ?>
                    <li class="<?php echo $opcion['CLASE']; ?>">
                       
                        <a href="<?php echo $clave != "SUBMENU" ? $urlBaseVariable.$opcion['URL'] : "#"; ?>" class="<?php echo $opcion['CLASE02']; ?> <?php 
                            if ($clave == 'SUBMENU' && isset($opcion['OPC'])) {
                                foreach ($opcion['OPC'] as $subClave => $opcSub) {
                                    echo ($titulo ==  $opcSub['titulo'] ) ? 'inbox' : ''; 
                                   
                                }
                                if (count($url) > 2 ) {
                                    echo  'inbox';
                                }

                            }else {
                                if ($opcion['TITULO'] == 'Usuarios' ) {
                                    echo "";
                                }else {
                                    echo ($titulo == $opcion['TITULO']) ? 'inbox' : ''; 
                                }
                            }
                            
                            
                        ?>">
                            <ion-icon name="<?php echo $opcion['ICON']; ?>"></ion-icon>
                            <span><?php echo $opcion['TITULO']; ?></span>
                        </a>

                        <?php if ($clave == 'SUBMENU' && isset($opcion['OPC'])) { ?>
                            <ul class="<?php echo $opcion['CLASE03']; ?>">
                                <?php foreach ($opcion['OPC'] as $subClave => $opcSub) { ?>
                                    <li>
                                        <a href="<?php echo $urlBaseVariable.$opcSub['url'];?>">
                                            <ion-icon name="<?php echo $opcSub['icon']; ?>"></ion-icon>
                                            <span class="links_nombre"><?php echo $opcSub['titulo']; ?></span>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </li>
                <?php } ?>
            </ul>
        </nav>

        <div>
            <div class="linea"></div>
            <div class="usuario">
                <ion-icon name="exit-outline" onclick="cerrarSesion('<?php echo $urlBaseVariable;?>')"></ion-icon>
            </div>
        </div>

    </div> 

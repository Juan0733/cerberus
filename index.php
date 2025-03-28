<?php

    require_once "./config/app.php";
    require_once "./autoload.php";


    /*---------- Iniciando sesion ----------*/
    require_once "./app/views/inc/session_start.php";

    if(isset($_GET['views'])){
        $url=explode("/", $_GET['views']);
    }else{
        $url=["login"];
    }
    $URL_CONST=$url;

    

    use app\controllers\loginController;
    use app\controllers\viewsController;
    $viewsController= new viewsController();
    if (count($url) > 2) {
        $APP_URL_BASE_VARIABLE = "../../";
    }
    
    $insLogin = new loginController();
    $vista=$viewsController->obtenerVistasControlador($url[0]);?>

<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once "app/views/inc/head.php"; ?>
</head>
<body>
    <?php
        if ($vista == 'app/views/content/registro-visitante-view.php' /* NUEVO APRENDIZ TAMBIEN */) {
            include $vista;
        }else {
            if($vista=="login" || $vista=="404"){
                
                if(isset($_SESSION['datos_usuario']['num_identificacion'])){
                    if (!isset($_POST['psw_usuario'])) {
                        $insLogin->cerrarSesionControlador($vista);
                    }
                }
                include "app/views/content/".$vista."-view.php";
            }else{
        ?>
        <main class="cuerpo-contenedor" id="cuerpo">
        <?php
                # Cerrar sesion #
                if((!isset($_SESSION['datos_usuario']['num_identificacion']) || $_SESSION['datos_usuario']['num_identificacion']=="") ){
                    $insLogin->cerrarSesionControlador('login');
                    exit();
                }
                $opcMenu =  $viewsController->obtenerMenuUsuario($_SESSION['datos_usuario']['rol_usuario']);
                include "./app/views/inc/menu-lateral.php";
        ?>      
            <section class="full-width pageContent scroll" id="contenedor_pagina">
                
                <?php
                    
                    include "app/views/inc/nav-menu.php";
                    include $vista;
                ?>
            </section>
        </main>
        <?php
            }

        }
        include "./app/views/inc/modales/modales.php";
        include "./app/views/inc/scripts.php";
    ?>


</body>
</html>
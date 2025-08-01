<?php
require_once "./config/app.php";
require_once "./vendor/autoload.php";

use App\Models\ViewModel;

if(isset($_GET['views'])){
    $url=explode("/", $_GET['views']);

    if($url[0] == 'index'){
        $url[0] = 'login';
    }

}else{
    $url=["login"];
}

if($url[0] == 'login' && isset($_SESSION['datos_usuario'])){
    header('Location: '.$urlBaseVariable.$_SESSION['datos_usuario']['panel_acceso']);
    exit();
}

if (count($url) == 1){
    $urlBaseVariable = '';
}elseif(count($url) == 2){
    $urlBaseVariable = '../';
}elseif(count($url) > 2){
    $urlBaseVariable = '../../';
}


$objetoView= new ViewModel();

$vista = $objetoView->obtenerVista($url[0]);

if($vista == "app/views/content/404-view.php"){
   $url[0] = "404";
}elseif($vista == "app/views/content/acceso-denegado-view.php"){
    $url[0] = 'acceso-denegado';
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "app/views/inc/head.php"; ?>
</head>
<body>
    <?php if($url[0] == 'auto-registro-aprendices' || $url[0] == 'auto-registro-vigilantes' || $url[0] == 'auto-registro-visitantes' || $url[0] == 'auto-registro-funcionarios' || $url[0] == '404' || $url[0] == 'login' || $url[0] == 'acceso-denegado' || $url[0] == 'sesion-expirada'): ?>

        <?php include $vista; ?>

    <?php else: ?>
       
        <main class="cuerpo-contenedor" id="cuerpo">
            <?php
                $opcionesMenu =  $objetoView->obtenerMenuOpciones();
                include "app/views/inc/menu-lateral.php";
            ?>      
            <section class="full-width pageContent scroll" id="contenedor_pagina">
                
                <?php
                    
                    include "app/views/inc/nav-menu.php";
                    include $vista;
                ?>
            </section>
        </main>
        
        <?php 
            if($_SESSION['datos_usuario']['rol'] == 'SUBDIRECTOR' || $_SESSION['datos_usuario']['rol'] == 'JEFE VIGILANTES'){
                include "app/views/inc/modales/modal-notificaciones.php";
            }
        ?>
            
        <div id="contenedor_modales">
        </div>
    <?php endif; ?>

        <div id="contenedor_spinner">
            <div id="caja_spinner">
                <img src="<?php echo $urlBaseVariable; ?>app/views/img/logo_c_blanco.png" alt="Cargando...">
                <div id="spinner"></div>
            </div>
        </div>
    <?php
        include "./app/views/inc/scripts.php";
    ?>

</body>
</html>
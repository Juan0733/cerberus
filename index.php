<?php

use app\models\UsuarioModel;
use app\models\ViewModel;
require_once "./config/app.php";
require_once "./autoload.php";

/*---------- Iniciando sesion ----------*/
require_once "./app/views/inc/session_start.php";

if(isset($_GET['views'])){
    $url=explode("/", $_GET['views']);
}else{
    $url=["login"];
}


if (count($url) == 1){
    $urlBaseVariable = '';
}elseif(count($url) == 2){
    $urlBaseVariable = '../';
}elseif(count($url) > 2){
    $urlBaseVariable = '../../';
}


$insView= new ViewModel();
$insLogin = new UsuarioModel();

$vista = $insView->obtenerVista($url[0]);

if($vista == "app/views/content/404-view.php"){
   $url[0] = "404";
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once "app/views/inc/head.php"; ?>
</head>
<body>
    <?php if($url[0] == 'registro-visitante' || $url[0] == '404' || $url[0] == 'login'): ?>

        <?php include $vista; ?>

    <?php else: ?>
       
        <main class="cuerpo-contenedor" id="cuerpo">
            <?php
                $opcMenu =  $insView->obtenerMenuOpciones();
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
            include "./app/views/inc/modales/modales.php";
        ?>
    <?php endif; ?>
    <?php
        include "./app/views/inc/scripts.php";
    ?>

</body>
</html>
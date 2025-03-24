
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php
if ($url[0] != 'login' && $url[0] != 'registro-visitante') {

   /*  if ($url[1] != "") {
        ?>
            <link rel="stylesheet" href="../../app/views/css/all.css">

            <link rel="stylesheet" href="../../app/views/css/menu-lateral-estilo.css">

            <link rel="stylesheet" href="../../app/views/css/all_formularios.css">
            <link rel="stylesheet" href="../../app/views/css/estilos-modales.css"> 
        <?php
    }else{
 */
        ?>    
        <link rel="stylesheet" href="<?php echo $APP_URL_BASE_VARIABLE; ?>app/views/css/all.css">

        <link rel="stylesheet" href="<?php echo $APP_URL_BASE_VARIABLE; ?>app/views/css/menu-lateral-estilo.css">

        <link rel="stylesheet" href="<?php echo $APP_URL_BASE_VARIABLE; ?>app/views/css/all_formularios.css">
        <link rel="stylesheet" href="<?php echo $APP_URL_BASE_VARIABLE; ?>app/views/css/estilos-modales.css"> 
        <?php
   /*  } */
    ?>


<?php }else {
    ?>
        <link rel="stylesheet" href="<?php echo APP_URL_BASE_LOGIN; ?>app/views/css/login-estilo.css">

        <link rel="stylesheet" href="app/views/css/all.css">
        <link rel="stylesheet" href="<?php echo APP_URL_BASE_LOGIN; ?>app/views/css/registro-visitante.css">

    <?php
}

if ($url[0] == 'panel-principal-jv') { ?>

    <link rel="stylesheet" href="<?php echo $APP_URL_BASE_VARIABLE; ?>app/views/css/panel-principal.css">

<?php }elseif ($url[0] == 'listado-visitantes') {?>


<?php }elseif ($url[0] == 'listado-funcionario') {?>

    <link rel="stylesheet" href="<?php echo $APP_URL_BASE_VARIABLE; ?>app/views/css/listado-funcionario.css">

<?php }elseif ($url[0] == 'registro-funcionario') {?>

    <link rel="stylesheet" href="<?php echo $APP_URL_BASE_VARIABLE; ?>app/views/css/registro-funcionario.css">

<?php }elseif ($url[0] == 'editar-funcionario') {?>

    <link rel="stylesheet" href="../<?php echo $APP_URL_BASE_VARIABLE; ?>app/views/css/editar-funcionario.css">

<?php }elseif ($url[0] == 'lista-vigilantes') {?>

    <link rel="stylesheet" href="<?php echo $APP_URL_BASE_VARIABLE; ?>app/views/css/lista-vigilantes.css"> 

<?php }elseif ($url[0] == 'informes') {?>

    <link rel="stylesheet" href="<?php echo $APP_URL_BASE_VARIABLE; ?>app/views/css/panel-principal.css">

    <link rel="stylesheet" href="<?php echo $APP_URL_BASE_VARIABLE; ?>app/views/css/informes.css">
    
<?php }elseif (strpos($url[0], 'agenda') !== false) {?>

    <link rel="stylesheet" href="<?php echo $APP_URL_BASE_VARIABLE; ?>app/views/css/agendas.css"> 

<?php }elseif ($url[0] == 'editar-visitante') {?>

<link rel="stylesheet" href="<?php echo $APP_URL_BASE_VARIABLE; ?>app/views/css/agendas.css"> 

<?php }

?>




<link rel="icon" type="image/x-icon" href="<?php echo $APP_URL_BASE_VARIABLE; ?>app/views/img/logo_dalle_cerberus.png">
<link rel="stylesheet" href="<?php echo $APP_URL_BASE_VARIABLE; ?>app/views/css/all_editar.css">





<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>




<title> SENA CAB | <?php echo APP_NOMBRE;?></title>
<script src="<?php echo $APP_URL_BASE_VARIABLE; ?>app/views/js/sweetalert2.all.min.js" ></script>
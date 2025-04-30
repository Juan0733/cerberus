<link rel="stylesheet" href="<?php echo  $urlBaseVariable; ?>app/views/css/all.css">
<?php if($url[0] != 'login' && $url[0] != '404'): ?>
    <link rel="stylesheet" href="<?php echo  $urlBaseVariable; ?>app/views/css/menu-lateral-estilo.css">
    <link rel="stylesheet" href="<?php echo  $urlBaseVariable; ?>app/views/css/all-formularios.css">
    <link rel="stylesheet" href="<?php echo  $urlBaseVariable; ?>app/views/css/estilos-modales.css"> 
<?php endif; ?>
    
<?php if($url[0] == 'login'): ?>
    <link rel="stylesheet" href="<?php echo  $urlBaseVariable; ?>app/views/css/login-estilo.css">
<?php elseif($url[0] == '404'): ?>
    <link rel="stylesheet" href="<?php echo  $urlBaseVariable; ?>app/views/css/404-estilo.css">
<?php elseif($url[0] == 'inicio'): ?>
    <link rel="stylesheet" href="<?php echo  $urlBaseVariable; ?>app/views/css/inicio.css">
<?php endif; ?>

<link rel="icon" type="image/x-icon" href="<?php echo  $urlBaseVariable; ?>app/views/img/logo_dalle_cerberus.png">
<title> SENA CAB | <?php echo APP_NOMBRE;?></title>

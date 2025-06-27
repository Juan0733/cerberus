<link rel="stylesheet" href="<?php echo  $urlBaseVariable; ?>app/views/css/all-estilo.css">
    
<?php if($url[0] != 'login' && $url[0] != '404' && $url[0] != 'sesion-expirada' && $url[0] != 'acceso-denegado' && $url[0] != 'auto-registro-visitantes'): ?>
    <link rel="stylesheet" href="<?php echo  $urlBaseVariable; ?>app/views/css/menu-lateral-estilo.css">
<?php endif; ?>

<?php if($url[0] == 'login'): ?>
    <link rel="stylesheet" href="<?php echo  $urlBaseVariable; ?>app/views/css/login-estilo.css">

<?php elseif($url[0] == '404'): ?>
    <link rel="stylesheet" href="<?php echo  $urlBaseVariable; ?>app/views/css/404-estilo.css">

<?php elseif($url[0] == 'auto-registro-visitantes'): ?>
    <link rel="stylesheet" href="<?php echo  $urlBaseVariable; ?>app/views/css/auto-registro-visitantes-estilo.css">

<?php elseif($url[0] == 'inicio'): ?>
    <link rel="stylesheet" href="<?php echo  $urlBaseVariable; ?>app/views/css/inicio-estilo.css">

<?php elseif($url[0] == 'entradas'): ?>
    <link rel="stylesheet" href="<?php echo  $urlBaseVariable; ?>app/views/css/entradas-estilo.css">

<?php elseif($url[0] == 'salidas'): ?>
    <link rel="stylesheet" href="<?php echo  $urlBaseVariable; ?>app/views/css/salidas-estilo.css">

<?php elseif($url[0] == 'aprendices'): ?>
    <link rel="stylesheet" href="<?php echo  $urlBaseVariable; ?>app/views/css/aprendices-estilo.css">

<?php elseif($url[0] == 'visitantes'): ?>
    <link rel="stylesheet" href="<?php echo  $urlBaseVariable; ?>app/views/css/visitantes-estilo.css">

<?php elseif($url[0] == 'vigilantes'): ?>
    <link rel="stylesheet" href="<?php echo  $urlBaseVariable; ?>app/views/css/vigilantes-estilo.css">

<?php elseif($url[0] == 'funcionarios'): ?>
    <link rel="stylesheet" href="<?php echo  $urlBaseVariable; ?>app/views/css/funcionarios-estilo.css">

<?php elseif($url[0] == 'vehiculos'): ?>
    <link rel="stylesheet" href="<?php echo  $urlBaseVariable; ?>app/views/css/vehiculos-estilo.css">

<?php elseif($url[0] == 'informes-listado'): ?>
    <link rel="stylesheet" href="<?php echo  $urlBaseVariable; ?>app/views/css/informes-listado-estilo.css">

<?php elseif($url[0] == 'informes-grafica'): ?>
    <link rel="stylesheet" href="<?php echo  $urlBaseVariable; ?>app/views/css/informes-grafica-estilo.css">

<?php elseif($url[0] == 'agendas'): ?>
    <link rel="stylesheet" href="<?php echo  $urlBaseVariable; ?>app/views/css/agendas-estilo.css">

<?php elseif($url[0] == 'novedades-usuario'): ?>
    <link rel="stylesheet" href="<?php echo  $urlBaseVariable; ?>app/views/css/novedades-usuario-estilo.css">

<?php elseif($url[0] == 'novedades-vehiculo'): ?>
    <link rel="stylesheet" href="<?php echo  $urlBaseVariable; ?>app/views/css/novedades-vehiculo-estilo.css">
<?php endif; ?>

<link rel="icon" type="image/x-icon" href="<?php echo  $urlBaseVariable; ?>app/views/img/logo_dalle_cerberus.png">
<!-- <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
<link href='https://cdn.boxicons.com/fonts/brands/boxicons-brands.min.css' rel='stylesheet'> -->
<title> SENA CAB | <?php echo APP_NOMBRE;?></title>

<?php if($url[0] != 'login'&& $url[0] != '404' && $url[0] != 'acceso-denegado' && $url[0] != 'sesion-expirada' && $url[0] != 'auto-registro-visitantes'): ?>
    <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/general/menu-lateral.js"></script>
    <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/general/conteos.js"></script>
<?php endif; ?>

<?php if($url[0] == 'login'): ?>
    <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-login/login.js"></script>

<?php elseif($url[0] == 'inicio'): ?>
    <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-inicio/inicio.js"></script>

<?php elseif($url[0] == 'entradas'): ?>
    <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-entradas/entrada-peatonal.js"></script>
    <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-entradas/entrada-vehicular.js"></script>

<?php elseif($url[0] == 'salidas'): ?>
    <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-salidas/salida-peatonal.js"></script>
    <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-salidas/salida-vehicular.js"></script>

<?php elseif($url[0] == 'visitantes'): ?>
    <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-usuarios/visitantes.js"></script>

<?php elseif($url[0] == 'informes-listado'): ?>
    <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-informes/informes-listado.js"></script>

<?php elseif($url[0] == 'informes-grafica'): ?>
    <script src="<?php echo $urlBaseVariable; ?>app/views/js/librerias/chart.umd.js"></script>
    <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-informes/informes-grafica.js"></script>

<?php elseif($url[0] == 'novedades-usuario'): ?>
    <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-novedades/novedades-usuario.js"></script>

<?php elseif($url[0] == 'novedades-vehiculo'): ?>
    <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-novedades/novedades-vehiculo.js"></script>

<?php elseif($url[0] == 'aprendices'): ?>
    <?php if($_SESSION['datos_usuario']['rol'] == 'SUBDIRECTOR' || $_SESSION['datos_usuario']['rol'] == 'COORDINADOR'): ?>
        <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-usuarios/aprendices-subdirector-coordinador.js"></script>

    <?php elseif($_SESSION['datos_usuario']['rol'] == 'JEFE VIGILANTES' || $_SESSION['datos_usuario']['rol'] == 'VIGILANTE RASO'): ?>
        <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-usuarios/aprendices-jefe-raso.js"></script>
    <?php endif; ?>

<?php elseif($url[0] == 'vigilantes'): ?>
    <?php if($_SESSION['datos_usuario']['rol'] == 'SUBDIRECTOR'): ?>
        <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-usuarios/vigilantes-subdirector.js"></script>

    <?php elseif($_SESSION['datos_usuario']['rol'] == 'JEFE VIGILANTES'): ?>
        <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-usuarios/vigilantes-jefe.js"></script>

    <?php elseif($_SESSION['datos_usuario']['rol'] == 'COORDINADOR' || $_SESSION['datos_usuario']['rol'] == 'VIGILANTE RASO'): ?>
        <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-usuarios/vigilantes-coordinador-raso.js"></script>
    <?php endif; ?>

<?php elseif($url[0] == 'funcionarios'): ?>
    <?php if($_SESSION['datos_usuario']['rol'] == 'SUBDIRECTOR'): ?>
        <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-usuarios/funcionarios-subdirector.js"></script>

    <?php elseif($_SESSION['datos_usuario']['rol'] == 'JEFE VIGILANTES' || $_SESSION['datos_usuario']['rol'] == 'COORDINADOR' || $_SESSION['datos_usuario']['rol'] == 'VIGILANTE RASO'): ?>
        <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-usuarios/funcionarios-coordinador-jefe-raso.js"></script>
    <?php endif; ?>

<?php elseif($url[0] == 'agendas'): ?>
    <?php if($_SESSION['datos_usuario']['rol'] == 'SUBDIRECTOR' || $_SESSION['datos_usuario']['rol'] == 'COORDINADOR'): ?>
        <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-agendas/agendas-subdirector-coordinador.js"></script>

    <?php elseif($_SESSION['datos_usuario']['rol'] == 'JEFE VIGILANTES' || $_SESSION['datos_usuario']['rol'] == 'VIGILANTE RASO'): ?>
        <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-agendas/agendas-jefe-raso.js"></script>
    <?php endif; ?>

<?php elseif($url[0] == 'vehiculos'): ?>
    <?php if($_SESSION['datos_usuario']['rol'] == 'SUBDIRECTOR' || $_SESSION['datos_usuario']['rol'] == 'JEFE VIGILANTES'): ?>
        <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-vehiculos/vehiculos-subdirector-jefe.js"></script>

    <?php elseif($_SESSION['datos_usuario']['rol'] == 'VIGILANTE RASO'): ?>
        <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-vehiculos/vehiculos-raso.js"></script>
    <?php endif; ?>
<?php endif; ?>

<script src="<?php echo $urlBaseVariable; ?>app/views/js/librerias/sweetalert2.all.min.js" ></script>
<script type="module" src="https://cdn.jsdelivr.net/npm/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://cdn.jsdelivr.net/npm/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
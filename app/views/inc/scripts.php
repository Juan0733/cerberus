<?php if($url[0] != 'login'&& $url[0] != '404' && $url[0] != 'acceso-denegado' && $url[0] != 'sesion-expirada' && $url[0] != 'auto-registro-aprendices' && $url[0] != 'auto-registro-visitantes' && $url[0] != 'auto-registro-vigilantes' && $url[0] != 'auto-registro-funcionarios'): ?>
    <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/general/menu-lateral.js"></script>
    <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/general/conteos-multitud-brigadistas.js"></script>

    <?php if($_SESSION['datos_usuario']['rol'] == 'SUPERVISOR'): ?>
        <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/general/notificaciones-supervisor.js"></script>

    <?php elseif($_SESSION['datos_usuario']['rol'] == 'SUBDIRECTOR'): ?>
        <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/general/notificaciones-subdirector.js"></script>
    <?php endif; ?>

<?php endif; ?>

<?php if($url[0] == 'auto-registro-visitantes'): ?>
    <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/auto-registros/auto-registro-visitantes.js"></script>

<?php elseif($url[0] == 'auto-registro-aprendices'): ?>
    <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/auto-registros/auto-registro-aprendices.js"></script>

<?php elseif($url[0] == 'auto-registro-funcionarios'): ?>
    <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/auto-registros/auto-registro-funcionarios.js"></script>

<?php elseif($url[0] == 'auto-registro-vigilantes'): ?>
    <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/auto-registros/auto-registro-vigilantes.js"></script>

<?php elseif($url[0] == 'login'): ?>
    <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-login/login.js"></script>

<?php elseif($url[0] == 'inicio'): ?>
    <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-inicio/inicio.js"></script>

<?php elseif($url[0] == 'entradas'): ?>
    <script src="<?php echo $urlBaseVariable; ?>app/views/js/librerias/scanapp.min.js"></script>
    <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-entradas/entrada-peatonal-supervisor-vigilante.js"></script>
    <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-entradas/entrada-vehicular-supervisor-vigilante.js"></script>

<?php elseif($url[0] == 'salidas'): ?>
    <script src="<?php echo $urlBaseVariable; ?>app/views/js/librerias/scanapp.min.js"></script>
    <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-salidas/salida-peatonal-supervisor-vigilante.js"></script>
    <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-salidas/salida-vehicular-supervisor-vigilante.js"></script>

<?php elseif($url[0] == 'visitantes'): ?>
    <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-usuarios/visitantes.js"></script>

<?php elseif($url[0] == 'informes-listado'): ?>
    <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-informes/informes-listado-subdirector-supervisor.js"></script>

<?php elseif($url[0] == 'informes-grafica'): ?>
    <script src="<?php echo $urlBaseVariable; ?>app/views/js/librerias/chart.umd.js"></script>
    <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-informes/informes-grafica-subdirector.js"></script>

<?php elseif($url[0] == 'novedades-usuario'): ?>
    <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-novedades/novedades-usuario-subdirector-supervisor.js"></script>

<?php elseif($url[0] == 'novedades-vehiculo'): ?>
    <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-novedades/novedades-vehiculo-subdirector-supervisor.js"></script>

<?php elseif($url[0] == 'aprendices'): ?>
    <?php if($_SESSION['datos_usuario']['rol'] == 'SUBDIRECTOR' || $_SESSION['datos_usuario']['rol'] == 'COORDINADOR'): ?>
        <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-usuarios/aprendices-subdirector-coordinador.js"></script>

    <?php elseif($_SESSION['datos_usuario']['rol'] == 'SUPERVISOR' || $_SESSION['datos_usuario']['rol'] == 'VIGILANTE'): ?>
        <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-usuarios/aprendices-supervisor-vigilante.js"></script>
    <?php endif; ?>

<?php elseif($url[0] == 'vigilantes'): ?>
    <?php if($_SESSION['datos_usuario']['rol'] == 'SUBDIRECTOR'): ?>
        <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-usuarios/vigilantes-subdirector.js"></script>

    <?php elseif($_SESSION['datos_usuario']['rol'] == 'SUPERVISOR'): ?>
        <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-usuarios/vigilantes-supervisor.js"></script>

    <?php elseif($_SESSION['datos_usuario']['rol'] == 'COORDINADOR' || $_SESSION['datos_usuario']['rol'] == 'VIGILANTE'): ?>
        <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-usuarios/vigilantes-coordinador-vigilante.js"></script>
    <?php endif; ?>

<?php elseif($url[0] == 'funcionarios'): ?>
    <?php if($_SESSION['datos_usuario']['rol'] == 'SUBDIRECTOR'): ?>
        <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-usuarios/funcionarios-subdirector.js"></script>

    <?php elseif($_SESSION['datos_usuario']['rol'] == 'SUPERVISOR' || $_SESSION['datos_usuario']['rol'] == 'COORDINADOR' || $_SESSION['datos_usuario']['rol'] == 'VIGILANTE'): ?>
        <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-usuarios/funcionarios-coordinador-supervisor-vigilante.js"></script>
    <?php endif; ?>

<?php elseif($url[0] == 'agendas'): ?>
    <?php if($_SESSION['datos_usuario']['rol'] == 'SUBDIRECTOR' || $_SESSION['datos_usuario']['rol'] == 'COORDINADOR'): ?>
        <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-agendas/agendas-subdirector-coordinador.js"></script>

    <?php elseif($_SESSION['datos_usuario']['rol'] == 'SUPERVISOR' || $_SESSION['datos_usuario']['rol'] == 'VIGILANTE'): ?>
        <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-agendas/agendas-supervisor-vigilante.js"></script>
    <?php endif; ?>

<?php elseif($url[0] == 'vehiculos'): ?>
    <?php if($_SESSION['datos_usuario']['rol'] == 'SUBDIRECTOR' || $_SESSION['datos_usuario']['rol'] == 'SUPERVISOR'): ?>
        <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-vehiculos/vehiculos-subdirector-supervisor.js"></script>

    <?php elseif($_SESSION['datos_usuario']['rol'] == 'VIGILANTE'): ?>
        <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-vehiculos/vehiculos-vigilante.js"></script>
    <?php endif; ?>

<?php elseif($url[0] == 'permisos-usuario'): ?>
    <?php if($_SESSION['datos_usuario']['rol'] == 'SUBDIRECTOR'): ?>
        <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-permisos/permisos-usuario-subdirector.js"></script>

    <?php elseif($_SESSION['datos_usuario']['rol'] == 'SUPERVISOR'): ?>
        <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-permisos/permisos-usuario-supervisor.js"></script>
    <?php endif; ?>

<?php elseif($url[0] == 'permisos-vehiculo'): ?>
    <?php if($_SESSION['datos_usuario']['rol'] == 'SUBDIRECTOR'): ?>
        <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-permisos/permisos-vehiculo-subdirector.js"></script>

    <?php elseif($_SESSION['datos_usuario']['rol'] == 'SUPERVISOR'): ?>
        <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-permisos/permisos-vehiculo-supervisor.js"></script>
    <?php endif; ?>
<?php endif; ?>

<script src="<?php echo $urlBaseVariable; ?>app/views/js/librerias/sweetalert2.all.min.js" ></script>
<script type="module" src="https://cdn.jsdelivr.net/npm/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://cdn.jsdelivr.net/npm/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
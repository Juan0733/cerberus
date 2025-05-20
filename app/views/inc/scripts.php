<?php if($url[0] != 'login'&& $url[0] != '404'): ?>
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
<?php elseif($url[0] == 'informes'): ?>
    <script type="module" src="<?php echo $urlBaseVariable; ?>app/views/js/modulo-informes/informes.js"></script>
<?php endif; ?>


<script src="<?php echo $urlBaseVariable; ?>app/views/js/librerias/sweetalert2.all.min.js" ></script>
<script type="module" src="https://cdn.jsdelivr.net/npm/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://cdn.jsdelivr.net/npm/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
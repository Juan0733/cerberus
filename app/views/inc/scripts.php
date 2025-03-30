
<?php
if ($url[0] != 'login' && $url[0] != 'registro-visitante') {
    ?>
    <script src="<?php echo $urlBaseVariable; ?>app/views/js/main.js"></script>
    <script src="<?php echo $urlBaseVariable; ?>app/views/js/alerta-formularios.js"></script>
   
<?php
}elseif (strpos($url[0], 'agenda') !== false) {?>

    <link rel="stylesheet" href="<?php echo $urlBaseVariable; ?>app/views/css/agendas.css"> 

<?php } elseif ($url[0] == 'registro-aprendiz') {?>
    
    <script src="<?php echo $urlBaseVariable; ?>app/views/js/registro-aprendiz.js"></script>
    <script>filtroPrograma()</script>

<?php } elseif (1==1) {
    #pass
    }

?>
<script src="../app/views/js/registro-visitante.js"></script>
<script src="../app/views/js/sweetalert2.all.min.js"></script>



<!-- <script src="app/view/js/registro-vigilantes.js"></script> -->

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<!-- <script src="app/view/js/registro-vigilantes.js"></script> -->

<?php
    require_once "../../../../config/app.php";
    $fechaActual = date('Y-m-d\TH:i');
?>

<div class="contenedor-titulo-modal">
    <h2 class="titulo-modal">Registrar Permiso Usuario</h2>
    <ion-icon name="close-outline" id="cerrar_modal_permiso_usuario" class="close-btn"></ion-icon>
</div>
<div class="contenedor-info-modal">
    <div id="cont_info_modales">
        <form  id="formulario_permiso_usuario" method="post" >
            <div id="contenedor_cajas_permiso_usuario" >

                <div class="input-caja-registro">
                    <label for="tipo_permiso" class="label-input">Tipo de permiso</label>
                    <select class="campo campo-seccion-01"  name="tipo_permiso" id="tipo_permiso" tabindex="4" required>
                        <option value="" selected disabled>Seleccionar</option>
                        <?php if($_SESSION['datos_usuario']['rol'] == 'SUPERVISOR'): ?>
                            <option value="PERMANENCIA">Permanencia</option>
                        <?php elseif($_SESSION['datos_usuario']['rol'] == 'COORDINADOR' || $_SESSION['datos_usuario']['rol'] == 'INSTRUCTOR'): ?>
                            <option value="SALIDA">Salida</option>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="input-caja-registro">
                    <label for="documento_beneficiario" class="label-input">Usuario quién requiere el permiso</label>
                    <input type="text" class="campo" name="documento_beneficiario" id="documento_beneficiario" pattern="[A-Za-z0-9]{6,15}" title="Debes digitar solo números y/o letras, mínimo 6 y máximo 15 caracteres" placeholder="Ej: 123456" date="Numero de documento" tabindex="5" required>
                </div>
                
                <div class="input-caja-registro">
                    <label for="fecha_fin_permiso" class="label-input">Vigencia del permiso</label>
                    <input 
                        class="campo" 
                        type="datetime-local" 
                        name="fecha_fin_permiso" 
                        id="fecha_fin_permiso" 
                        placeholder="Selecciona una fecha" 
                        title="Selecciona la fecha del suceso." 
                        tabindex="6" 
                        required 
                        min="<?php echo $fechaActual; ?>" >
                </div>

                <div class="input-caja-registro">
                    <label for="descripcion" class="label-input">Motivo del permiso</label>
                    <textarea
                        class="campo" 
                        name="descripcion" 
                        id="descripcion" 
                        placeholder="Escribe aquí..." 
                        tabindex="7" 
                        required></textarea>
                </div>
            </div>
            
            <div id="contenedor_btns_permiso_usuario">
                <button type="button" id="btn_cancelar_permiso_usuario">Cancelar</button>
                <button type="submit" id="btn_registrar_permiso_usuario">Registrar</button>
            </div>
        </form>
    </div>
</div>


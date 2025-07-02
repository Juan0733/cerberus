<?php
    require_once "../../../../config/app.php";
    $fechaActual = date('Y-m-d\TH:i');
?>

<div class="contenedor-titulo-modal">
    <h2 class="titulo-modal">Registrar Solicitud Permiso</h2>
    <ion-icon name="close-outline" id="cerrar_modal_permiso_vehiculo" class="close-btn"></ion-icon>
</div>
<div class="contenedor-info-modal">
    <div id="cont_info_modales">
        <form  id="formulario_permiso_vehiculo" method="post" >
            <div id="contenedor_cajas_permiso_vehiculo" >

                <div class="input-caja-registro">
                    <label for="tipo_permiso" class="label-input">Tipo de permiso</label>
                    <select class="campo campo-seccion-01" name="tipo_permiso" id="tipo_permiso" tabindex="4" required>
                        <option value="" selected disabled>Seleccionar</option>
                        <option value="PERMANENCIA">Permanencia</option>
                    </select>
                </div>

                <div class="input-caja-registro">
                    <label for="numero_placa" class="label-input">Placa del vehículo</label>
                    <input type="text" class="campo" name="numero_placa" id="numero_placa" pattern="[A-Za-z0-9]{5,6}" title="Debes digitar solo números y letras, como mínimo 5 caracteres y máximo 6 caracteres." placeholder="Ej: 123456" date="Numero de documento" tabindex="5" required>
                </div>

                <div class="input-caja-registro">
                    <label for="propietario" class="label-input">Propietario</label>
                    <select class="campo campo-seccion-01" name="propietario" id="propietario" tabindex="6" required>
                        <option value="123456789">Seleccionar</option>
                    </select>
                </div>
                
                <div class="input-caja-registro">
                    <label for="fecha_fin_permiso" class="label-input">Fecha hasta donde requiere el permiso</label>
                    <input 
                        class="campo" 
                        type="datetime-local" 
                        name="fecha_fin_permiso" 
                        id="fecha_fin_permiso" 
                        placeholder="Selecciona una fecha" 
                        title="Selecciona la fecha del suceso." 
                        tabindex="7" 
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
                        tabindex="8" 
                        required></textarea>
                </div>
            </div>
            
            <div id="contenedor_btns_permiso_vehiculo">
                <button type="button" id="btn_cancelar_permiso_vehiculo">Cancelar</button>
                <button type="submit" id="btn_registrar_permiso_vehiculo">Registrar</button>
            </div>
        </form>
    </div>
</div>


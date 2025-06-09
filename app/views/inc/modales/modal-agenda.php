<?php
    require_once "../../../../config/app.php";
    $fechaActual = new DateTime();
    $fechaMaxima = $fechaActual->format('Y-m-d\TH:i');
?>

<div class="contenedor-titulo-modal">
    <h2 class="titulo-modal"id="titulo_modal">Registrar Agenda</h2>
    <ion-icon name="close-outline" id="cerrar_modal_agenda" class="close-btn"></ion-icon>
</div>
<div class="contenedor-info-modal">
    <div id="cont_info_modales">
        <div id="contenedor_modal_agenda">
            <form action="" id="formulario_agenda" method="post" >
                <div id="contenedor_cajas_agenda">
                    <div class="caja" id="caja_01">
                        <div class="input-caja-registro">
                            <label for="titulo_agenda" class="label-input">Titulo de la agenda</label>
                            <input type="text" class="campo campo-seccion-01" inputmode="numeric" name="titulo_agenda" id="titulo_agenda" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9 ]{5,50}" title="Debes digitar solo números y letras, minimo 5 y maximo 50 caracteres" placeholder="Ej: 123456" tabindex="1" required>
                        </div>

                        <div class="input-caja-registro">
                            <label for="fecha_agenda" class="label-input">Fecha de la agenda</label>
                            <input type="datetime-local" min="<?php echo $fechaMaxima; ?>" class="campo campo-seccion-01" name="fecha_agenda" id="fecha_agenda" tabindex="2" required>
                        </div>
            
                        <div class="input-caja-registro">
                            <label for="motivo" class="label-input">Descripción</label>
                            <textarea class="campo campo-seccion-01" name="motivo" id="motivo" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9 ]{5,100}" title="Debes digitar solo números y letras, maximo 100 caracteres" placeholder="Escribe aquí..." tabindex="3" required></textarea>
                        </div>

                        <div id="contenedor_checkbox" class="input-caja-registro">
                            <div class="caja-checkbox">
                                <input type="checkbox" class="checkbox" id="individual" name="individual" value="individual">
                                <label for="individual" class="label-input">Individual</label>
                            </div>
                            <div class="caja-checkbox">
                                <input type="checkbox" class="checkbox" id="grupal" name="grupal" value="grupal">
                                <label for="grupal" class="label-input">Grupal</label>
                            </div>
                        </div>
                    </div>

                    <div class="caja" id="caja_02">
                        <div id="contenedor_caja_excel" class="input-caja-registro">
                            <div class="caja-excel">
                                <label class="label-input">Carga masiva</label>
                                <label for="plantilla_excel" id="input_excel" class="campo">
                                    <input type="file" name="plantilla_excel" id="plantilla_excel" accept=".xlsx, .xls, .xlsm">
                                    <span id="nombre_archivo">Seleccionar archivo</span>
                                </label>
                            </div>
                            <a id="btn_plantilla_excel" href="<?php echo $urlBaseVariable; ?>app/excel/formato_agenda.xlsm" download="formato_agenda.xlsm"><ion-icon name="download"></ion-icon></a>
                        </div>

                        <div class="input-caja-registro">
                            <button class="btn-vehiculo campo" id="btn_agregar_vehiculo" type="button">
                                <ion-icon name="car-outline"></ion-icon>
                                <p>Agregar vehículo</p>
                            </button>
                        </div>
                    </div>

                    <div id="caja_03" class="caja-flex caja">
                        <div class="input-caja-registro">
                            <label for="tipo_documento" class="label-input">Tipo de documento</label>
                            <select class="campo campo-seccion-02 campo-visitante"  name="tipo_documento" id="tipo_documento" tabindex="4" date="Tipo de documento">
                                <option value="" selected disabled>Seleccionar</option>
                                <option value="CC">Cedula de ciudadanía</option>
                                <option value="CE">Cedula de extranjería</option>
                                <option value="TI">Tarjeta de identidad</option>
                                <option value="PS">Pasaporte</option>
                                <option value="PEP">Permiso especial de permanencia</option>
                            </select>
                        </div>

                        <div class="input-caja-registro">
                            <label for="documento_visitante" class="label-input">Numero de documento</label>
                            <input type="tel" class="campo campo-seccion-02 campo-visitante" inputmode="numeric" name="documento_visitante" id="documento_visitante" pattern="[0-9]{6,15}" title="Debes digitar solo números, minimo 6 y maximo 15" placeholder="Ej: 123456Dil" date="Numero de documento" tabindex="5">
                        </div>
                    </div>

                    <div id="caja_04" class="caja-flex caja">
                        
                        <div class="input-caja-registro">
                            <label for="nombres" class="label-input">Nombre(s)</label>
                            <input type="text" class="campo campo-seccion-02 campo-visitante" name="nombres" id="nombres" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚüÜ ]{2,64}" title="Debes digitar solo letras, minimo 2 y maximo 64" placeholder="Ej: Oscar Alejandro" tabindex="6" date="Nombre(s)">
                        </div>

                        <div class="input-caja-registro">
                            <label for="apellidos" class="label-input">Apellido(s)</label>
                            <input type="text" class="campo campo-seccion-02 campo-visitante" name="apellidos" id="apellidos" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚüÜ ]{2,64}" title="Debes digitar solo letras, minimo 2 y maximo 64" placeholder="Ej: Alvarez" tabindex="7" date="Apellido(s)">
                        </div>
                    </div>

                    <div id="caja_05" class="caja-flex caja">
                        <div class="input-caja-registro">
                            <label for="correo_electronico" class="label-input">Correo electrónico</label>
                            <input class="campo campo-visitante" type="email" name="correo_electronico" id="correo_electronico" pattern="[a-zA-Z0-9\._%+\-]+@[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,10}" maxlength="64" minlength="11" placeholder="Ej: miCorreo@ejemplo.com" title="Lo que acabas de digitar no parece un correo electrónico." tabindex="8" date="Correo electronico">
                        </div>

                        <div class="input-caja-registro">
                            <label for="telefono" class="label-input">Numero de teléfono</label>
                            <input type="tel" class="campo campo-visitante" inputmode="numeric" name="telefono" id="telefono" pattern="[0-9]{10}" title="Debes digitar solo números, minimo y maximo 10" placeholder="Ej: 3104444333" date="Numero de telefono" tabindex="9">
                        </div>
                    </div>

                    <div id="caja_06" class="caja-flex caja">
                         <div class="input-caja-registro">
                            <button class="btn-vehiculo campo" id="btn_agregar_vehiculo" type="button">
                                <ion-icon name="car-outline"></ion-icon>
                                <p>Agregar vehículo</p>
                            </button>
                        </div>
                    </div>
                </div>

                <div id="contenedor_btns_agenda">
                    <button type="button" id="btn_atras_agenda">Atras</button>
                    <button type="button" id="btn_cancelar_agenda">Cancelar</button>
                    <button type="button" id="btn_siguiente_agenda">Siguiente</button>
                    <button type="submit" id="btn_registrar_agenda">Registrar</button>
                    <button type="submit" id="btn_actualizar_agenda">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>



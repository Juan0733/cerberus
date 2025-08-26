<input type="hidden" id="url_base" value="<?php echo $urlBaseVariable; ?>">

<?php if(!isset($_SESSION['datos_usuario']['puerta'])): ?>
    <input type="hidden" id="puerta" >
<?php endif; ?>

<div id="contenedor_principal">
    <div id="contenedor_btns_formularios">
        <div id="contenedor_btn_volver">
            <button type="button" id="btn_volver">
                <ion-icon name="chevron-back-outline" role="img" class="md hydrated"></ion-icon>
            </button>
        </div>

        <div class="contenedor-btn-formulario" id="contenedor_peatonal">
            <button type="button" id="btn_peatonal" class="btn-peatonal-vehicular">
                <ion-icon name="walk"></ion-icon>
                <h1>Peatonal</h1>
            </button>
            
            <form action="" method="post" id="formulario_peatonal" class="formulario">
                <h1 class="titulo-formulario">Entrada Peatonal</h1>
                <div class="contenedor-input-btn">
                    <div class="input-caja">
                        <label for="documento_peaton">Número documento</label>
                        <input type="text" class="campo" name="documento_peaton" id="documento_peaton" pattern="[A-Za-z0-9]{6,15}" title="Debes digitar solo números y letras, mínimo 6 y máximo 15 caracteres" placeholder="Ej: 123456" tabindex="1" required>
                    </div>
                    <button type="button" id="btn_scaner_qr_peaton" class="btn-scaner">
                        <ion-icon name="camera"></ion-icon>
                    </button>
                </div>
               
                <div class="input-caja">
                    <label for="observacion_peatonal">Observación</label>
                    <textarea class="campo" name="observacion_peatonal" id="observacion_peatonal" placeholder="Escribe aquí..." tabindex="2"></textarea>
                </div>
                <button type="submit" class="btn-registrar">Registrar</button>
            </form>
        </div>

        <div class="contenedor-btn-formulario" id="contenedor_vehicular">
            <button type="button" id="btn_vehicular" class="btn-peatonal-vehicular">
                    <ion-icon name="car"></ion-icon>
                    <h1>Vehicular</h1>
            </button>

            <div id="formulario_vehicular" class="formulario">
                <h1 class="titulo-formulario">Entrada Vehicular</h1>

                <div id="contenedor_vehiculo_propietario">
                    <div class="input-caja" id="caja_placa_vehiculo">
                        <label for="placa_vehiculo">Placa vehículo</label>
                        <input type="text" class="campo input-placa"  name="placa_vehiculo" id="placa_vehiculo" pattern="[A-Za-z0-9]{6,6}" title="Debes digitar solo números y letras, máximo 6 caracteres." minlength="6" maxlength="6" placeholder="Ej: ABC123" tabindex="1"  required>
                    </div>
                    <div class="input-caja" id="caja_tipo_vehiculo">
                        <label for="tipo_vehiculo" class="label-input">Tipo de vehículo</label>
                        <select class="campo"  name="tipo_vehiculo" id="tipo_vehiculo">
                            <option value="" selected disabled>Seleccionar</option>
                            <option value="AUTOMÓVIL">Automóvil</option>
                            <option value="BUS">Bus</option>
                            <option value="CAMIÓN">Camión</option>
                            <option value="MOTO">Moto</option>
                        </select>
                    </div>
                    
                    <div class="contenedor-input-btn" id="caja_propietario_btn">
                        <div class="input-caja">
                            <label for="documento_propietario">Propietario vehículo</label>
                            <input type="text" class="campo" id="documento_propietario" name="documento_propietario" list="lista_propietarios" pattern="[A-Za-z0-9]{6,15}" minlength="6" title="Debes digitar solo números y letras, mínimo 6 y máximo 15 caracteres" placeholder="Ej: 123456" tabindex="2" required> 
                            <datalist id="lista_propietarios">
                            </datalist>
                        </div> 
                        <button type="button" id="btn_scaner_qr_propietario" class="btn-scaner">
                            <ion-icon name="camera"></ion-icon>
                        </button>
                    </div>
                </div>

                <form action="" method="post" id='formulario_pasajeros' class="caja-flex">
                    <div class="input-caja">
                        <label for="documento_pasajero">Doc. Pasajero</label>
                        <input type="text" class="campo" name="documento_pasajero" id="documento_pasajero" pattern="[A-za-z0-9]{6,15}" minlength="6" title="Debes digitar solo números y letras, mínimo 6 y máximo 15 caracteres" placeholder="Ej: 123456" tabindex="3" required>
                    </div>

                    <button type="submit" id="btn_agregar_pasajero">
                        <ion-icon name="add"></ion-icon>
                    </button>

                    <button type="button" id="btn_scaner_qr_pasajero" class="btn-scaner">
                        <ion-icon name="camera"></ion-icon>
                    </button>
                </form>

                <div id="contenedor_pasajeros">
                    <table id="tabla_pasajeros">
                        <thead>
                            <tr>
                                <th>Identificacion</th>
                                <th>Nombres</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="cuerpo_tabla_pasajeros" class="body_tabla_pasajeros">
                        </tbody>
                    </table>
                </div>
                
                <div class="input-caja">
                    <label for="observacion_vehicular">Observación</label>
                    <textarea class="campo" name="observacion_vehicular" id="observacion_vehicular" placeholder="Escribe aquí..." tabindex="4"></textarea>
                </div>

                <button type="button" class="btn-registrar" id="registrar_entrada">Registrar</button>
            </div>  
        </div>
    </div>
</div>

<input type="hidden" id="url_base" value="<?php echo $urlBaseVariable; ?>">

<div id="contenedor_principal">
    <div id="contenedor_btns_formularios">
        <div id="contenedor_btn_volver">
            <button type="button" id="btn_volver">
                <ion-icon name="chevron-back-outline" role="img" class="md hydrated"></ion-icon>
            </button>
        </div>

        <div class="contenedor-btn-formulario" id="contenedor_peatonal">
            <button type="button" id="btn_peatonal" class="btn-peatonal-vehicular">
                <ion-icon name="walk-outline"></ion-icon>
                <h1>Peatonal</h1>
            </button>
            
            <form action="" method="post" id="formulario_peatonal" class="formulario">
                <h1 class="titulo-formulario">Salida Peatonal</h1>
                <div class="input-caja">
                    <label for="documento_peaton">Numero documento</label>
                    <input type="tel" class="campo" inputmode="numeric" name="documento_peaton" id="documento_peaton" pattern="[A-Za-z0-9]{6,15}" title="Debes digitar solo numeros y letras, minimo 6 y maximo 15 caracteres" placeholder="Ej: 123456" tabindex="1" required>
                </div>
                <div class="input-caja">
                    <label for="observacion_peatonal">Observacion</label>
                    <textarea class="campo" inputmode="numeric" name="observacion_peatonal" id="observacion_peatonal" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9 ]{0,100}" title="Debes digitar solo numeros y letras, maximo 100 caracteres" placeholder="Escribe aquí..." tabindex="2" ></textarea>
                </div>
                <button type="submit" class="btn-registrar">Registrar</button>
            </form>
        </div>

        <div class="contenedor-btn-formulario" id="contenedor_vehicular">
            <button type="button" id="btn_vehicular" class="btn-peatonal-vehicular">
                    <ion-icon name="car-outline"></ion-icon>
                    <h1>Vehicular</h1>
            </button>

            <div id="formulario_vehicular" class="formulario">
                <h1 class="titulo-formulario">Salida Vehicular</h1>
                <div class="caja-flex">
                    <div class="input-caja " id="caja_placa_vehiculo">
                        <label for="placa_vehiculo">Placa vehículo</label>
                        <input type="tel" class="campo input-placa"  name="placa_vehiculo" id="placa_vehiculo" pattern="[A-Za-z0-9]{5,6}" title="Debes digitar solo numeros y letras, maximo 6 caracteres." minlength="5" maxlength="6" placeholder="Ej: ABC123" tabindex="1"  required>
                    </div>

                    <div class="input-caja">
                        <label for="documento_propietario">Propietario vehículo</label>
                        <input type="tel" class="campo" inputmode="numeric" id="documento_propietario" name="documento_propietario" list="lista_propietarios" pattern="[A-Za-z0-9]{6,15}" minlength="6" title="Debes digitar solo numeros y letras, minimo 6 y maximo 15 caracteres" placeholder="Ej: 123456" tabindex="2" required> <!-- se pasa como paremtro el estado en el cual debe de estar el vehiculo para poder ser llamado -->
                        <datalist id="lista_propietarios">
                        </datalist>
                    </div>  
                </div>

                <form action="" method="post" id='formulario_pasajeros' class="caja-flex">
                    <div class="input-caja">
                        <label for="documento_pasajero">Doc. Pasajero</label>
                        <input type="tel" class="campo" inputmode="numeric" name="documento_pasajero" id="documento_pasajero" pattern="[A-za-z0-9]{6,15}" minlength="6" title="Debes digitar solo numeros y letras, minimo 6 y maximo 15 caracteres" placeholder="Ej: 123456" tabindex="3" required>
                    </div>

                    <button type="submit" id="btn_agregar_pasajero">
                        <ion-icon name="person-add-outline"></ion-icon>
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
                    <label for="observacion_vehicular">Observacion</label>
                    <textarea class="campo" inputmode="numeric" name="observacion_vehicular" id="observacion_vehicular" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚüÜ0-9 ]{0,100}" title="Debes digitar solo numeros y letras, maximo 100 caracteres" placeholder="Escribe aquí..." tabindex="4" ></textarea>
                </div>

                <button type="button" class="btn-registrar" id="registrar_salida">Registrar</button>
            </div>  
        </div>
    </div>
</div>
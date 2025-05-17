<input type="hidden" id="url_base" value="<?php echo $urlBaseVariable; ?>">

<div class="contenedor-reportes " id="panel_salida">
    <div class="contenedor-card-ptn-vhl">
        <div id="btn_volver_peatonal_vehicular" class="cont-btn-volver">
            <button type="button" class="btn-ent-sal-volver">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </button>
        </div>
        <div class="cont_entrada_salida_01 cont_e_s cont-entr-sali-peatonal">
            <div id="btn_peatonal" class="card-entr-sali cont-card-ptn">
                <ion-icon name="walk-outline"></ion-icon>
                <h1>Peatonal</h1>
            </div>
            <form action="" method="post" id="formulario_peatonal" class="formulario-ingreso-salida" >
                <h1 class="titulo-formulario">Salida Peatonal</h1>
                <div class="cont_cajas_ptn">
                    <div class="input-caja">
                        <label for="documento_peaton">Numero documento</label>
                        <input type="tel" class="campo" inputmode="numeric" name="documento_peaton" id="documento_peaton" pattern="[A-Za-z0-9]{6,15}" title="Debes digitar solo numeros y letras, minimo 6 y maximo 15 caracteres" placeholder="Ej: 123456" tabindex="1" required>
                    </div>
                    <div class="input-caja">
                        <label for="observacion_peatonal">Observacion</label>
                        <textarea class="campo" inputmode="numeric" name="observacion_peatonal" id="observacion_peatonal" pattern="[A-Za-z0-9 ]{0,100}" title="Debes digitar solo numeros y letras, maximo 100 caracteres" placeholder="Escribe aquí..." tabindex="2" ></textarea>
                    </div>
                </div>
                <button type="submit" class="btn-eviar-reporte">Registrar</button>
            </form>
        </div>
        <div class="cont_entrada_salida_02 cont_e_s cont-entr-sali-vehicular">
            <div id="btn_vehicular" class="card-entr-sali cont_card-vhl">
                    <ion-icon name="car-outline"></ion-icon>
                    <h1>Vehicular</h1>
            </div>

            <div id="formulario_vehicular">
                <h1 class="titulo-formulario">Salida Vehicular</h1>
                <div class="cont_cajas">
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
                <div class="cont_cajas">
                    <form action="" method="post" id='formulario_pasajeros' class="formulario-ingreso-salida-pasajeros">
                        <div class="input-caja">
                            <label for="documento_pasajero">Doc. Pasajero</label>
                            <div class="cont-input-buscar">
                                <input type="tel" class="campo" inputmode="numeric" name="documento_pasajero" id="documento_pasajero" pattern="[A-za-z0-9]{6,15}" minlength="6" title="Debes digitar solo numeros y letras, minimo 6 y maximo 15 caracteres" placeholder="Ej: 123456" tabindex="3" required>
                                <button type="submit"   class="agregar-persona">
                                    <ion-icon name="person-add-outline"></ion-icon>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="contenido_1">
                    <table id="tabla_pasajeros" class="listado_pasajero">
                        <thead style="text-transform: uppercase;">
                            <tr>
                                <th class="colum-oculta">Tipo Doc.</th>
                                <th>Identificacion</th>
                                <th>Nombres</th>
                                <th class="colum-oculta">Apellidos</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="cuerpo_tabla_pasajeros" class="body_tabla_pasajeros">
                        </tbody>
                    </table>
                </div>
                
                <div class="cont_cajas">
                    <div class="input-caja">
                        <label for="observacion_vehicular">Observacion</label>
                        <textarea class="campo" inputmode="numeric" name="observacion_vehicular" id="observacion_vehicular" pattern="[0-9]{6,15}" title="Debes digitar solo numeros y letras, maximo 100 caracteres" placeholder="Escribe aquí..." tabindex="4" ></textarea>
                    </div>

                </div>
                <button type="button" class="btn-eviar-reporte" id="registrar_salida">Registrar</button>
            </div>  
        </div>
    </div>
</div>

<div class="contenedor-reportes " id="panel_entrada">
    <div class="contenedor-card-ptn-vhl">
        <div class="cont-btn-volver">

            <button type="button" class="btn-ent-sal-volver">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </button>
        </div>
        <div class="cont_entrada_salida_01 cont_e_s cont-entr-sali-peatonal">
            <div class="card-entr-sali cont-card-ptn">
                <ion-icon name="walk-outline"></ion-icon>
                <h1>Peatonal</h1>
            </div>
            <form action="<?php echo APP_URL_BASE; ?>app/ajax/ingreso-ajax.php" method="post" id="form_entr" class="formulario-ingreso-salida" >
                <input type="hidden" name="modulo_ingreso" value="ingreso_peatonal_registro" >
                <h1 class="titulo-formulario">Entrada Peatonal</h1>
                <div class="cont_cajas_ptn">
                    <div class="input-caja">
                        <label for="observaciones">Observacion</label>
                        <textarea class="campo" inputmode="numeric" name="observaciones" id="observaciones" pattern="[0-9]{6,15}" title="Debes digitar solo numeros y como minimo 6 numeros y maximo 10 numeros" placeholder="Escribe aquí..." tabindex="4" ></textarea>
                    </div>
                    <div class="input-caja">
                        <label for="num_documento_persona">Numero de documento</label>
                        <input type="tel" class="campo" inputmode="numeric" name="num_identificacion" id="num_identificacion" pattern="[0-9 ]{6,15}" title="Debes digitar solo numeros y como minimo 6 numeros y maximo 10 numeros" placeholder="Ej: 123456" tabindex="4" required onchange="tomarCedulaQR('')">
                    </div>
                    
                    

                </div>
                <button type="submit" class="btn-eviar-reporte">Registrar</button>
            </form>
        </div>
        <div class="cont_entrada_salida_02 cont_e_s cont-entr-sali-vehicular">
            <div class="card-entr-sali cont_card-vhl">
                    <ion-icon name="car-outline"></ion-icon>
                    <h1>Vehicular</h1>
            </div>

            <div id="form_entr_vehi">
            <input type="hidden" name="modulo_ingreso" id="modulo_ingreso" value="ingreso_vehicular_registro">
            <h1 class="titulo-formulario">Entrada Vehicular</h1>
                <div class="cont_cajas">
                    <div class="input-caja input-caja-num-doc">
                        <label for="num_identificacion_vehiculo">Numero de documento</label>
                        <input type="tel" class="campo" inputmode="numeric" id="num_identificacion_vehiculo" name="num_identificacion_vehiculo"  pattern="[0-9 ]{6,15}" title="Debes digitar solo numeros y como minimo 6 numeros y maximo 10 numeros" placeholder="Ej: 123456" tabindex="4" onchange="tomarCedulaQR('FUERA')"> <!-- se pasa como paremtro el estado en el cual debe de estar el vehiculo para poder ser llamado -->
                    </div>  
                    
                
                    <div class="input-caja ">
                        
                        <label for="placa_vehiculo">Placa de vehiculo</label>
                        <input type="tel" class="campo"  name="placa_vehiculo" id="placa_vehiculo" pattern="[A-Z0-9]{6,7}" title="Debes digitar solo numeros y letras mayusculas maximo 7 caracteres." placeholder="Ej: ABC123" tabindex="8" list="placa_lista" required>
                        <datalist id="placa_lista">
                        </datalist>
                    </div>
                </div>
                <div class="cont_cajas">

                    <form action="<?php echo APP_URL_BASE; ?>app/ajax/ingreso-ajax.php" method="post" class="formulario-ingreso-salida-pasajeros">
                        <div class="input-caja">
                            <label for="num_identificacion_pasajero">Doc. Pasajero</label>
                            <div class="cont-input-buscar">
                                
                                <input type="tel" class="campo" inputmode="numeric" name="num_identificacion_pasajero" id="num_identificacion_pasajero" pattern="[0-9 ]{6,15}" title="Debes digitar solo numeros y como minimo 6 numeros y maximo 10 numeros" placeholder="Ej: 123456" tabindex="4" onchange="tomarCedulaQR('pasajero')">
                                
                        
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
                        <tbody id="tabla_body_pasajeros" class="body_tabla_pasajeros">

                        </tbody>
                    </table>
                </div>
                
                
                <div class="cont_cajas">
                    <div class="input-caja">
                        <label for="observaciones_vehiculo">Observacion</label>
                        <textarea class="campo" inputmode="numeric" name="observaciones_vehiculo" id="observaciones_vehiculo" pattern="[0-9]{6,15}" title="Debes digitar solo numeros y como minimo 6 numeros y maximo 10 numeros" placeholder="Escribe aquí..." tabindex="4" ></textarea>
                    </div>

                </div>
                <button type="button" class="btn-eviar-reporte" id="formulario-vehiculo">Registrar</button>
            </div>  
        </div>
    </div>
    <div class="contenedor_ppal_reporte">

        <div style="display:flex;">
            
            <h3 id="titulo_ppal_02">Ultimos Reportes</h3>

        
        </div>
        <select name="cantidad_ver" id="cantidad_ver" onchange="infoListado('SALIDA')">
                <option value="5">5</option>
                <option value="10">10</option>
            </select>

            <div id="contenedor_tabla">
            <select name="cantidad_ver" id="cantidad_ver" onchange="infoListado('ENTRADA')">
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="30">30</option>
            </select>
        <div id="contenedor_tabla">

        </div>
    </div>
</div>
<script src="<?php echo APP_URL_BASE; ?>app/views/js/ingreso.js"></script>
<script src="<?php echo APP_URL_BASE; ?>app/views/js/ingreso-vehicular.js"></script>
<script>
    infoListado("ENTRADA")
</script> 

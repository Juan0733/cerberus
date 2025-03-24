<form class="formulario-fetch" action="<?php echo APP_URL_BASE; ?>app/ajax/agendaAjax.php" method="POST">
        <input type="hidden" name="modulo_agenda" value="registrar">

        <!-- Checkboxes -->
       
        <h2>Registro de Agendas</h2>
        <!-- Formulario principal -->
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Título de la agenda</label>
                    <input class="input" type="text" name="titulo_agenda" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required>
                </div>
            </div>

            <div class="column">
                <div class="control">
                    <label>Descripción de la agenda</label>
                    <input class="input" type="text" name="descripcion_agenda" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,100}" maxlength="100" required>
                </div>
            </div>

            <div class="column">
                <div class="control">
                    <label>Número de documento</label>
                    <input class="input" type="text" name="num_documento_persona" pattern="[a-zA-Z0-9\-]{7,30}" maxlength="30" required>
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Fecha y hora de la agenda</label>
                    <input class="input" type="datetime-local" name="fecha_hora_agenda" required>
                </div>
            </div>

            
        </div>

        <div class="checkbox-group">
            <label>
                <input type="checkbox" id="grupalCheckbox"> Grupal
            </label>
        </div>

        <div class="checkbox-group">
            <label>
                <input type="checkbox" id="vehiculoCheckbox"> Vehículo
            </label>
        </div>
        
       
        <div id="modalVehiculo" class="modal" data-target="vehiculo">
        <div class="modal-content">
            <h2>Registro de Vehículo</h2>
            
            <div class="input-caja">
            <div class="column">
                <div class="control">
                    <label>Documento conductor</label>
                    <input class="input" type="text" name="num_identificacion_persona" pattern="[a-zA-Z0-9\-]{7,30}" maxlength="30" >
                </div>
            </div>
                    
                    <label for="tipo_vehiculo_vigilante">Tipo de vehiculo</label>
                    <select class="campo"  name="tipo_vehiculo" id="tipo_vehiculo" tabindex="7">
                        <option value="">Selecciona el tipo de vehiculo.</option>
                        <option value="AT">Atomovil</option>
                        <option value="BS">Bus</option>
                        <option value="CM">Camion</option>
                        <option value="MT">Moto</option>
                    </select>
    
                </div>
    
                <div class="input-caja">
                    
                    <label for="placa_vehiculo_vigilante">Placa de vehiculo</label>
                    <input type="tel" class="campo"  name="placa_vehiculo" id="placa_vehiculo" pattern="[A-Z0-9]{6,7}" title="Debes digitar solo numeros y letras mayusculas maximo 7 caracteres." placeholder="Ej: ABC123" tabindex="8">
    
                </div>
                
            
        </div>
            
    </div>
    </div>

        <!-- Botones -->
        <button class="button is-light" type="reset">Cancelar</button>
        <button type="submit" class="boton" name="registro">Registrar agendas</button>
    </form>
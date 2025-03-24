
    <div id="modalGrupal" class="modal" data-target="grupal">

    <input type="file" id="archivoExcel" accept=".xls,.xlsx">

    <form  id="formularioAgenda" action="<?php echo APP_URL_BASE; ?>app/ajax/agendaAjax.php" method="POST">
        <input type="hidden" name="modulo_agenda" value="registrar">

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
                <input type="checkbox" id="grupalCheckbox" name="agenda_grupar_check"> Grupal
            </label>
        </div>

        <div class="checkbox-group">
            <label>
                <input type="checkbox" id="vehiculoCheckbox" name="agenda_vehiculo_check" > Vehículo
            </label>
        </div>

        <div id="modalVehiculo" class="modal" data-target="vehiculo">
            <div class="modal-content">
                <h2>Registro de Vehículo</h2>
                <div class="column">
                    <div class="control">
                        <label>Documento conductor</label>
                        <input class="input" type="text" name="num_identificacion_persona" pattern="[a-zA-Z0-9\-]{7,30}" maxlength="30">
                    </div>
                </div>
                
                <label for="tipo_vehiculo_vigilante">Tipo de vehículo</label>
                <select class="campo" name="tipo_vehiculo" id="tipo_vehiculo" tabindex="7">
                    <option value="">Selecciona el tipo de vehículo.</option>
                    <option value="AT">Automóvil</option>
                    <option value="BS">Bus</option>
                    <option value="CM">Camión</option>
                    <option value="MT">Moto</option>
                </select>

                <label for="placa_vehiculo_vigilante">Placa de vehículo</label>
                <input type="tel" class="campo" name="placa_vehiculo" id="placa_vehiculo" pattern="[A-Z0-9]{6,7}" title="Debes digitar solo números y letras mayúsculas, máximo 7 caracteres." placeholder="Ej: ABC123" tabindex="8">
            </div>
        </div>

        <div id="modalGrupal" class="modal" data-target="grupal">

            <div class="modal-content">
                <h2>Registro de Agendas Grupales</h2>
                <label>Documento de Identificación</label>
                <div>
                    <input id="documentoPersona" class="input" type="text" name="num_identificacion_persona" pattern="[0-9]{0,15}" maxlength="30" placeholder="Ingrese cédula">
                    <button id="btnAgregarPersona" type="button">Buscar</button>
                    <button id="" type="button" onclick="registrarAgenda()">btn Prueba</button>
                </div>
            </div>
        </div>

        <table id="tablaResultados">
            <thead>
                <tr>
                    <th>Tipo de Documento</th>
                    <th>Identificación</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th style="display: none;">Correo</th>
                    <th style="display: none;">Telefono</th>
                </tr>
            </thead>
            <tbody id="grupal_tabla_personas">
            </tbody>
        </table>
        <button type="button">Seguiente</button>
        <button type="submit">Registrar Agenda</button>
    </form> 

<script src="../app/views/js/listar.js"></script>
<style>
    #tablaResultados th:nth-child(5),
#tablaResultados td:nth-child(5),
#tablaResultados th:nth-child(6),
#tablaResultados td:nth-child(6) {
    display: none;
}
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script>






    </script>

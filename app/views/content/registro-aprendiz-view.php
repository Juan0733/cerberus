<?php
    namespace app\view\content;
    use app\controllers\aprendizController as aprendizController;
    require_once "config/app.php";
	require_once "app/views/inc/session_start.php";
	require_once "autoload.php";
    require 'app/controllers/aprendizController.php';
    $insAprendiz = new AprendizController();
    $nombres_fichas = $insAprendiz->obtenerNombresController();
?>

<div class="contenedor">

    <form class="formulario-fetch" id="forma-aprendiz" name="forma-aprendiz" action="<?php echo APP_URL_BASE; ?>app/ajax/aprendiz-ajax.php" method="post">
        
        <input type="hidden" name="modulo_aprendiz" value="Registrar">

        <article id="grupo_1"  class="grupo_formularios">

            <div class="fila_formularios">
                <div class="input-caja">
                <label for="nombres_aprendiz">Nombre(s) </label>
                    <input type="text" name="nombre_a" id="nombre_a" placeholder="Digite su(s) nombre(s)" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ\s]{2,64}" minlength="2" maxlength="64" title="Parece que algo esta mal con su(s) nombre(s), no se puede usar caracteres epsciales, solo puede ser de minimo 2 caracteres y maximo de 64" tabindex="1" required>
                </div>

                <div class="input-caja">
                <label  for="apellidos_aprendiz">Apellidos </label>
                    <input type="text" name="apellido_a" id="apellido_a" placeholder="Digite su(s) apellido(s)" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ\s]{2,64}" minlength="2" maxlength="64" title="Parece que algo esta mal con su(s) apellidos(s), no se puede usar caracteres epsciales, solo puede ser de minimo 2 caracteres y maximo de 64" tabindex="2" required>
                </div>
            </div>

            <div class="fila_formularios">
                <div class="input-caja">
                    <label for="tipo_documento_a">Tipo de documento<label>
                    <select class="campo" name="tipo_documento_a" id="tipo_documento_a" tabindex="3" required>
                        <option value="" hidden>Selecione tu tipo de documento</option>
                        <option value="TI">Tarjeta de identidad</option>
                        <option value="CC">Cedula de ciudadania</option>
                    </select>
                </div>
                
                <div class="input-caja">
                    <label for="num_documento_a">Numero de documento</label>
                    <input type="text" name="numero_documento_a" id="numero_documento_a" placeholder="Digite su numero de documento" pattern="[0-9]{6-16}" minlength="6" maxlength="16" title="Parece que el numero de documento no es valido, solo puede contener numeros, solo puede ser de minimo 6 caracteres y maximo de 16" tabindex="4" required>
                </div>
            </div>

            <div class="contenedor_btn_continuar_formularios">
				<button class="btn_enviar_form_formularios" id="btn_continuar">CONTINUAR</button>
			</div>
    
        </article>

        
        <article id="grupo_2_formularios" class="grupo_formularios">

            <div class="fila_formularios">

                <div class="input-caja">
                    <label for="nombre_programa">Programa de formacion</label>
                    <select class="campo" name="nombre_programa" id="nombre_programa" tabindex="5" required>
                        <option value="" hidden>Seleccione el nombre del programa de formacion</option>
                        <?php
                            echo $nombres_fichas
                        ?>
                    </select>
                </div>

                <div class="input-caja">
                    <label for="numero_ficha">Numero de ficha</label>
                    <select class="campo" name="numero_ficha" id="numero_ficha" tabindex="6">
                        <option value="" hidden>Selecione el numero de ficha</option>
                        
                    </select>
                </div>

            </div>
            
            <div class="fila_formularios">
                <div class="input-caja">
                    <label for="email_a">Email</label>
                    <input type="email" class="campo" name="email_a" id="email_a" placeholder="Digite su correo electronico" pattern="[a-zA-Z0-9!#$%&'*\/=?^_`\{\|\}~\+\-]([\.]?[a-zA-Z0-9!#$%&'*\/=?^_`\{\|\}~\+\-])+@[a-zA-Z0-9]([^@&%$\/\(\)=?¿!\.,:;]|\d)+[a-zA-Z0-9][\.][a-zA-Z]{2,4}([\.][a-zA-Z]{2})?" minlength="8" maxlength="88" title="Lo que digistaste no parece un correo" tabindex="7" required>
                </div>

                <div class="input-caja">
                    <label for="numero_a">Teléfono</label>
                    <input type="tel" class="campo" name="numero_a" id="numero_a" placeholder="Digite su numero telefonico" pattern="[0-9]{10}" minlength="10" maxlength="10" title="El numero de telefono debe tener 10 caracteres" tabindex="8" required>
                </div>
            </div>

            <h3 class="formularios-h">(No Obligatorio)</h3>

            <div class="fila_formularios">

                <div class="input-caja">

                    <label for="tipo_vehiculo_aprendiz">Tipo de vehiculo</label>
                        <select class="campo"  name="tipo_vehiculo_aprendiz" id="tipo_vehiculo_aprendiz" tabindex="9">
                        <option value="" hidden>Selecciona el tipo de vehiculo</option>
                        <option value="AT">Atomovil</option>
                        <option value="BS">Bus</option>
                        <option value="CM">Camion</option>
                        <option value="MT">Moto</option>
                        </select>

                </div>

                <div class="input-caja">
                    
                    <label for="placa_vehiculo_aprendiz">Placa de vehiculo</label>
                    <input type="text" class="campo"  name="placa_vehiculo_aprendiz" id="placa_vehiculo_aprendiz" pattern="[A-Z0-9]{6,7}"  maxlength="7" minlength="4"
                    title="Debes digitar solo numeros y letras mayusculas maximo 7 caracteres." placeholder="Ej: ABC123" tabindex="10">

                </div>

            </div>

			<div class="contenedor_btn" id="btn_enviar_media">
						<button class="btn_enviar_form_formularios" id="btn_anterior_formularios"><ion-icon name="arrow-back-outline" id="icono-atras"></ion-icon></button>

                        <button id="btn_enviar_form" type="submit" class="btn_enviar_form_formularios" name="registro" tabindex="11">Registrar</button>			
			</div> 


        </article>
    </form>
</div>

<script src="<?php echo APP_URL_BASE; ?>app/views/js/registro-aprendiz.js"></script>

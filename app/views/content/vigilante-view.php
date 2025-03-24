<div class="contenedor-vigilante">
	<form class="formulario-fetch" action="<?php echo APP_URL_BASE; ?>app/ajax/vigilanteAjax.php" method="post">
	<script src="<?php echo APP_URL_BASE; ?>app/views/js/registro-vigilantes.js"></script>

	<input type="hidden" name="modulo_vigilante" value="registrar">



	<article id="grupo_1"  class="grupo_formularios">

		<div class="fila_formularios" id="fila_1">
			
			
					<div class="input-caja">
		
					<label for="nombres_vigilantes">Nombre(s) </label>
		 			 <input  id="nombres" class="campo_nombres" type="text" name="nombres" required tabindex="1" pattern="[a-zA-Z\ s]{2,64}" maxlength="64" minlength="2" title="Por favor, solo se debe ingresar letras en minusculas o mayusculas y como minimo dos(2)" placeholder="Digita tu(s) nombre(s)." >
				</div>

				<div class="input-caja" >

					<label  for="apellidos_vigilantes">Apellidos </label>
					<input  id="apellidos" class="campo_apellidos" type="text" name="apellidos" pattern="[a-zA-Z\ s]{2,64}" maxlength="64" minlength="2" title="Por favor, solo se debe ingresar letras en minusculas o mayusculas y como minimo dos(2)" placeholder="Digita tu(s) apellido(s)." required tabindex="2">
	
				</div>
		</div>

		<div  class="fila_formularios">
			<div class="input-caja">

				<label for="tipo_doc_vigilante">Tipo de documento<label>
				<select class="campo"  name="tipo_documento" id="tipo_documento" tabindex="3">
					<option value=""  disabled selected>Selecciona el tipo de documento.</option>
					<option value="CC">Cedula</option>
					<option value="TJ">Tarjeta de identidad</option>
					<option value="PS">Pasaporte</option>
					<option value="OT">Otro</option>
				</select>
			</div>
			
		



			<div class="input-caja">
				<label for="num_documento_vigilante">Numero de documento</label>

					<input id="num_identificacion" class="input" type="number" name="num_identificacion" inputmode="numeric" title="Por favor ingresa tu número de documento con números" pattern="[0-9]{6,13}" minlength="6" maxlength="13" placeholder="Digita número de identificacion" required tabindex="4">




	</div>
	</div>
			<div class="contenedor_btn_continuar_formularios">
                 
					<button class="btn_enviar_form_formularios" id="btn_continuar">CONTINUAR</button>
                </div>


	</article>

	<article id="grupo_2_formularios" class="grupo_formularios">
		<div class="fila_formularios">
			<div class="input-caja">
				<label for="rol_vigilante">Rol de viglante</label>
				<select class="campo"  name="rol_usuario" id="rol_usuario" tabindex="5" required>
					<option value="" disabled selected>Selecciona tu rol</option>
					<option value="VJ">Vigilante jefe</option>
					<option value="VR">Vigilante rico</option>
					<option value="VN">Vigilante normal</option>

				</select>

			</div>

			<div class="input-caja">

			<label>Teléfono</label>
				<input id="telefono" class="input" type="number" name="telefono" pattern="\+?[0-9]{10,14}" maxlength="10" minlength="10" placeholder="Digita número de telefono" title="Por favor, ingresa un número de teléfono válido incluyendo el código de país si es necesario" required tabindex="6">

		
			</div>

		</div>

		<div class="fila_formularios">
			<div class="input-caja" >
				<label>Email</label>
			  	<input  id="email" class="input" type="email" name="correo" inputmode="email" placeholder="Digita tu correo electronico" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" title="Por favor, ingresa una dirección de correo electrónico válida" maxlength="64" minlength="8" required tabindex="7" >

			</div>
		</div>
		<h3 class="formularios-h">(No Obligatorio)</h3>

		<div class="fila_formularios">
			<div class="input-caja">

				<label for="tipo_vehiculo_vigilante">Tipo de vehiculo</label>
					<select class="campo"  name="tipo_vehiculo_vigilante" id="tipo_vehiculo_vigilante" tabindex="8">
					<option value="">Selecciona el tipo de vehiculo.</option>
					<option value="AT">Atomovil</option>
					<option value="BS">Bus</option>
					<option value="CM">Camion</option>
					<option value="MT">Moto</option>
					</select>
		</div>
		<div class="input-caja">
			
			<label for="placa_vehiculo_vigilante">Placa de vehiculo</label>
			<input type="text" class="campo"  name="placa_vehiculo_vigilante" id="placa_vehiculo_vigilante" pattern="[A-Z0-9]{6,7}"  maxlength="7" minlength="4"
			 title="Debes digitar solo numeros y letras mayusculas maximo 7 caracteres." placeholder="Ej: ABC123" tabindex="9">

		</div>

		</div>

		<div class="contenedor_btn" id="btn_enviar_media">

					<button class="btn_enviar_form_formularios" id="btn_anterior_formularios"><ion-icon name="arrow-back-outline" id="icono-atras"></ion-icon></button>

					
					<button  id="btn_enviar_form" type="submit" class="btn_enviar_form_formularios" name="registro">Registrar</button>  
            </div> 
		<!-- <div id="contenedor_btn_formularioss">
		
            <button class="btn_enviar_form_formularios" id="btn_anterior_formularios"><ion-icon name="arrow-back-outline" id="icono-atras"></ion-icon></button>

		
			<button  id="btn_enviar_form" type="submit" class="btn_enviar_form_formularios" name="registro">Registrar</button>
		</div> -->

		<!-- <div class="contenedor_btn" id="btn_enviar_media">
                <button class="btn_enviar_form" id="btn_anterior_2"><ion-icon name="arrow-back-outline" class="icono-atras"></ion-icon></button>
                <button type="submit" class="btn_envia_form" id="btn_envia_form">Enviar</button>    
            </div> -->


		

		

	</article>
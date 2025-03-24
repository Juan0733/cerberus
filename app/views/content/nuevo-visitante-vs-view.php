

<div id="contenedor_nuevo_visitante">

    <form class="formulario-fetch" action="<?php echo APP_URL_BASE; ?>app/ajax/visitantes-ajax.php" method="post" >

        <input type="hidden" name="modulo_visitante" value="registrar">


        <article id="grupo_1"  class="grupo_formularios">

       
		<div class="fila_formularios">

             <div class="input-caja">
        
                    <label for="nombres_visitante">Nombre(s)</label>
                    <input type="text" class="campo" name="nombres_visitante" id="nombres_visitante" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚüÜ ]{1,64}" title="Debes digitar solo letras y minimo dos letras" placeholder="Ej: Oscar Alejandro" tabindex="1" required>
            </div>

            <div class="input-caja">
                        <label for="apellidos_visitante">Apellido(s)</label>
                        <input type="text" class="campo" name="apellidos_visitante" id="apellidos_visitante" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚüÜ ]{2,64}" title="Debes digitar solo letras y minimo dos letras" placeholder="Ej: Alvarez" tabindex="2" required>

            </div>



        </div>

        <div class="fila_formularios">

            <div class="input-caja">
            
                <label for="tipo_doc_visitante">Tipo de documento</label>
                <select class="campo"  name="tipo_doc_visitante" id="tipo_doc_visitante" tabindex="3" required>
                    <option value="" >Selecciona el tipo de documento.</option>
                    <option value="CC">Cedula</option>
                    <option value="TI">Tarjeta de identidad</option>
                    <option value="PS">Pasaporte</option>
                    <option value="OT">Otro</option>
                </select>

            </div>

          
                    <div class="input-caja">
                        <label for="num_documento_visitante">Numero de documento</label>
                        <input type="tel" class="campo" inputmode="numeric" name="num_documento_visitante" id="num_documento_visitante" pattern="[0-9]{6,15}" title="Debes digitar solo numeros y como minimo 6 numeros y maximo 10 numeros" placeholder="Ej: 123456" tabindex="4" required>
        
                </div>


        </div>
        <div class="contenedor_btn_continuar_formularios">
                 
					<button class="btn_enviar_form_formularios" id="btn_continuar">CONTINUAR</button>
                </div>

    </article>

    <article id="grupo_2" class="grupo_formularios">

            <div class="fila_formularios">
            <div class="input-caja">
        
        <label for="correo_visitante">Correo electronico</label>
        <input class="campo" type="email" name="correo_visitante" id="correo_visitante" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,3}" maxlength="88" minlength="6" placeholder="Ej: miCorreo@ejemplo.com" title="Lo que acabas de digitar no parece un correo electronico." tabindex="5" required>
    </div>
                    
              
                <div class="input-caja">
                        
                        <label for="telefono_visitante">Numero de telefono</label>
                        <input type="tel" class="campo" inputmode="numeric" name="telefono_visitante" id="telefono_visitante" pattern="[0-9]{10}" title="Debes digitar solo numeros y como minimo y maximo 10 numeros" placeholder="Ej: 3104444333" tabindex="6">
        
                </div>

            </div>
            <div class="fila_formularios">

                    <div class="input-caja">       
                        <label for="tipo_vehiculo_visitante">Tipo de vehiculo</label>
                        <select class="campo"  name="tipo_vehiculo_visitante" id="tipo_vehiculo_visitante" tabindex="7">
                            <option value="">Selecciona el tipo de vehiculo.</option>
                            <option value="AT">Atomovil</option>
                            <option value="BS">Bus</option>
                            <option value="CM">Camion</option>
                            <option value="MT">Moto</option>
                        </select>
                    </div>

                     <div class="input-caja">
                        
                        <label for="placa_vehiculo_visitante">Placa de vehiculo</label>
                        <input type="tel" class="campo"  name="placa_vehiculo_visitante" id="placa_vehiculo_visitante" pattern="[A-Z0-9]{5,}" title="Debes digitar solo numeros y letras mayusculas maximo 7 caracteres." placeholder="Ej: ABC123" tabindex="8">

                    </div>
            </div>
            <div  class="contenedor_btn" id="btn_enviar_media2">  
            <button class="btn_enviar_form_formularios" id="btn_anterior_formularios"><ion-icon name="arrow-back-outline" id="icono-atras"></ion-icon></button>

            <button type="submit" class="btn_enviar_form" id="btn_enviar_form_visitantes">
                Registrar 
                
            </button>
        </div>



    </article>


    </form>
</div>
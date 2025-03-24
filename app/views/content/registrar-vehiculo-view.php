
<?php

	const APP_URL_BASE2 = "http://localhost/Adso04/PROYECTOS/cerberus/";
?>

<div class="contenedor_form_vehiculo">
    <form class="formulario-fetch" action="<?php echo APP_URL_BASE2; ?>app/ajax/vehiculo-ajax.php" method="post" >
                <input type="hidden" name="modulo_vehiculo" value="registrar">
                
                <div class="input-caja">
                    
                    <label for="cargo_persona">Cargo persona</label>
                    <select class="campo"  name="cargo_persona" id="cargo_persona" tabindex="1">
                        <option value="">Seleccione el cargo de la persona.</option>
                        <option value="VS">Visitante</option>
                        <option value="FN">Funcionario</option>
                        <option value="VI">Vigilante</option>
                        <option value="AP">Aprendiz</option>
                    </select>
    
                </div>

                <div class="input-caja">
                    <label for="num_documento_visitante">Numero de documento</label>
                    <input type="tel" class="campo" inputmode="numeric" name="num_documento_visitante" id="num_documento_visitante" pattern="[0-9]{6,15}" title="Debes digitar solo numeros y como minimo 6 numeros y maximo 10 numeros" placeholder="Ej: 123456" tabindex="2">
                </div>

                <div class="input-caja">
                    
                    <label for="tipo_vehiculo_visitante">Tipo de vehiculo</label>
                    <select class="campo"  name="tipo_vehiculo_visitante" id="tipo_vehiculo_visitante" tabindex="3">
                        <option value="">Selecciona el tipo de vehiculo.</option>
                        <option value="AT">Atomovil</option>
                        <option value="BS">Bus</option>
                        <option value="CM">Camion</option>
                        <option value="MT">Moto</option>
                    </select>
    
                </div>
    
                <div class="input-caja">
                    
                    <label for="placa_vehiculo_visitante">Placa de vehiculo</label>
                    <input type="text" class="campo"  name="placa_vehiculo_visitante" id="placa_vehiculo_visitante" pattern="[A-Z0-9]{6,7}" title="Debes digitar solo numeros y letras mayusculas maximo 7 caracteres." placeholder="Ej: ABC123" tabindex="4">
    
                </div>
        
                <button type="submit" class="btn-enviar-form">Registrar Vehiculo</button>
    </form>

</div>
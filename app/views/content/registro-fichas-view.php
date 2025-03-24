<?php
    namespace app\view\content;
    use app\controllers\fichasController as fichasController;
    require_once "config/app.php";
	require_once "app/views/inc/session_start.php";
	require_once "autoload.php";
    require 'app/controllers/fichasController.php';
    $insAprendiz = new FichasController();
    $nombres_fichas = $insAprendiz->obtenerProgramasController();

    // Obtener la fecha de hoy
    $hoy = date("Y-m-d"); // Formato YYYY-MM-DD

    // Calcular la fecha máxima (sumar un mes)
    $fechaMaxima = date("Y-m-d", strtotime("+1 month"));
?>

<div class="contenedor">

    <form class="formulario-fetch" id="forma-ficha" name="forma-ficha" action="<?php echo APP_URL_BASE; ?>app/ajax/fichas-ajax.php" method="post">
        
        <input type="hidden" name="modulo_ficha" value="Registrar">

        <article id="grupo_1"  class="grupo_formularios">

            <div class="fila_formularios">
                <div class="input-caja">
                    <label for="nombre_programa_s">Nombre del Programa de Formacion<label>
                    <select class="campo" name="nombre_programa_s" id="nombre_programa_s" tabindex="1" required>
                        <option value="" hidden>Selecione el programa de formacion</option>
                        <?php
                            echo $nombres_fichas
                        ?>
                        <option value="otro">Otro</option>
                    </select>
                </div>

                <div class="input-caja" id="secundario" style="display:none;">
                    <label for="nombre_programa">Nombre del Programa de Formacion</label>
                    <input type="text" name="nombre_programa" id="nombre_programa" placeholder="Digite el nombre del programa de formacion" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ\s]{2,64}" minlength="2" maxlength="64" title="Parece que algo esta mal con el nombre, no se puede usar caracteres epsciales, solo puede ser de minimo 2 caracteres y maximo de 64" tabindex="2">
                </div>
            </div>

            <div class="contenedor_btn_continuar_formularios">
				<button class="btn_enviar_form_formularios" id="btn_continuar">CONTINUAR</button>
			</div>
    
        </article>

        
        <article id="grupo_2_formularios" class="grupo_formularios">

            <div class="fila_formularios">

                <div class="input-caja">
                    <label for="numero_ficha">Numero de ficha</label>
                    <input type="text" class="campo" name="numero_ficha" id="numero_ficha" placeholder="Digite el numero de ficha" pattern="[0-9]{7-9}" minlength="7" maxlength="9" title="Lo que digistaste no parece un numero de ficha, solo puede contener numeros entre 7 a 9 digitos" tabindex="3" required>
                </div>

            </div>

            <div class="fila_formulario">

                <div class="input-caja">
                    <label for="fecha_inicio">Selecciona la fecha de inicio de la ficha</label>
                    <input type="date" class="campo" id="fecha_inicio" name="fecha_inicio" min="<?php echo $hoy;?>" max="<?php echo $fechaMaxima;?>" tabindex="4" required>
                </div>

                <div class="input-caja">
                    <label for="fecha_fin">Selecciona la fecha de finalizacion de la ficha</label>
                    <input type="date" class="campo" id="fecha_fin" name="fecha_fin" tabindex="5" required>
                </div>

            </div>

			<div class="contenedor_btn" id="btn_enviar_media">
						<button class="btn_enviar_form_formularios" id="btn_anterior_formularios"><ion-icon name="arrow-back-outline" id="icono-atras"></ion-icon></button>

                        <button id="btn_enviar_form" type="submit" class="btn_enviar_form_formularios" name="registro" tabindex="11">Registrar</button>			
			</div> 


        </article>
    </form>
</div>

<script src="<?php echo APP_URL_BASE; ?>app/views/js/registro-ficha.js"></script>

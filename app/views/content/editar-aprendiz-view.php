<?php
use app\controllers\aprendizController;
$insAprendiz = new AprendizController();
$valores = $insAprendiz->obtenerAprendizController($url[1]);
?>

<div class="contenedor-editar-aprendiz">
    <form class="formulario-fetch" action="<?php echo APP_URL_BASE; ?>app/ajax/aprendiz-ajax.php" method="POST">

        <input type="hidden" name="modulo_aprendiz" value="editar_f">

        <div>

            <div>
                <input type="text" name="nombre_a" id="nombre_a" placeholder="Digite su(s) nombre(s)" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ\s]{2,64}" minlength="2" maxlength="64" title="Parece que algo esta mal con su(s) nombre(s), no se puede usar caracteres epsciales, solo puede ser de minimo 2 caracteres y maximo de 64" tabindex="1" required value="<?php echo $valores['nombres']; ?>">
            </div>

            <div>
                <input type="text" name="apellido_a" id="apellido_a" placeholder="Digite su(s) apellido(s)" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ\s]{2,64}" minlength="2" maxlength="64" title="Parece que algo esta mal con su(s) apellidos(s), no se puede usar caracteres epsciales, solo puede ser de minimo 2 caracteres y maximo de 64" tabindex="2" required value="<?php echo $valores['apellidos']; ?>">
            </div>
            
            <div>
                <select name="tipo_documento_a" id="tipo_documento_a" tabindex="3" required>
                    <option value="" hidden>Selecione tu tipo de documento</option>
                    <option value="TI">Tarjeta de identidad</option>
                    <option value="CC">Cedula de ciudadania</option>
                </select>
            </div>
            
            <div>
                <input type="number" name="numero_documento_a" id="numero_documento_a" placeholder="Digite su numero de documento" pattern="[0-9]{6-16}" minlength="6" maxlength="16" title="Parece que el numero de documento no es valido, solo puede contener numeros, solo puede ser de minimo 6 caracteres y maximo de 16" tabindex="4" required value="<?php echo $valores['num_identificacion']; ?>">
            </div>

            <div>
                <select name="numero_ficha" id="numero_ficha" tabindex="5">
                    <option value="">Selecione el programa de formacion</option>
                    <option value="2714805">2714805</option>
                    <option value="2721719">2721719</option>
                    <option value="2721813">2721813</option>
                </select>
            </div>
            
            <div>
                <input type="email" name="email_a" id="email_a" placeholder="Digite su correo electronico" pattern="[a-zA-Z0-9!#$%&'*\/=?^_`\{\|\}~\+\-]([\.]?[a-zA-Z0-9!#$%&'*\/=?^_`\{\|\}~\+\-])+@[a-zA-Z0-9]([^@&%$\/\(\)=?¿!\.,:;]|\d)+[a-zA-Z0-9][\.][a-zA-Z]{2,4}([\.][a-zA-Z]{2})?" minlength="8" maxlength="88" title="Lo que digistaste no parece un correo" tabindex="6" required value="<?php echo $valores['correo']; ?>">
            </div>

            <div>
                <input type="tel" name="numero_a" id="numero_a" placeholder="Digite su numero telefonico" pattern="[0-9]{10}" minlength="10" maxlength="10" title="El numero de telefono debe tener 10 caracteres" tabindex="7" required value="<?php echo $valores['telefono']; ?>">
            </div>

            <button type="submit" class="btn-enviar-form" tabindex="8">Actualizar Aprendiz</button>

        </div>

    </form>
</div>
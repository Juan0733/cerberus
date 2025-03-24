<?php

    use app\controllers\VisitanteController;

    $visitante = new VisitanteController();

    $datos_visitante = $visitante->seleccionarVisitante($url[1]);



?>

<div class="contenedor-nuevo-visitante">
    <form class="formulario-fetch" action="<?php echo APP_URL_BASE; ?>app/ajax/visitantes-ajax.php" method="post" >
    <script src="<?php echo APP_URL_BASE; ?>app/views/js/registro-vigilantes.js"></script>

        <input type="hidden" name="modulo_visitante" value="editar">
            <div class="contenedor_campos_obligatorios">

                <div class="grupo_1234" id="contenedor_campos">

                <article id="grupo_1"  class="grupo_formularios_editar">

                    <div class="fila_formularios"  >
                            <div class="input-caja">
                                
                                <label for="nombres_visitante">Nombre(s)</label>
                                <input type="text" class="campo" name="nombres_visitante" id="nombres_visitante" pattern="[A-Za-z ]{1,64}" title="Debes digitar solo letras y mínimo dos letras" placeholder="Ej: Oscar Alejandro" tabindex="1" value="<?php echo $datos_visitante['nombres']; ?> Ortiz" required >

                            </div>

                            <div class="input-caja">

                                <label for="tipo_doc_visitante">Tipo de documento</label>
                                <select class="campo"  name="tipo_doc_visitante" id="tipo_doc_visitante" tabindex="3" required>
                                    <option value="<?php echo $datos_visitante['tipo_documento']; ?>" ><?php echo $datos_visitante['tipo_documento']; ?></option>
                                    <option value="CC">Cédula</option>
                                    <option value="TI">Tarjeta de identidad</option>
                                    <option value="PS">Pasaporte</option>
                                    <option value="OT">Otro</option>
                                </select>

                            </div>
                     </div>
                     
                   

                     <div class="fila_formularios"  >
                     <div class="input-caja">
    
                            <label for="correo_visitante">Correo electrónico</label>
                            <input type="email" name="correo_visitante" id="correo_visitante" pattern="[a-zA-Z0-9!#$%&'\/=?^_`\{\|\}~\+\-]([\.]?[a-zA-Z0-9!#$%&'\/=?^_`\{\|\}~\+\-])+@[a-zA-Z0-9]([^@&%$\/\(\)=?¿!\.,:;]|\d)+[a-zA-Z0-9][\.][a-zA-Z]{2,4}([\.][a-zA-Z]{2})?" maxlength="88" minlength="6" placeholder="Ej: miCorreo@ejemplo.com" title="Lo que acabas de digitar no parece un correo electronico." value="<?php echo $datos_visitante['correo']; ?>" tabindex="5" required>

                        </div>


                        <div class="input-caja">
                            <label for="apellidos_visitante">Apellido(s)</label>
                            <input type="text" class="campo" name="apellidos_visitante" id="apellidos_visitante" pattern="[A-Za-z ]{2,64}" title="Debes digitar solo letras y minimo dos letras" placeholder="Ej: Alvarez" tabindex="2" value="<?php echo $datos_visitante['apellidos']; ?>" required>

                        </div>
                     </div>
                     <div class="contenedor_btn_continuar_formularios">
                 
                 <button class="btn_enviar_form_formularios" id="btn_continuar">CONTINUAR</button>
             </div>

                     </article>


                     <article id="grupo_2_formularios" class="grupo_formularios_editar">
                     <div class="fila_formularios"  > 
                            <div class="input-caja">
                                <label for="num_documento_visitante" id="num_documento_visitantelb">Número de documento</label>
                                <input type="tel" class="campo" inputmode="numeric" name="num_documento_visitante" id="num_documento_visitante" pattern="[0-9]{6,15}" title="Debes digitar solo numeros y como minimo 6 numeros y maximo 10 numeros" placeholder="Ej: 123456" value="<?php echo $datos_visitante['num_identificacion']; ?>" tabindex="4" >
                
                            </div>

                            <div class="input-caja">
                            
                                <label for="telefono_visitante" id="telefono_visitantelb">Número de teléfono</label>
                                <input type="tel" class="campo" inputmode="numeric" name="telefono_visitante" id="telefono_visitante" pattern="[0-9]{10}" title="Debes digitar solo numeros y como minimo y maximo 10 numeros" placeholder="Ej: 3104444333" value="<?php echo $datos_visitante['telefono']; ?>" tabindex="6" >
                
                            </div>


                     </div>
                     <div class="contenedor_btn" id="btn_enviar_media">
                     <button class="btn_enviar_form_formularios" id="btn_anterior_formularios"><ion-icon name="arrow-back-outline" id="icono-atras"></ion-icon></button>
                     </div>

              

            </div>

        </div>
        
        </article>


               
    </form>
    <article id=grupo_3>
        <div class="contenedor-campos-opcionales">
            
            <h1>Tabla de vehículos asociados al visitante</h1>
            
            <table>
                
                <thead>
                    <tr>
                        <th class=""># identificación</th>
                        <th class="">Tipo vehículo</th>
                        <th class="">Placa Vehículo</th>
                        <th class="">Estado</th>
                        <th class="">Actualizar</th>
                        <th class="">Eliminar</th>
                    </tr>
                </thead>
                <?php
                    echo $visitante->vehiculosVisitante($url[1]);
                ?>
            </table>
        </div>
        <button type="submit" class="btn-enviar-form">Registrar Visitante</button>
        </article>
</div>
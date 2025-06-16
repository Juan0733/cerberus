
<main id="gran_padre_regis_vs" name="gran_padre_regis_vs">
        <section id="contenedor_ppal_rg_vs">
            <header id="contenedor_titulo_form" name="contenedor_titulo_form">
                
                    
                    <div class="" id="cont_title" name="cont_title">
                        <h1 id="title_logo" name="title_logo">Registro Visitante</h1>
                        <h3 id="subtitle_logo" name="subtitle_logo">Bienvenido al CAB por favor registrate para ingresar</h3>
                    </div>
            </header>
            <div id="contenedor_formulario_regis_vs">
                <form  class="formulario-fetch" action="app/ajax/registro-vis.php" id="forma_acceso_02" method="post" >

                    <input type="hidden" name="modulo_visitante" value="registrar">
                      
                    <div id="caja_01_registro" class="rotado">
                        
                        <div class="input-caja-registro">
                            <label for="nombres_visitante" class="label-input">Nombre(s)</label>
                            <input type="text" class="campo validacion-campo" name="nombres_visitante" id="nombres_visitante" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚüÜ ]{1,64}" title="Debes digitar solo letras y minimo dos letras" placeholder="Ej: Oscar Alejandro" tabindex="1" date="Nombre(s)" required>
                        </div>

                        <div class="input-caja-registro">
                            <label for="apellidos_visitante" class="label-input">Apellido(s)</label>
                            <input type="text" class="campo validacion-campo" name="apellidos_visitante" id="apellidos_visitante" pattern="[A-Za-zñÑáéíóúÁÉÍÓÚüÜ ]{2,64}" title="Debes digitar solo letras y minimo dos letras" placeholder="Ej: Alvarez" tabindex="2" date="Apellido(s)" required>

                        </div>

                        <div class="input-caja-registro-registro">

                            <label for="correo_visitante" class="label-input">Correo electronico</label>
                            <input class="campo validacion-campo" type="email" name="correo_visitante" id="correo_visitante" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,3}" maxlength="88" minlength="6" placeholder="Ej: miCorreo@ejemplo.com" title="Lo que acabas de digitar no parece un correo electronico." tabindex="3" date="Correo electronico" required>
                        </div>
                    </div>
                    

                    <div id="caja_02_registro" class="rotado">

                        <div class="input-caja-registro">

                            <label for="tipo_doc_visitante" class="label-input">Tipo de documento</label>
                            <select class="campo validacion-campo"  name="tipo_doc_visitante" id="tipo_doc_visitante" tabindex="4" date="Tipo de documento" required>
                                <option value="" >Selecciona el tipo de documento.</option>
                                <option value="CC">Cedula</option>
                                <option value="TI">Tarjeta de identidad</option>
                                <option value="PS">Pasaporte</option>
                                <option value="OT">Otro</option>
                            </select>
                            
                        </div>

                        <div class="input-caja-registro">
                            <label for="num_documento_visitante" class="label-input">Numero de documento</label>
                            <input type="tel" class="campo validacion-campo" inputmode="numeric" name="num_documento_visitante" id="num_documento_visitante" pattern="[0-9]{6,15}" title="Debes digitar solo numeros y como minimo 6 numeros y maximo 10 numeros" placeholder="Ej: 123456" date="Numero de documento" tabindex="5" >
                            
                        </div>

                        <div class="input-caja-registro">
                            
                            <label for="telefono_visitante" class="label-input">Numero de telefono</label>
                            <input type="tel" class="campo validacion-campo" inputmode="numeric" name="telefono_visitante" id="telefono_visitante" pattern="[0-9]{10}" title="Debes digitar solo numeros y como minimo y maximo 10 numeros" placeholder="Ej: 3104444333" date="Numero de telefono" tabindex="6" >

                        </div>
                    </div>
                    <div id="cont_btn_form_regis_visi">
                        <button type="button" id="btn_atras"  onclick="volverCampos()">
                            <ion-icon name="chevron-back-outline"></ion-icon>
                            
                        </button>
                        <button type="button" id="btn-siguiente" onclick="motrarCampos()">Siguiente</button>
                        <button type="submit" id="btn_registrarme">Registrarme</button>
                    </div>
                </form>

            </div>

        </section>
    </main>
    
    <script src="app/views/js/registro-visitante.js"></script>

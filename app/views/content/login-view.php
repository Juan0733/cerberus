    <input type="hidden" id="url_base" value="<?php echo $urlBaseVariable; ?>">
    <main id="gran_padre" name="gran_padre">
        <section id="cont_login">
            <header id="cont_logo" name="cont_logo">
                
                    <figure id="logo">
                        <img src="app/views/img/logo-sena-verde-png-sin-fondo.webp" alt="">
                    </figure>
                    <div class="" id="cont_title" name="cont_title">
                        <h1 id="title_logo" name="title_logo">Cerberus</h1>
                        <h3 id="subtitle_logo" name="subtitle_logo">Analisis y Desarrollo de Software 2714805</h3>
                    </div>
            </header>
            <div id="contenedor_formulario">
                <form  action="" method="post" id="forma_acceso" enctype="application/x-www-form-urlencoded">

                    <div id="caja_01" class="rotado">
                        <label for="" class="label-input">Numero de identificacion</label>
                        <input type="text" class="campo" inputmode="number" name="num_id_usuario" id="num_id_usuario" placeholder="# Identificacion">

                    </div>
                    

                    <div id="caja_02" class="rotado">
                        
                        <label for="" class="label-input">Contraseña</label>
                        <input type="password" class="campo" name="psw_usuario" id="psw_usuario" pattern="[a-zA-Z0-9]{6,15}" placeholder="Contraseña">
                    </div>
                    
                    <button type="submit">ENTRAR</button>
                </form>

            </div>

        </section>
    </main>
    


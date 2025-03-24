    
  
  
<div class="contenedor-listados">

<nav class="nav_gestion_listado">
  <div id="cont_opciones_listado">
    
        <div class="filtro">
          <label for="num_registros">Ver</label>
          <div class="cont_select">
            <select name="num_registros" id="num_registros" class="form-select">
              <option value="5">5</option>
              <option value="10">10</option>
              <option value="15">15</option>
            </select>
          </div>
          <label for="num_registros">Registros</label>
        </div>

        <div class="cont_buscar_persona">
          <div class="buscar">
            <ion-icon name="search-outline"></ion-icon>
            <input type="text" name="filtro" id="filtro" placeholder="Buscar Persona">
            <input type="hidden" id="url" value="<?php echo APP_URL_BASE;?>/app/ajax/aprendiz-ajax.php" >
          </div>

        </div>

 
  </div>


</nav>


<div id="contenedor_tabla">

</div>

</div>




<script src="<?php echo APP_URL_BASE; ?>app/views/js/listado-aprendices.js"></script>












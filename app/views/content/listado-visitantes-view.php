    
  
  
<div class="contenedor-listados  listado-visitantes">

  <nav class="nav_gestion_listado">
    <div id="cont_opciones_listado">
      
          <div class="filtro">
            <label for="num_registros">Ver</label>
            <div class="cont_select">
              <select name="num_registros" id="num_registros" class="form-select">
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
              </select>
            </div>
            <label for="num_registros">Registros</label>
          </div>

          <div class="cont_buscar_persona">
            <div class="buscar">
              <ion-icon name="search-outline"></ion-icon>
              <input type="text" name="filtro" id="filtro" placeholder="Buscar Persona">
              <input type="hidden" id="url" value="<?php echo APP_URL_BASE;?>/app/ajax/visitantes-ajax.php" >
            </div>
            
            <a id="btn_link_registrar_vis" class="btn-nueva-persona" onclick="mostrarModalNuevoVisi()" >
              <ion-icon name="person-add-outline"></ion-icon>
              Nuevo Visitante
            </a>
            
            <a id="btn_link_registrar_vis-02" class="btn-nueva-persona-mobile"  onclick="mostrarModalNuevoVisi()">
              <ion-icon name="person-add-outline"></ion-icon>
            </a>
          </div>

   
    </div>


  </nav>

  
  <div id="contenedor_tabla">

  </div>

</div>




<script src="<?php echo APP_URL_BASE; ?>app/views/js/listado-visitantes.js"></script>












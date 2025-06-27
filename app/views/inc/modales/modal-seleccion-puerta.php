<div class="contenedor-titulo-modal">
    <h2 class="titulo-modal">Seleccionar Puerta</h2>
    <ion-icon name="close-outline" id="cerrar_modal_puerta" class="close-btn"></ion-icon>
</div>
<div class="contenedor-info-modal">
    <div id="cont_info_modales">
        <form id="formulario_puerta" method="POST">
            <div id="contenedor_cajas_puerta">
                <div class="caja-checkbox">
                    <ion-icon id="icono_puerta_peatonal" name="walk" class="icono-puerta"></ion-icon>
                    <input type="checkbox" class="checkbox-puerta" id="peatonal" name="peatonal" value="PEATONAL">
                    <label for="peatonal" class="label-input">Peatonal</label>
                </div>
                    
                <div class="caja-checkbox">
                    <ion-icon id='icono_puerta_principal' name="car" class=" icono-puerta"></ion-icon>
                    <input type="checkbox" class="checkbox-puerta" id="principal" name="principal" value="PRINCIPAL">
                    <label for="principal" class="label-input">Vehicular Principal</label>
                </div>

                <div class="caja-checkbox">
                    <ion-icon id='icono_puerta_ganaderia' name="car" class="icono-puerta"></ion-icon>
                    <input type="checkbox" class="checkbox-puerta" id="ganaderia" name="ganaderia" value="GANADERIA">
                    <label for="ganaderia" class="label-input">Vehicular Ganadería</label>
                </div>
            </div>

            <div id="contenedor_btns_puerta">
                <button type="button" id="btn_cancelar_puerta">Cancelar</button>
                <button type="submit" id="btn_guardar_puerta">Guardar</button>
            </div>
        </form>
        
    </div>
</div>
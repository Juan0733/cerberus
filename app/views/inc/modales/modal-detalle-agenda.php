<div class="contenedor-titulo-modal">
    <h2 id="titulo" class="titulo-modal"></h2>
    <ion-icon name="close-outline" id="cerrar_modal_detalle_agenda" class="close-btn"></ion-icon>
</div>
<div class="contenedor-info-modal">
    <div id="cont_info_modales">
        <div id="contenedor_agendados">
            <h3>Agendados:</h3>
            <div id="contenedor_tabla">
                <table id="tabla_agendados">
                    <thead>
                        <tr>
                            <th>Cantidad</th>
                            <th>Nombres</th>
                            <th>apellidos</th>
                        </tr>
                    </thead>
                    <tbody id="cuerpo_tabla_agendados" class="body_tabla_pasajeros">
                    </tbody>
                </table>
            </div>
        </div>

        <div id="contenedor_cajas">
            <div class="caja">
                <h3>Fecha Agenda:</h3>
                <p id="fecha_agenda"></p>
            </div>
        
            <div class="caja">
                <h3>Responsable Agenda:</h3>
                <p id="responsable_registro"></p>
            </div>
            
            <div class="caja">
                <h3>Motivo:</h3>
                <p id="motivo"></p>
            </div>
        </div>
    </div>
</div>
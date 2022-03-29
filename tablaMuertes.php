<button class="btn btn-secondary" id="filtrosM" style="margin: 10px 0;"><b>Filtros</b> <span class="icon-filter"></span></button>

<div id="contFiltrosM">
    
    <div class="row-fluid" style="margin-bottom: 10px;">

        <div class="span2">
            <b style="font-size: .8em;">Desde:</b>
            <input type="date" id="desdeM">
        </div> 

        <div class="span2">
            <b style="font-size: .8em;">Hasta:</b>
            <input type="date" id="hastaM">
        </div>

        <div class="span1">
            <b style="font-size: .8em;"><span class="icon-arrow-up"></span>&nbsp;&nbsp;<span class="icon-arrow-down"></span></b><br>
            <input type="radio" name="ordenM" id="ordenAsc" value="ASC" checked>&nbsp;&nbsp;
            <input type="radio" name="ordenM" id="ordenDesc" value="DESC">
        </div>

        <div class="span2">
        
            <b style="font-size: .8em;">Causa:</b>
 
           <select id="causa" class="input-medium">
                <option value="">Causa de Muerte</option>
                <option value="">Otro</option>
            </select>

        </div>

        <br>

        <button id="filtrarEgr" class="btn btn-secondary" onclick="filtrarM()"><b>Filtrar</b></button>

        <button id="reset" class="btn btn-secondary" onclick="reset('Muertes')"><b>Reset</b></button>
        
    </div>

    <br>


</div>
    
<div id="contenedorMuertes"></div>

<div id="myTableMuertes">

    <table class="table table-striped" style="box-shadow:0px 7px 6px 0px #cbcbcb">
        
        <thead style="border-top:3px solid #fde327;border-bottom:3px solid #fde327";>
            <tr>
            <th scope="col">Fecha Muerte</th>
            <th scope="col">Origen</th>
            <th scope="col">Proveedor</th>
            <!-- <th scope="col">Cantidad</th> -->
            <th scope="col">Causa Muerte</th>
            <td scope="col"></td>
            <td scope="col"></td>
            </tr>
        </thead>

        <tbody id="paginadoMuertes">
            <script>
            cargaMuertes();
            </script>
        </tbody>
        
    </table>

    <div class="pagination pagination-mini pagination-centered">

        <ul>
        <?php
        echo paginador('muertes',$feedlot,$conexion);
        ?>
        </ul>

    </div>

</div>

<div class="modal fade" style="top:100px;z-index:99!important;" id="modalEditarCausa" tabindex="-1" role="dialog" aria-labelledby="modalEditarCausa" aria-hidden="true">

    <div class="modal-dialog" style="width:auto;" role="document">

    <div class="modal-content">

        <div class="modal-header">

            <h2 class="modal-title">Editar Causa</h2>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>

        </div>

        <div class="modal-body">

            <div class="row-fluid">
                
                <div class="span12">
                    
                    <div class="control-group"> 
                    
                        <label class="control-label" style="font-size:1.1em;"><b>Causa de Muerte:</b></label>
                    
                        <div class="controls">
                    
                            <select id="causaMuerteEdit" class="form-control input-large">
                        
                                <option value="">Seleccionar Causa Muerte</option>
                        
                                <option value="Accidente">Accidente</option>
                        
                                <option value="Digestivo">Digestivo</option>
                        
                                <option value="Ingreso">Ingreso</option>
                        
                                <option value="Nervioso">Nervioso</option>
                        
                                <option value="Rechazo">Rechazo</option>
                        
                                <option value="Respiratorio">Respiratorio</option>
                        
                                <option value="Sin Diagnostico">Sin Diagnostico</option>
                        
                                <option value="Sin Hallazgo">Sin Hallazgo</option>
                        
                                <option value="Otro">Otro</option>
                        
                            </select>
                        
                        </div>
                    
                    </div>           
                    
                </div>

            </div>

            <div class="row-fluid">
            
                <div class="span12">

                    <div class="control-group"> 
                                            
                        <div class="controls">
                    
                            <button class="btn btn-primary" id="btnEditarCausa" idMuerte="">Editar Causa</button>
            
                        </div>
                    
                    </div>        

                </div>

            </div>

        </div>

    </div>

    </div>

</div>
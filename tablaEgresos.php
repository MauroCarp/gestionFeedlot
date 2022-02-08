<div class="row-fluid">

    <div class="span12">

        <button class="btn btn-secondary" id="filtrosEgr" style="margin: 10px 0;"><b>Filtros</b> <span class="icon-filter"></span></button>

        <div id="contFiltrosEgr">

            <div class="row-fluid" style="margin-bottom: 10px;">

                <div class="span2">

                    <b style="font-size: .8em;">Desde:</b><input type="date" id="desdeEgr">
                
                </div> 
               
                <div class="span2">

                    <b style="font-size: .8em;">Hasta:</b><input type="date" id="hastaEgr">
                
                </div>
               
                <div class="span1">

                    <b style="font-size: .8em;"><span class="icon-arrow-up"></span>&nbsp;&nbsp;<span class="icon-arrow-down"></span></b><br>
                    <input type="radio" name="ordenEgr" id="ordenAsc" value="ASC" checked>&nbsp;&nbsp;<input type="radio" name="ordenEgr" id="ordenDesc" value="DESC">
                
                </div>
               
                <div class="span2">

                    <b style="font-size: .8em;">Destino:</b>
                    
                    <select id="destino" class="input-medium">
                    
                        <option value="">Seleccione Destino</option>
                        <?php
                        
                        $sqlDestino = "SELECT DISTINCT destino FROM egresos ORDER BY destino ASC";

                        if($feedlot == 'Acopiadora Pampeana'){
            
                            $sqlDestino = "SELECT DISTINCT destino FROM registroegresos ORDER BY destino ASC";
                        
                        }

                        $queryDestino = mysqli_query($conexion,$sqlDestino);
                        $destinos = array();
                        $destinoTemp = "";
                        while ($destino = mysqli_fetch_array($queryDestino)) {
                            if ($destinoTemp != $destino['destino']) {
                            $destinos[] = $destino['destino'];
                            }
                            $destinoTemp = $destino['destino'];
                        }
                        for ($i=0; $i < sizeof($destinos) ; $i++) { ?>
                            <option value="<?php echo $destinos[$i];?>"><?php echo strtoupper($destinos[$i]);?></option>  
                        <?php
                        }
                        ?>

                    </select>

                </div>
               
                <div class="span1">

                    <br><button id="filtrarEgr" class="btn btn-secondary" onclick="filtrarEgr()"><b>Filtrar</b></button>

                </div>
               
                <div class="span1">

                    <br><button id="reset" class="btn btn-secondary" onclick="reset('Egresos')"><b>Reset</b></button>

                </div>

            </div>

        </div>   

        <div id="contenedorEgresos"></div>
                    
        <table class="table table-striped" style="box-shadow:0px 7px 6px 0px #cbcbcb">
        
            <thead style="border-top:3px solid #fde327;border-bottom:3px solid #fde327";>
                <tr>
                <th>Fecha Egreso</th>
                <th>Cantidad</th>
                <th>Peso Prom.</th>
                <th>GMD Prom</th>
                <th>GPV Prom</th>
                <td></td>
                <td></td>
                </tr>
            </thead>

            <tbody id="paginadoEgr">

                <script>
                    cargaEgresos();
                </script>

            </tbody>

        </table>

        <div class="pagination pagination-mini pagination-centered">

            <ul>
                <?php
                echo paginador('registroegresos',$feedlot,$conexion);
                ?>
            </ul>

        </div>

    </div>

</div>
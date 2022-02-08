<div class="row-fluid">

    <div class="span12">
        
        <button class="btn btn-secondary" id="filtrosIng" style="margin: 10px 0;"><b>Filtros</b> <span class="icon-filter"></span></button>

        <div id="contFiltrosIng">

            <div class="row-fluid">

                <div class="span2">

                    <b style="font-size: .8em;">Desde:</b>

                    <input type="date" id="desde">

                </div> 

                <div class="span2">

                    <b style="font-size: .8em;">Hasta:</b>

                    <input type="date" id="hasta">

                </div>

                <div class="span1">

                    <b style="font-size: .8em;"><span class="icon-arrow-up"></span>&nbsp;&nbsp;<span class="icon-arrow-down"></span></b><br>

                    <input type="radio" name="orden" id="ordenAsc" value="ASC" checked>&nbsp;&nbsp;<input type="radio" name="orden" id="ordenDesc" value="DESC">

                </div>

                <div class="span1">

                    <b style="font-size: .8em;">Renspa:</b>

                    <input type="text" id="renspa" class="input-mini" placeholder="R.E.N.S.P.A">

                </div>

                <div class="span2">

                    <b style="font-size: .8em;">Estado:</b>

                    <select id="estado" class="input-medium">

                        <option value="">Seleccione Estado</option>

                        <?php

                        $sqlEstado = "SELECT DISTINCT estado FROM ingresos ORDER BY estado ASC";

                        if($feedlot == 'Supermercado Rural'){

                            $sqlEstado = "SELECT DISTINCT estado FROM registroingresos ORDER BY estado ASC";

                        }

                        $queryEstado = mysqli_query($conexion,$sqlEstado);

                        $estados = array();

                        $estadoTemp = "";

                        while ($estado = mysqli_fetch_array($queryEstado)) {

                            if ($estadoTemp != $estado['estado']) {

                                $estados[] = $estado['estado'];

                            }

                            $estadoTemp = $estado['estado'];

                        }

                        for ($i=0; $i < sizeof($estados) ; $i++) { ?>

                            <option value="<?php echo $estados[$i];?>"><?php echo strtoupper($estados[$i]);?></option>  

                        <?php

                        }

                        ?>

                    </select>

                </div>

                <div class="span2">

                    <b style="font-size: .8em;">Proveedor:</b>

                    <select id="proveedor" class="input-medium">

                        <option value="">Seleccione Proveedor</option>

                        <?php



                        $sqlProveedor = "SELECT DISTINCT proveedor FROM ingresos ORDER BY proveedor ASC";



                        if($feedlot == 'Acopiadora Pampeana'){



                        $sqlProveedor = "SELECT DISTINCT proveedor FROM registroingresos ORDER BY proveedor ASC";

                        

                        }

                        $queryProveedor = mysqli_query($conexion,$sqlProveedor);

                        $proveedores = array();

                        $proveedorTemp = "";

                        while ($proveedor = mysqli_fetch_array($queryProveedor)) {

                            if ($proveedorTemp != $proveedor['proveedor']) {

                                $proveedores[] = $proveedor['proveedor'];

                            }

                            $proveedorTemp = $proveedor['proveedor'];

                        }

                        for ($i=0; $i < sizeof($proveedores) ; $i++) { ?>

                            <option value="<?php echo $proveedores[$i];?>"><?php echo strtoupper($proveedores[$i]);?></option>  

                        <?php

                        }

                        ?>

                    </select>

                </div>

                
                <div class="span1">

                    <b style="font-size: .8em;">Min:</b>

                    <input type="number" id="pesoMin" class="input-mini" value="0">

                </div>
                
                <div class="span1">

                    <b style="font-size: .8em;">Max:</b>

                    <input type="number" id="pesoMax" class="input-mini" value="0">

                </div>
            
            </div>

            <div class="row-fluid" style="margin-bottom: 10px;">

                <div class="span1">

                    <button id="filtrar" class="btn btn-secondary" onclick="filtrarIng()"><b>Filtrar</b></button>

                </div>

                <div class="span1">

                    <button id="reset" class="btn btn-secondary" onclick="reset('Ingresos')"><b>Reset</b></button>

                </div>

            </div>

        </div>

        <div id="contenedorIngresos"></div>

        <div id="myTableIngresos">

            <table class="table table-striped" style="box-shadow:0px 7px 6px 0px #cbcbcb">

                <thead style="border-top:3px solid #fde327;border-bottom:3px solid #fde327";>

                    <tr>

                        <th scope="col" style="text-align: center;">Tropa</th>

                        <th scope="col">Ingreso</th>

                        <th scope="col">Cantidad</th>

                        <th scope="col" style="width:100px;">Peso Prom.</th>

                        <th scope="col">Renspa</th>

                        <th scope="col">ADPV</th>

                        <th scope="col">Estado</th>

                        <th scope="col">Proveedor</th>

                        <td scope="col" class="sorter-false"><b>Stock</b></td>

                        <td scope="col"></td>

                        <td scope="col"></td>

                    </tr>

                </thead>

                <tbody id="paginadoIng">

                    <script>

                    cargaIngresos();

                    </script>

                </tbody>

            </table> 

            <div class="pagination pagination-mini pagination-centered">

                <ul>

                    <?php

                    echo paginador('registroingresos',$feedlot,$conexion);

                    ?>

                </ul>

            </div>

        </div>        
                
    </div>

</div>
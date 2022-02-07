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

    <table class="table table-striped" style="box-shadow: 1px -2px 15px 1px;">
        
        <thead style="border-top:3px solid #fde327;border-bottom:3px solid #fde327";>
            <tr>
            <th scope="col">Fecha Muerte</th>
            <th scope="col">Cantidad</th>
            <th scope="col">Causa Muerte</th>
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
        echo paginador('registromuertes',$feedlot,$conexion);
        ?>
        </ul>

    </div>

</div>
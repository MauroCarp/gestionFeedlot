function cargarPrecioInsumoPremix(idInsumo,idCampo){

    var contadorId = idCampo.substr(9);

    var data = 'idInsumo=' + idInsumo; 

    var url = 'ajax/insumoPremix.ajax.php';

    
    $.ajax({
        data: data,
        url: url,
        type: 'POST',
        success:function(respuesta){
            console.log(respuesta);
            
            $('#precioPre' + contadorId).val(respuesta)
        }

    });

    $('#kilosPre' + contadorId).removeAttr('readonly');

}

function calcularPorcentajes(){

    var totalKilos = 0;

    $('.kilosPre').each(function(){

        var value = parseFloat($(this).val());

        totalKilos += value;

    });

   
    
    $('.totalPorcePre').each(function(){

        var id = $(this).attr('id').substr(13);

        var kilos = parseFloat($('#kilosPre' + id).val());
                
        var porcentaje = ((kilos * 100) / totalKilos);
        
        $(this).val(porcentaje.toFixed(2));

    });


}

function calcularPrecioKilo(value,idCampo){
    
    var contadorId = idCampo.substr(8);

    var precio = $('#precioPre' + contadorId).val();
    
    var precioKilos = precio * value;
    
    $('#precioKilosPre' + contadorId).val(precioKilos);    

    var totalKilos = 0;

    var precioTotal = 0;

    var porceTotal = 0;

    $('.kilosPre').each(function(){

        var value = parseFloat($(this).val());

        totalKilos += value;

    });
    
    $('#kilosTotales').val(totalKilos.toFixed(2) + ' Kg');

    $('.preciosKilosPre').each(function(){

        var value = parseFloat($(this).val());

        precioTotal += value;
        
    });

    $('#precioTotal').val('$' + precioTotal);

    calcularPorcentajes();

    $('.totalPorcePre').each(function(){

        var value = parseFloat($(this).val());

        porceTotal += value;
        
    });

    $('#porceTotal').val(Math.round(porceTotal) + ' %');
    
}

function cargarSelectInsumos(contador){

    var url = 'ajax/cargarSelectPremix.ajax.php';

    $.ajax({
        url:url,
        success:function(resultado){

            $('#insumoPre' + contador).append(resultado);
        
        }
    });
}


function eliminarInsumo(id){

    var idContador = id.substr(14);

    $('.insumoPre' + idContador).remove();

    actualizarValores();
    
}


function calcularPorcentajeModal(id){

    var totalKilos = 0;

    var arrayKilos = [];
    $('.kilos' + id).each(function(){
        
        var kilos = parseFloat($(this).text());

        arrayKilos.push(kilos);
        
        totalKilos += kilos;

    });

    var contador = 0;

    var totalPorcentaje = 0;

    $('.porcentaje' + id).each(function(){
        
        var porcentaje = ((arrayKilos[contador] * 100) / totalKilos);

        totalPorcentaje += porcentaje;

        $(this).html(porcentaje.toFixed(2));

        contador++;

    });

    $('#porcentajeTotal' + id).html(totalPorcentaje.toFixed(2) + ' %');
    
}

function imprimirPremix(id){
    
    var url = "imprimir/premix.php?id=" + id;

    window.open(url , '_blank');
  
}

function actualizarValores(){

    
    $('.select-insumos').each(function(){

      var valor = $(this).val();

      var id = $(this).attr('id');

      var contador = id.substr(9);
      
      cargarPrecioInsumoPremix(valor,id);    

      var idKg = 'kilosPre' + contador;

      var valorKilos = parseFloat($('#kilosPre' + contador).val());

      setTimeout(() => {
        
        calcularPrecioKilo(valorKilos,idKg);

      }, 500);

      
    });
  
  }

var contador = 1;

$('#btnAgregarInsumo').click(()=>{
    
    var div = '<div class="row-fluid insumoPre' + contador + '">';
        
    div +=   '<div class="span3 ">';
        
        div +=      '<select class="form-control select-insumos input-medium" name="insumoPre' + contador + '" id="insumoPre' + contador + '" onchange="cargarPrecioInsumoPremix(this.value,this.id);">';
       
        div +=          '<option value="">Seleccionar Insumo</option>';
        
        div +=      '</select>';
     
        div +=   '</div>';
        
        div +=   '<div class="span2">';
       
        div +=      '<input type="text"  class="form-control input-small kilosPre" style="font-weight: bold" value="0" id="kilosPre' + contador + '" name="kilosPre' + contador + '" onchange="calcularPrecioKilo(this.value,this.id)" readonly>';
      
        div +=   '</div>';
       
        div +=   '<div class="span2">';
     
        div +=      '<input type="text" class="form-control input-small preciosPre" id="precioPre' + contador + '" name="precioPre" value="0" disabled="true" required/>';
      
        div +=   '</div>';
    
        div +=   '<div class="span2">';
       
        div +=      '<input type="text" class="form-control input-small preciosKilosPre" id="precioKilosPre' + contador + '" name="precioKilosPre" value="0" disabled="true"/>';
      
        div +=   '</div>';
      
        
        div +=   '<div class="span2">';

        div +=      '<input type="text" class="form-control input-small totalPorcePre" id="totalPorcePre' + contador + '" name="totalPorcePre" value="0" disabled="true"/>';

        div +=   '</div>';

        div +=   '<div class="span1">';

        div +=      '<i class="icon-bin2" style="cursor:pointer" id="eliminarInsumo' + contador + '" onclick="eliminarInsumo(this.id)"></i>';

        div +=   '</div>';
        
        div +='</div>';

        $('.contenedor-insumoPre').append(div);

        cargarSelectInsumos(contador);

        contador++;


});



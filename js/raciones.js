function calcularPrecioPorcentaje(precioTC,porcentajeTC){
    let precioPorcentaje = (porcentajeTC * precioTC) / 100;
	return precioPorcentaje;
}

function eliminarProducto(producto){
  $('.' + producto).remove();
  var totalPorcentaje = 0;
  $('.porcentajes').each(function(){
    totalPorcentaje += parseFloat($(this).val());
  });
  //totalPorcentaje += parseFloat($('#porcentajeAgua').val());
  $('#totalPorcentaje').val(totalPorcentaje); 
}

function calculoPorTotal(){
	var totalPorcentaje;
	totalPorcentaje = 0;
	$('.porcentajes').each(function(){
	totalPorcentaje += parseFloat($(this).val());
	})
	//totalPorcentaje += parseFloat($('#porcentajeAgua').val());
return totalPorcentaje;
}


function controlCero(id){

      // SI EL INPUT ESTA VACIO SE PONE EN CERO
      if ($('#' + id).val() == ''){
          $('#' + id).val(0);
        }


      /// SE CALCULA EL PORCENTAJE TOTAL   
      var totalPorcentaje = calculoPorTotal();
      $('#totalPorcentaje').val(totalPorcentaje);


      ///CARGAR PRECIO PORCENTAJE
      var porcentaje;
      var contador;
      var precioTC;
      var precioPor;

      porcentaje = $('#' + id).val(); 

      console.log('PORCENTAJE' + porcentaje);

      contador = id.substring(10,12);

      precioTC = $('#precio' + contador + ' input[name=precioTC]').val();

      console.log('PRECIO TC'+ precioTC);

      precioPor = ((porcentaje*precioTC)/100);

      precioPor = precioPor.toFixed(2);

      console.log('PRECIO %'+ precioPor);
      
      $('#precioPor' + contador).val(precioPor);

      $('#porcentajeTC' + contador).val(porcentaje);

      // SI EL PORCENTAJE TOTAL SE EXEDE DEL 100% SE AVISA
      if (totalPorcentaje > 100) {
        $('.botonCarga').attr('disabled',true);
        alert("Los porcentajes suman un total mayor a 100%");
      }

      if (totalPorcentaje < 100) {
        $('.botonCarga').attr('disabled',true);
        console.log('menor TRUE');
      }

      if (totalPorcentaje === 100) {
        $('.botonCarga').attr('disabled',false);
        console.log('igual TRUE');
      }
      
}

var contadorInsumo;
function CargarProductos(val,id){
  contadorInsumo = id.substring(8,12);
  var precio = '#precio' + contadorInsumo;
    $.ajax({
        type: "POST",
        url: 'consulta.php',
        data: 'insumo='+val,
        success: function(resp){
            $(precio).html(resp);
        }
    });

    if (val != "") {
      $('#porcentaje' + contadorInsumo).attr('disabled',false);
    }else{
      $('#porcentaje' + contadorInsumo).attr('disabled',true);
    } 
}

var contadorPrecio;
function CargarPrecio(val,id){
  var porcentaje;
  porcentaje = val;
  contadorPrecio = id.substring(10,11);
  var idPrecio;
  idPrecio = 'precio' + contadorPrecio;
  var precioTC;
  precioTC = $('#' + idPrecio + ' input[name=precioTC]').val();
  var resultadoPorcentaje = (porcentaje*precioTC)/100;
  idPrecioPor = '#precioPor' + contadorPrecio;
  $(idPrecioPor).val(resultadoPorcentaje.toFixed(2));
}

function cambiarPorcentajes(val){
	var agua;
	var porcentajeDividido;
	agua = val;
	var cantElementos = document.getElementsByClassName("select-insumos").length;
	porcentajeDividido = agua / cantElementos;
	$(".porcentajes").each(
	function(index, value) {
	  importe_total = (eval($(this).val() - porcentajeDividido));
	  $(this).val(importe_total.toFixed(2));
	}
	);


	var porcentajeFinal;
	var precioTalCual;
	var cont;
	cont = 0;

	$(".porcentajes").each(function(index,value) {
	precioTalCual = $('#precio' + cont + ' input[name=precioTC]').val();
	importePorcentaje = (eval(($(this).val() * precioTalCual) / 100));
	idPrecioPor = '#precioPor' + cont;
	$(idPrecioPor).val(importePorcentaje.toFixed(2));
	cont++;
	}
	);

	if ($('#porcentajeAgua').val() == ''){
	  $('#porcentajeAgua').val(0);
	}

	var totalPorcentaje = calculoPorTotal();
	$('#totalPorcentaje').val(totalPorcentaje);
}

function calcular_total() {
	importe_total = 0
	$(".importe_linea").each(
	function(index, value) {
		importe_total = importe_total + eval($(this).val());
	});

	$("#total").val(importe_total.toFixed(2));
}

function resetear(){
  $(".porcentajes").val(0);
  $(".porcentajesTC").val(0);
  $("#porcentajeAgua").val(0);
  $("#porcentajeAguaTC").val(0);
  $(".importe_linea").val(0);
  $('#totalPorcentaje').val(0);
}

function cargarMS(id){
 
      var contador = 0;
      var totalMS = 0;
      var precioPor = 0;
      var porcentajeMS = 0;
      var precioMS = 0;

        $(".precioPorc" + id).each(function(){

          precioPor = $(this).text();

          precioPor = $.trim(precioPor);

          precioPor = parseFloat(precioPor.substring(2));

          porcentajeMS = $(".porcMS" + id + "_" + contador).text();

          porcentajeMS = $.trim(porcentajeMS);

          porcentajeMS = parseFloat(porcentajeMS.substring(0,2));

          
          precioMS = ((100 * precioPor) / porcentajeMS);
          contador++;
        });


        var totalPMS = 0; 

        var pMS = 0;

        $(".totalMS" + id).each(function(){
          pMS = $(this).text();
          pMS = $.trim(pMS);
          pMS = parseFloat(pMS.substring(0,5).replace(",","."));
          totalPMS += pMS;
        });

          precioKilo = $("#precioKilo" + id).text();
          precioKilo = parseFloat(precioKilo.replace(',','.'));
          totalMS = (100 * precioKilo) / totalPMS;
          $("#precioMS" + id).text(totalMS.toFixed(2).replace(".",","));
          $("#totalPorMS" + id).text(totalPMS.toFixed(2).replace(".",","));


          $(".zindex-" + id).css('z-index','1');
}

function zindexModal(id){
    $(".zindex-" + id).css('z-index','1');
}

function modalFormula(id){
          $("#openModal" + id).show(0);
          var kilosTotal = 0;
          var kilos;
          var contador = 1;
          $(".kilosMS" + id).each(function(){
            kilos = $(this).text();
            kilos = $.trim(kilos);
            kilos = parseFloat(kilos.substring(0,6));
            kilosTotal += kilos;
          })

          var porcentajeMS;
          var totalPorceMS = 0;

          $(".kilosMS" + id).each(function(){
            kilos = $(this).text();
            kilos = $.trim(kilos);
            kilos = parseFloat(kilos.substring(0,6));

            porcentajeMS = (kilos*100) / kilosTotal;
            totalPorceMS += porcentajeMS;
            $("#totalPorcMS" + id + "_" + contador).text(porcentajeMS.toFixed(2) + " %");
            contador++;
          })

          var totalCantPor = 0;
          var totalCantKilos = 0;
          var totalDietaFinal = 0;
          var totalKilosMS = 0;
          var totalPorceTC = 0;

          $(".cantPorc" + id).each(function(){
            porcentaje = $(this).text();
            porcentaje = parseFloat(porcentaje.replace("%",""));
            totalCantPor += porcentaje;
          })

          $(".porceTC" + id).each(function(){
            porcentajeTC = $(this).text();
            porcentajeTC = parseFloat(porcentajeTC.replace("%",""));
            totalPorceTC += porcentajeTC;
          })

          $(".cantKilos" + id).each(function(){
            kilos = $(this).text();
            kilos = $.trim(kilos);
            kilos = parseFloat(kilos);
            totalCantKilos += kilos;
          })

          $(".dietaFinal" + id).each(function(){
            kilos = $(this).text();
            kilos = $.trim(kilos);
            kilos = parseFloat(kilos);
            totalDietaFinal += kilos;
          })

          $(".kilosMS" + id).each(function(){
            kilos = $(this).text();
            kilos = $.trim(kilos);
            kilos = parseFloat(kilos);
            totalKilosMS += kilos;
          })

          $("#cantPorc" + id).text(totalCantPor.toFixed(2));
          $("#porceTCtotal" + id).text(totalPorceTC.toFixed(2));
          $("#cantKilos" + id).text(totalCantKilos.toFixed(2));
          $("#dietaFinal" + id).text(totalDietaFinal.toFixed(2));
          $("#kilosMS" + id).text(totalKilosMS.toFixed(2));  
          $("#totalMSporc" + id).text(totalPorceMS.toFixed(2));


          var margen = parseFloat($('input[name=margenError]').val());

          $(".difPorce" + id).each(function(){
            var difPorce = parseFloat($(this).text());
            if (difPorce > margen) {
              $(this).attr('style', 'color:red');
            }else{
              $(this).attr('style', 'color:green');
            }

          })
}

function imprimirFormula(id){
  var precioPor = $('#precioMS' + id).html();
  var totalMS = $('#totalPorMS' + id).html();

  window.open('imprimir/formula.php?id=' + id + '&precioPor=' + precioPor + '&totalMS=' + totalMS, '_blank');
}

function cerrarModal(id){
  $("#openModal" + id).hide(0);
}

function zindexModal(id){
    $(".zindex-" + id).css('z-index','1');
}

var div;
var btnAgregarProducto = document.getElementsByClassName('btn-agregarProducto');
btnAgregarProducto.addEventListener('click',agregarProducto());


$('.btn-agregarProducto').click(function() {

div = '<div class="row-fluid producto' + contador +'">';

div += '<div class="span3">';

div += '<select class="form-control select-insumos input-medium" name="producto' + contador +'" id="producto' + contador + '" onchange="CargarProductos(this.value,this.id);">';

div += '<option value="">Seleccionar Insumo</option>';

<?php 
for ($i=0; $i < sizeof($insumos) ; $i++) { 
$ultimaFecha = ultimaFecha($insumos[$i],$conexion);
$resultadoInsumo = traeDatos($ultimaFecha,$insumos[$i],$conexion);
?>
div += '<option value="<?php echo $resultadoInsumo['id'];?>"><?php echo $resultadoInsumo['insumo'];?></option>';
<?php } ?>
div += '</select></div>';

div += '<div class="span2">';

div += '<input type="text" class="form-control input-small porcentajes" id="porcentaje' + contador + '" name="porcentaje' + contador + '" value="0" onchange="controlCero(\'porcentaje' + contador + '\')" disabled="true" required/></div>';

div += '<div class="span2">';

div += '<input type="text" class="form-control input-small porcentajesTC" id="porcentajeTC' + contador + '" value="0" readonly/></div>';

div += '<div class="span2" id="precio' + contador + '"></div>';

div += '<div class="span2"><input type="text" style="font-weight: bold" value="0" id="precioPor' + contador + '" class="input-small importe_linea" readonly></div>'; 

div += '<div class="span1"><span class="icon-bin2" style="cursor: pointer;" onclick="eliminarProducto(\'producto' + contador + '\')"></span></div>';
$('.contenedor-producto').append(div)
contador ++; 
})

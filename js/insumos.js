function cargarSelectTipoInsumo(){

    var url = 'ajax/tipoInsumos.ajax.php';

    $.ajax({

        url:url,

        success:function(respuesta){

            $('.selectTipoInsumo').append(respuesta);

        }

    });
}


function zIndexModalNuevoInsumo(){

    $('#modal-agregarInsumo').css('z-index','999');
}


$('.selectTipoInsumo').change(function(){

    var value = $(this).val();

    if(value == 'otroTipo'){

        $('.campoOtro').css('display','block');
        console.log('gas');
    }else{
        
        $('.campoOtro').css('display','none');

    }

});

// SELECT TIPO INSUMOS

$(document).ready(function() {

    cargarSelectTipoInsumo();

});
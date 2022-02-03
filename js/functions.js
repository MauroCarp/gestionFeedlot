function comparacion(seccion){

$('#comparar' + seccion).toggle(500);

}

function cambiar(id,info){

    var pdrs = document.getElementById(id).files[0].name;

    document.getElementById(info).innerHTML = pdrs;

}

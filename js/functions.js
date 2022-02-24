function comparacion(seccion){

$('#comparar' + seccion).toggle(500);

}

function cambiar(id,info){

    var pdrs = document.getElementById(id).files[0].name;

    document.getElementById(info).innerHTML = pdrs;

}


function mostrar(id) {
    $("#" + id).show(200);
  }


const capitalizarPrimeraLetra = (str)=>{

  return str.charAt(0).toUpperCase() + str.slice(1);

}

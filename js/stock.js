  function cambiar(id,info){
    let pdrs = document.getElementById(id).files[0].name;
    document.getElementById(info).innerHTML = pdrs;
  }
  desde = (0 * 12);

  function cargaIngresos(){
    $('#paginadoIng').html('<br><div class="loading"><img src="img/loader.gif" alt="loading" /><br/>Un momento, por favor...</div>');
    datosPag = 'desde=' + desde; 
    var urlPaginador = 'paginador.php';
    $.ajax({
    type:'POST',
    url:urlPaginador,
    data:datosPag,
    success: function(datosPag){
      $('#paginadoIng').html(datosPag);
    }
    });
  }

  function cargaEgresos(){
    $('#paginadoEgr').html('<br><div class="loading"><img src="img/loader.gif" alt="loading" /><br/>Un momento, por favor...</div>');
    datosPagEgr = 'desde=' + desde; 
    var urlPaginador = 'paginadorEgr.php';
    $.ajax({
    type:'POST',
    url:urlPaginador,
    data:datosPagEgr,
    success: function(datosPagEgr){
      $('#paginadoEgr').html(datosPagEgr);
    }
    });
  }

  function cargaMuertes(){
    $('#paginadoMuertes').html('<br><div class="loading"><img src="img/loader.gif" alt="loading" /><br/>Un momento, por favor...</div>');
    datosPagM = 'desde=' + desde; 
    var urlPaginadorMuertes = 'paginadorMuertes.php';
    $.ajax({
    type:'POST',
    url:urlPaginadorMuertes,
    data:datosPagM,
    success: function(datosPagM){
      $('#paginadoMuertes').html(datosPagM);
    }
    });
  }   
    
setTimeout(() => {
  
  let btnsDescargaPlanilla = document.getElementsByClassName('descargarPlanillas')

  for (const btn of btnsDescargaPlanilla) {
      
    btn.addEventListener('click',()=>{

      let seccion = btn.attributes.seccion.value  
      
      let btnDescargar = document.getElementById('descargarPlanillaManual')
      
      btnDescargar.href = `planillas/${seccion}.csv`
  
      btnDescargar.download = `Planilla ${seccion}.csv`
    
    })

  }

}, 500);
  
  
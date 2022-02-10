const getRandomColor = ()=>{

    let letters = '0123456789ABCDEF';

    let color = '#';

    for (let i = 0; i < 6; i++) {

        color += letters[Math.floor(Math.random() * 16)];

    }
    
    return color;

}

/*=============================================
GET COOKIE
=============================================*/

const getCookie = cname=>{
	
	let name = cname + "=";
	
	let decodedCookie = decodeURIComponent(document.cookie);
	
	let ca = decodedCookie.split(';');
	
	for(let i = 0; i <ca.length; i++) {
	    let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
	    }
	
        if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
        }
    }
	
	return null;
  
}

let url = 'ajax/dataGraficoMuertes.ajax.php'

let feedlot = getCookie('feedlot')

let data = `feedlot=${feedlot}`

$.ajax({
    method:'POST',
    url:url,
    data:data,
    success:(response)=>{

        let data = JSON.parse(response)
        
        let config = {
            type: 'pie',
            data: {
            datasets: [{
                data: [
                    `${data.accidente}`,`${data.digestivo}`,`${data.ingreso}`,`${data.nervioso}`,`${data.rechazo}`,`${data.respiratorio}`,`${data.sinDiagnostico}`,`${data.sinHallazgo}`,`${data.otro}`
                ],
                backgroundColor: [getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor(),getRandomColor()],
                label: 'Causa Muertes'
            }],
            labels: ['Accidente','Digestivo','Ingreso','Nervioso','Rechazo','Respiratorio','Sin Diagnostico','Sin Hallazgo','Otro']
            },
            options: {
                responsive: true,
                legend: {
                    position: 'right',
                },
                plugins: {
					labels: {
					render: 'percentage',
                    fontColor: 'white',
					}
				}
            }
        };
        
        let ctx = document.getElementById('chart-area').getContext('2d')
        window.myPie = new Chart(ctx, config)

    }
})


/*=============================================
BTN EDITAR CUASA
=============================================*/

const editarCausa = (idMuerte)=>{
    
    document.getElementById('btnEditarCausa').attributes.idMuerte.value = idMuerte
    
}

/*=============================================
EDITAR CUASA
=============================================*/

const btnEditarCausa = document.getElementById('btnEditarCausa')

btnEditarCausa.addEventListener(('click'),(e)=>{

    let url = 'ajax/muertes.ajax.php'

    let idMuerte = e.target.attributes.idmuerte.value
    
    let causaMuerte = document.getElementById('causaMuerteEdit').value

    let data = `id=${idMuerte}&causa=${causaMuerte}`

    $.ajax({
        method:'post',
        url,
        data,
        success:(resp)=>{

            if(resp == 'ok'){

                window.location = 'stock.php?seccion=muerte'
                
            }else{

            }

        }

    })
})



// EDITAR ANIMAL
const btnsEditarAnimal = document.getElementsByClassName('btnEditarAnimal')

for (const btn of btnsEditarAnimal) {

    btn.addEventListener('click',(e)=>{

        e.preventDefault()

        let idAnimal = e.path[1].attributes.idAnimal.value

        let seccion = capitalizarPrimeraLetra(e.path[1].attributes.seccion.value)

        let divId = `animales${seccion}`

        let parentNode = document.getElementById('bodyModal')

        if(seccion == 'Ingresos'){

            document.getElementById(divId).style.display = 'block'
            
            if(document.getElementById('animalesEgresos'))
            parentNode.removeChild(document.getElementById('animalesEgresos'))
            
        }else{
            
            document.getElementById(divId).style.display = 'block'
            
            if(document.getElementById('animalesIngresos'))
                parentNode.removeChild(document.getElementById('animalesIngresos'))

        }

        let url = 'ajax/animales.ajax.php'

        let data = `accion=cargarData&idAnimal=${idAnimal}&tabla=${e.path[1].attributes.seccion.value}`

        $.ajax({
            method:'post',
            url,
            data,
            success:(resp)=>{

                let data = JSON.parse(resp)
                
                document.getElementById('idAnimalEditar').value = data.id 

                document.getElementById('inputPesoEditar').value = data.peso 
                
                document.getElementById('inputRazaEditar').value = data.raza 
                
                document.getElementById('inputSexoEditar').value = data.sexo 
                
                if(seccion == 'Egresos'){
                    
    
                    document.getElementById('inputOrigenEditar').value = data.origen 
                    document.getElementById('inputProveedorEditar').value = data.proveedor 
                    document.getElementById('inputGdmTotalEditar').value = data.gdmTotal.replace(',','.')
                    document.getElementById('inputGpvTotalEditar').value = data.gpvTotal.replace(',','.')
                    document.getElementById('inputDestinoEditar').value = data.destino 
                
                }
            
            }

        })

    })

}

// ZINDEX MODAL EDITAR ANIMAL

document.getElementById('verDetalles').addEventListener('click',()=>{
    
    document.getElementById('modalEditarAnimal').style.zIndex = '9'

})


// REGISTRAR CAMBIOS EDITAR ANIMAL

document.getElementById('btnEditarAnimal').addEventListener('click',()=>{
    
    let inputsEditar = document.getElementsByClassName('dataEditar')

    let dataEditar = {}

    for (const input of inputsEditar) {
        
        dataEditar[input.name] = input.value
        
    }
    
    let tabla = (Object.keys(dataEditar).length > 4) ? 'egresos' : 'ingresos';
    
    let url = 'ajax/animales.ajax.php'

    let data = `accion=modificarData&data=${JSON.stringify(dataEditar)}&tabla=${tabla}`

    $.ajax({
        method:'post',
        url,
        data,
        success:(resp)=>{
            console.log(resp);
            
            if(resp == 'ok'){

                window.location = `verTropa.php?tropa=${getQueryVariable('tropa').replace(' ','')}&seccion=${getQueryVariable('seccion')}`

            }

        }

    })
    
    
});
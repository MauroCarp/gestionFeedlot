
// EDITAR ANIMAL
const btnsEditarAnimal = document.getElementsByClassName('btnEditarAnimal')

for (const btn of btnsEditarAnimal) {

    btn.addEventListener('click',(e)=>{

        e.preventDefault()

        console.log(e);

    })

}

// ZINDEX MODAL EDITAR ANIMAL

document.getElementById('verDetalles').addEventListener('click',()=>{
    document.getElementById('modalEditarAnimal').style.zIndex = '9'
})
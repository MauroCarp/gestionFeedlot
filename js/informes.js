// MODAL INFORMES
document.addEventListener("DOMContentLoaded", ()=>{

    let btnsInforme = document.getElementsByClassName('btnInforme')
    
    for (const btn of btnsInforme) {
    
        btn.addEventListener('click',()=>{
    
            document.getElementById('divComparar').style.display = 'block'
    
        })
    
    }
    
    document.getElementById('btnInformeStock').addEventListener('click',()=>{
        
        if(document.getElementById('divComparar'))
            document.getElementById('divComparar').style.display = 'none'
    
    })
    
});
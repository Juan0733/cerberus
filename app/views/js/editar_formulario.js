document.addEventListener('DOMContentLoaded',()=>{
    let btn_continuar = document.getElementById('btn_continuar_editar')
    let grupo_1 = document.getElementById('grupo_1_editar')
    let grupo_2 = document.getElementById('grupo_2_formularios_editar')
    let btn_aterior = document.getElementById('btn_anterior_formularios_editar')



    btn_continuar.addEventListener('click', ()=>{
        const inputs = grupo_1.querySelectorAll('input, select');
        let valid = true;
        inputs.forEach(input => {
            if (!input.checkValidity()) {
                input.reportValidity();
                valid = false;
            }
        });
        if (valid) {
            grupo_1.style.display = "none"
            grupo_2.style.display = "block"
            
        }
    })
    btn_aterior.addEventListener('click', ()=>{
        grupo_2.style.display = "none"
        grupo_1.style.display = "block"
        
        
    })
    
    window.addEventListener('resize', function() {
        if(this.window.innerWidth>767){
            grupo_1.style.display = "block"
            grupo_2.style.display = "block"
        } else{
            grupo_2.style.display = "none"
        }
        
        // console.log('El tamaño de la pantalla ha cambiado!'); console.log(`Ancho: ${window.innerWidth}, Alto: ${window.innerHeight}`); 
});
})

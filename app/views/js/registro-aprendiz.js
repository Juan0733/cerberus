document.addEventListener('DOMContentLoaded',()=>{
    let btn_continuar = document.getElementById('btn_continuar')
    let grupo_1 = document.getElementById('grupo_1')
    let grupo_2 = document.getElementById('grupo_2_formularios')
    let btn_aterior = document.getElementById('btn_anterior_formularios')
    
    
    
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

document.getElementById("nombre_programa").addEventListener("change", filtroPrograma);
function filtroPrograma() {
    let select = document.getElementById("nombre_programa").value;
    let contenido = document.getElementById("numero_ficha");
    let formData = new FormData();
    formData.append('nombre_programa', select);
    
    let url = "../app/ajax/aprendiz-ajax.php";

    fetch(url, {
        method: "POST",
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        contenido.innerHTML = '<option value="" hidden>Seleccione un número de ficha</option>';

        data.forEach(option => {
            const opt = document.createElement('option');
            opt.value = option.value;
            opt.textContent = option.text;
            contenido.appendChild(opt);
        });
    })
    .catch(err => console.error('Fetch error:', err));
}
const $d = document
      $form = $d.querySelector(".form_crear_anuncio"),
      $btnPublicar = $form.querySelector("button[type='submit']"),
      $btnGuardar = $d.querySelector(".editar__btn"),
      $btnCancelar = $d.querySelector(".cancelar__btn"),
      $submitMsg = $d.querySelector(".submit_msg")

const url = "http://proyecto.local/api/"

function getAnuncio(){
    ajax({
        url:`${url}anuncios/${idAnuncio}`,
        method:"GET",
        fsuccess:(json)=>{
            $form.querySelector("#imagen").value = json.imagen
            $form.querySelector("#nombre").value = json.nombre
            $form.querySelector("#descripcion").value = json.texto
            $form.querySelector("#precio").value = json.precio
        },
        ferror:(error)=>{
            console.log(error)
        }
    })

    $submitMsg.classList.remove("hidden")
}

function editarAnuncio(data){
    ajax({
        url:`${url}anuncios/${idAnuncio}`,
        method:"PUT",
        fsuccess:(json)=>{
            $submitMsg.style.color="green"
            $submitMsg.textContent = "Has puesto el anuncio como un borrador"
        },
        ferror:(error)=>{
            console.log(error)
            $submitMsg.style.color="red"
            $submitMsg.textContent = "Ha ocurrido un error, vuelve a intentarlo"
        },
        data:data
    })

    $submitMsg.classList.remove("hidden")
}

function publicarAnuncio(data){
    ajax({
        url:`${url}anuncios/${idAnuncio}`,
        method:"PUT",
        fsuccess:(json)=>{
            $submitMsg.style.color="green"
            $submitMsg.textContent = "Anuncio publicado correctamente"
        },
        ferror:(error)=>{
            console.log(error)
            $submitMsg.style.color="red"
            $submitMsg.textContent = "Parece que has intentado volver a publicar el anuncio sin realizar cambios. Haz algún cambio y vuelve a intentarlo."
        },
        data:data
    })

    $submitMsg.classList.remove("hidden")
}

function validarFormulario(){
    let toret = true

    const campos = ["nombre","descripcion","precio"]

    campos.forEach(campo => {
        $form[campo].style.border = "1px solid var(--main-color)"
    })

    if($form.nombre.value.trim() == ""){
        $form.nombre.style.border = "1px solid red"
        Swal.fire({
            title: "ERROR",
            text: "El nombre es obligatorio.",
            icon: "error"
        });
        toret = false
    } else if($form.descripcion.value.trim() == ""){
        $form.descripcion.style.border = "1px solid red"
        Swal.fire({
            title: "ERROR",
            text: "La descripción es obligatoria.",
            icon: "error"
        });
        toret = false
    } else if($form.precio.value==0){
        $form.precio.style.border = "1px solid red"
        Swal.fire({
            title: "ERROR",
            text: "El precio es obligatorio.",
            icon: "error"
        });
        toret = false
    }

    return toret
}

$d.addEventListener("DOMContentLoaded", () => {
    getAnuncio()
    $form.addEventListener("click", ev=>{
        ev.preventDefault()
        if(ev.target.classList.contains("editar_campo_btn")){
            if(ev.target.parentElement.querySelector("input"))
                ev.target.parentElement.querySelector("input").disabled = false
            else
                ev.target.parentElement.querySelector("textarea").disabled = false
        }
    })

    $btnPublicar.addEventListener("click", ev=>{
        ev.preventDefault()
        if(validarFormulario()){
            let cambios = {
                imagen:($form.querySelector("#imagen").value).trim()!="" ? $form.querySelector("#imagen").value : "http://proyecto.local/uploads/anuncio_img_default.png",
                nombre:$form.querySelector("#nombre").value,
                texto:$form.querySelector("#descripcion").value,
                precio:$form.querySelector("#precio").value,
                estado:"publicado"
            }
    
            publicarAnuncio(cambios)
        }
    })

    $btnGuardar.addEventListener("click", ev=>{
        ev.preventDefault()
        if(validarFormulario()){
            let cambios = {
                imagen:($form.querySelector("#imagen").value).trim()!="" ? $form.querySelector("#imagen").value : "http://proyecto.local/uploads/anuncio_img_default.png",
                nombre:$form.querySelector("#nombre").value,
                texto:$form.querySelector("#descripcion").value,
                precio:$form.querySelector("#precio").value,
                estado:"dev"
            }
    
            editarAnuncio(cambios)
            $d.querySelectorAll("input").disabled=true
        }
    })
})

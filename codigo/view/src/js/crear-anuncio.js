const $d = document
      $form = $d.querySelector(".form_crear_anuncio"),
      $btnGuardar = $d.querySelector(".editar__btn"),
      $btnCancelar = $d.querySelector(".cancelar__btn"),
      $submitMsg = $d.querySelector(".submit_msg")

const id = $d.querySelector(".header__perfil").dataset.id,
      url = "https://mcaneda.iescotarelo.es/api/"

function crearAnuncio(data){
    ajax({
        url:`${url}anuncios`,
        method:"POST",
        fsuccess:(json)=>{
            $submitMsg.style.color="green"
            $submitMsg.textContent = "Anuncio creado correctamente"
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
    $form.addEventListener("click", ev=>{
        ev.preventDefault()
        if(ev.target.classList.contains("editar_campo_btn")){
            if(ev.target.parentElement.querySelector("input"))
                ev.target.parentElement.querySelector("input").disabled = false
            else
                ev.target.parentElement.querySelector("textarea").disabled = false
        }
    })

    $btnGuardar.addEventListener("click", ev=>{
        if(validarFormulario()){
            ev.preventDefault()
            let cambios = {
                id_cliente:id,
                imagen:($form.querySelector("#imagen").value).trim()!="" ? $form.querySelector("#imagen").value : "http://proyecto.local/uploads/anuncio_img_default.png",
                nombre:$form.querySelector("#nombre").value,
                texto:$form.querySelector("#descripcion").value,
                precio:$form.querySelector("#precio").value
            }
    
            crearAnuncio(cambios)
            $d.querySelectorAll("input").disabled=true
        }
    })
})

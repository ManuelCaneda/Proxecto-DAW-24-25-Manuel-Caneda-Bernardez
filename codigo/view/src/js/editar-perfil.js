const $d = document
      $form = $d.querySelector(".form_perfil"),
      $btnGuardar = $d.querySelector(".editar__btn"),
      $btnCancelar = $d.querySelector(".cancelar__btn"),
      $submitMsg = $d.querySelector(".submit_msg")

const url = "https://mcaneda.iescotarelo.es/api/"

const regExEmail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/

function editarPerfil(data){
    ajax({
        url:`${url}usuarios/${id}`,
        method:"PUT",
        fsuccess:(json)=>{
            $submitMsg.style.color="green"
            $submitMsg.textContent = "Perfil editado correctamente"
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

    const campos = $form.querySelectorAll(".input_perfil")

    campos.forEach(campo => {
        campo.style.border = "1px solid var(--main-color)"
    })

    if($form.nombre.value.trim() == ""){
        ($form.nombre).parentElement.style.border = "1px solid red"
        Swal.fire({
            title: "ERROR",
            text: "El nombre es obligatorio.",
            icon: "error"
        });
        toret = false
    } else if($form.aps.value.trim() == ""){
        ($form.aps).parentElement.style.border = "1px solid red"
        Swal.fire({
            title: "ERROR",
            text: "Los apellidos son obligatorios.",
            icon: "error"
        });
        toret = false
    } else if(!regExEmail.test($form.email.value.trim())){
        ($form.email).parentElement.style.border = "1px solid red"
        Swal.fire({
            title: "ERROR",
            text: "El email es obligatorio.",
            icon: "error"
        });
        toret = false
    }

    if($d.querySelector("#direccion")){
        if($form.direccion.value.trim() == ""){
            ($form.direccion).parentElement.style.border = "1px solid red"
            Swal.fire({
                title: "ERROR",
                text: "La dirección es obligatoria.",
                icon: "error"
            });
            toret = false
        } else if($form.horario_invierno.value.trim() == ""){
            ($form.horario_invierno).parentElement.style.border = "1px solid red"
            Swal.fire({
                title: "ERROR",
                text: "El horario de invierno es obligatorio.",
                icon: "error"
            });
            toret = false
        } else if($form.horario_verano.value.trim() == ""){
            ($form.horario_verano).parentElement.style.border = "1px solid red"
            Swal.fire({
                title: "ERROR",
                text: "El horario de verano es obligatorio.",
                icon: "error"
            });
            toret = false
        }
    }    

    return toret
}

$d.addEventListener("DOMContentLoaded", () => {
    $form.addEventListener("click", ev=>{
        ev.preventDefault()
        if(ev.target.classList.contains("editar_campo_btn")){
            ev.target.parentElement.querySelector("input").disabled = false
        }
    })

    $btnGuardar.addEventListener("click", ev=>{
        ev.preventDefault()
        if(validarFormulario()){
            let cambios = {
                nombre:$form.querySelector("#nombre").value,
                apellidos:$form.querySelector("#aps").value,
                email:$form.querySelector("#email").value
            }
    
            if($form.querySelector("#direccion")){
                cambios = {
                    nombre:$form.querySelector("#nombre").value,
                    apellidos:$form.querySelector("#aps").value,
                    email:$form.querySelector("#email").value,
                    direccion: $form.querySelector("#direccion").value,
                    horario_invierno: $form.querySelector("#horario_invierno").value,
                    horario_verano: $form.querySelector("#horario_verano").value
                }
            }
    
            editarPerfil(cambios)
            $d.querySelectorAll("input").disabled=true
        }
    })
})

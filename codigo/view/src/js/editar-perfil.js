const $d = document
      $form = $d.querySelector(".form_perfil"),
      $btnGuardar = $d.querySelector(".editar__btn"),
      $btnCancelar = $d.querySelector(".cancelar__btn"),
      $submitMsg = $d.querySelector(".submit_msg")

function ajaxFetch(options){
    const {url,method,fsuccess,ferror,data} = options

    fetch(url,{
        method: method || "GET",
        headers:{
            "Content-type":"application/json;charset=utf-8"
        },
        body:JSON.stringify(data)
    })
    .then(resp=>resp.ok?resp.json():Promise.reject(resp))
    .then(json=>fsuccess(json))
    .catch(error=>ferror(error))
}

function editarPerfil(data){
    
    ajaxFetch({
        url:`http://proyecto.local/api/usuarios/12`,
        method:"PUT",
        fsuccess:(json)=>{
            console.log(json)
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

$d.addEventListener("DOMContentLoaded", () => {
    $form.addEventListener("click", ev=>{
        ev.preventDefault()
        if(ev.target.classList.contains("editar_campo_btn")){
            ev.target.parentElement.querySelector("input").disabled = false
        }
    })

    $btnGuardar.addEventListener("click", ev=>{
        ev.preventDefault()
        editarPerfil({
            nombre:$form.querySelector("#nombre").value,
            apellidos:$form.querySelector("#aps").value,
            email:$form.querySelector("#email").value
        })
        $d.querySelectorAll("input").disabled=true
    })
})
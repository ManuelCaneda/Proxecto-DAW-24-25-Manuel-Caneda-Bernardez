const $d = document
      $form = $d.querySelector(".form_crear_anuncio"),
      $btnGuardar = $d.querySelector(".editar__btn"),
      $btnCancelar = $d.querySelector(".cancelar__btn"),
      $submitMsg = $d.querySelector(".submit_msg")

const id = $d.querySelector(".header__perfil").dataset.id,
      url = "http://proyecto.local/api/"

function crearAnuncio(data){
    ajax({
        url:`${url}anuncios`,
        method:"POST",
        fsuccess:(json)=>{
            $submitMsg.style.color="green"
            $submitMsg.textContent = "Anuncio creado correctamente"
            window.location.href = "/inicio"
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

function convertirABase64(archivo) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.onload = () => resolve(reader.result); // Devuelve la cadena Base64
        reader.onerror = (error) => reject(error); // Maneja errores
        reader.readAsDataURL(archivo); // Leer el archivo como una URL en Base64
    });
}

function subirAnuncio(imagen){
    // Crear el objeto cambios con los datos del formulario
    const cambios = {
        id_cliente: id,
        imagen: imagen, // Imagen en formato Base64
        nombre: $form.querySelector("#nombre").value,
        texto: $form.querySelector("#descripcion").value,
        precio: $form.querySelector("#precio").value,
    };

    // Enviar los datos al servidor
    crearAnuncio(cambios);
    $d.querySelectorAll("input").disabled=true
}

$d.addEventListener("DOMContentLoaded", () => {
    $form.addEventListener("click", ev=>{
        if(ev.target!=$d.querySelector("input[type='file']"))
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

            const archivo = $form.querySelector("#imagen").files[0];

            if(!archivo){
                subirAnuncio("")
                return
            }

            convertirABase64(archivo).then((base64Imagen) => {
                subirAnuncio(base64Imagen)
            }).catch((error) => {
                console.error("Error al convertir la imagen a Base64:", error);
            });
        }
    })
})

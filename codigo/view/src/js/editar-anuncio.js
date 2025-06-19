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
            $form.querySelector("img").src = json.imagen
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

function publicarAnuncio(data){
    ajax({
        url:`${url}anuncios/${idAnuncio}`,
        method:"PUT",
        fsuccess:(json)=>{
            $submitMsg.style.color="green"
            $submitMsg.textContent = "Anuncio publicado correctamente"
            window.location.href = "/inicio"
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

function convertirABase64(archivo) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.onload = () => resolve(reader.result); // Devuelve la cadena Base64
        reader.onerror = (error) => reject(error); // Maneja errores
        reader.readAsDataURL(archivo); // Leer el archivo como una URL en Base64
    });
}

function subirAnuncio(imagen,estado){
    // Crear el objeto cambios con los datos del formulario
    const cambios = {
        imagen: imagen, // Imagen en formato Base64
        nombre: $form.querySelector("#nombre").value,
        texto: $form.querySelector("#descripcion").value,
        precio: $form.querySelector("#precio").value,
        estado:estado
    };

    if(estado == "publicado")
        publicarAnuncio(cambios)
    else
        editarAnuncio(cambios)

    $d.querySelectorAll("input").disabled=true
}

function urlToFile(url, fileName) {
    return fetch(url) // Descargar la imagen desde la URL
        .then((response) => {
            if (!response.ok) {
                throw new Error("Error al descargar la imagen");
            }
            return response.blob(); // Convertir la respuesta en un Blob
        })
        .then((blob) => {
            return new File([blob], fileName, { type: blob.type }); // Crear un archivo a partir del Blob
        });
}

$d.addEventListener("DOMContentLoaded", () => {
    getAnuncio()
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

    $btnPublicar.addEventListener("click", ev=>{
        ev.preventDefault()
        if (validarFormulario()) {
            let imgUrl = $form.querySelector("img").src;
        
            // Convertir la URL en un archivo
            urlToFile(imgUrl, imgUrl.split("/").pop())
                .then((archivo) => {
                    // Si el cliente subió una imagen nueva, seleccionará esa:
                    if ($form.querySelector("#imagen").files[0]) {
                        archivo = $form.querySelector("#imagen").files[0];
                    }
        
                    // Convertir la imagen (ya sea del input o la antigua) a Base64
                    return convertirABase64(archivo);
                })
                .then((base64Imagen) => {
                    // Subir el anuncio con la imagen en Base64
                    subirAnuncio(base64Imagen, "publicado");
                })
                .catch((error) => {
                    console.error("Error al procesar la imagen:", error);
                });
        }
    })

    $btnGuardar.addEventListener("click", ev=>{
        ev.preventDefault()

        if(validarFormulario()){
            if (validarFormulario()) {
                let imgUrl = $form.querySelector("img").src;
            
                // Convertir la URL en un archivo
                urlToFile(imgUrl, imgUrl.split("/").pop())
                    .then((archivo) => {
                        // Si el cliente subió una imagen nueva, seleccionará esa:
                        if ($form.querySelector("#imagen").files[0]) {
                            archivo = $form.querySelector("#imagen").files[0];
                        }
            
                        // Convertir la imagen (ya sea del input o la antigua) a Base64
                        return convertirABase64(archivo);
                    })
                    .then((base64Imagen) => {
                        // Subir el anuncio con la imagen en Base64
                        subirAnuncio(base64Imagen, "dev");
                    })
                    .catch((error) => {
                        console.error("Error al procesar la imagen:", error);
                    });
            }
        }
    })
})

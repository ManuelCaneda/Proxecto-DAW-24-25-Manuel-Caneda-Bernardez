const $d = document,
      $infoPag = $d.querySelector(".pag_anuncio_info"),
      $valoraciones = $d.querySelector(".pag_anuncio_valoraciones"),
      $form = $d.querySelector(".form_valoracion"),
      $contactarBtn = $d.querySelector(".contactar_empresa_btn"),
      $infoAnuncio = $d.querySelector(".pag_anuncio_texto")

const url = "http://proyecto.local/api/"

let anuncio, cliente, usuario, addTextareaContacto = false
const valoraciones = [],
      idPropia = $d.querySelector(".header__perfil").dataset.id

function enviarValoracion(){
    ajax({
        url:`${url}valoraciones`,
        method:"POST",
        fsuccess:(json)=>{
            $form.querySelector("textarea").value = ""
            getValoraciones()
        },
        ferror:(error)=>{
            console.log(error)
        },
        data: {
            id_anuncio: id,
            id_usuario: idPropia,
            texto: $form.querySelector("textarea").value,
            puntuacion: $form.querySelector("#select_puntuacion").value
        }
    })
}

function getAnuncio(){
    ajax({
        url:`${url}anuncios/${id}`,
        method:"GET",
        fsuccess:(json)=>{
            anuncio = {...json}
            getCliente(anuncio)
        },
        ferror:(error)=>{
            console.log(error)
        }
    })
}

function getValoraciones(){
    ajax({
        url:`${url}valoraciones/anuncio/${id}`,
        method:"GET",
        fsuccess:(json)=>{
            valoraciones.splice(0,valoraciones.length,...json)
            renderValoraciones(valoraciones)
        },
        ferror:(error)=>{
            console.log(error)
        }
    })
}

function renderValoraciones(valoraciones) {
    if(!$d.querySelector(".lista_valoraciones")){
        $listaValoraciones = $d.createElement("ul")
        $listaValoraciones.classList.add("lista_valoraciones")
        $valoraciones.appendChild($listaValoraciones)
    }
    if(valoraciones.length > 0){
        $listaValoraciones.innerHTML = valoraciones.reduce((anterior,actual)=>{
            return anterior + `
                <li class="card_valoracion">
                    <p class="autor_valoracion">${actual.nombre_autor}
                        <img class="valoracion_estrellas" src="./view/src/assets/img/valoraciones/${actual.puntuacion}-stars.png" alt="">
                    </p>
                    <p class="contenido_valoracion">${actual.texto}</p>
                </li>
            `
        },'')
    }
}

function getCliente(anuncio){
    let id = anuncio.id_cliente
    ajax({
        url:`${url}usuarios/${id}`,
        method:"GET",
        fsuccess:(json)=>{
            cliente = {...json}
            renderAnuncio(anuncio,cliente)
        },
        ferror:(error)=>{
            console.log(error)
        }
    })
}

function renderAnuncio(anuncio,cliente){
    $infoPag.innerHTML = `
        <article class="pag_anuncio_img">
            <figure>
                <img src="${anuncio.imagen}" alt="Imagen del anuncio">
            </figure>
            <h3>Información:</h3>
            <ul>
                <li>Dirección: ${cliente.direccion}</li>
                <li>Precio Base: ${anuncio.precio}&euro;</li>
                <li>Horario de invierno: ${cliente.horario_invierno}</li>
                <li>Horario de verano: ${cliente.horario_verano}</li>
            </ul>
        </article>
        <article class="pag_anuncio_texto">
            <h2>${anuncio.nombre}</h2>
            <p>${anuncio.texto}</p>
            <a href="">Términos y condiciones de servicio</a>
            <button class="btn contactar_empresa_btn">Contactar</button>
        </article>
    `
}

function comprobarValoracion(){
    return ($form.querySelector("textarea").value).length >= 10
}

function enviarMensaje(data) {
    ajax({
        url: `${url}mensajes`,
        method: "POST",
        fsuccess: () => {
            alert("Mensaje enviado correctamente.")
            //window.location.href = `http://proyecto.local/?controller=user&action=chat` // Redirigir al anuncio
        },
        ferror: (error) => {
            console.log(error)
            alert("Ha ocurrido un error al enviar el mensaje. Comprueba que el mensaje tiene por lo menos 4 caracteres.")
        },
        data: data
    })
}

$d.addEventListener("DOMContentLoaded", () => {
    getAnuncio()
    getValoraciones()

    $form.addEventListener("submit", ev => {
        ev.preventDefault()

        if(comprobarValoracion()){
            enviarValoracion()
        } else {
            alert("La valoración debe tener al menos 10 caracteres.")
        }
    })
    
    $infoPag.addEventListener("click", ev=>{
        if(ev.target.classList.contains("contactar_empresa_btn")){
            ev.preventDefault()
            if(!addTextareaContacto){
                addTextareaContacto = true
                const $textareaMsg = $d.createElement("textarea"),
                      $btnEnviarMsg = $d.createElement("button"),
                      $pagAnuncioTexto = $d.querySelector(".pag_anuncio_texto")
    
                $textareaMsg.classList.add("contactar_textarea")
                $textareaMsg.placeholder = "Escribe tu mensaje..."
    
                $btnEnviarMsg.classList.add("btn")
                $btnEnviarMsg.classList.add("enviarMsg_btn") 
                $btnEnviarMsg.textContent = "Enviar Mensaje"
        
                $pagAnuncioTexto.appendChild($textareaMsg)
                $pagAnuncioTexto.appendChild($btnEnviarMsg)
            }
        }

        if(ev.target.classList.contains("enviarMsg_btn")){
            if(($d.querySelector('.contactar_textarea').value).length >= 4){
                const msg = {
                    id_emisor:idPropia,
                    id_receptor:anuncio.id_cliente,
                    texto:$d.querySelector('.contactar_textarea').value
                }
        
                enviarMensaje(msg)
            } else {
                alert("El mensaje debe tener al menos 4 caracteres.")
            }
        }
    })
})
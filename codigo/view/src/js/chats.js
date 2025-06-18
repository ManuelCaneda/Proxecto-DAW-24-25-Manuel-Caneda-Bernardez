const $d = document,
      $listaChats = $d.querySelector(".lista_chats"),
      $chatAbierto = $d.querySelector(".chat_abierto");

const mensajesEnviados = [],
      mensajesRecibidos = [],
      idContactos = [],
      contactos = [],
      idPropia = $d.querySelector(".header__perfil").dataset.id,
      url = "http://proyecto.local/api/",
      mensajes = []

let idOtro,
    comprobarNuevosMensajes = false,
    ultimoMsg

function getMensajes(idOtro) {
    ajax({
        url: `${url}mensajes/conversacion/${idPropia}/${idOtro}`,
        method: "GET",
        fsuccess: (json) => {
            mensajes.splice(0, mensajes.length, ...json); // Actualizar la lista de mensajes
            renderMensajes(mensajes); // Renderizar solo los mensajes filtrados
        },
        ferror: (error) => {
            console.log(error);
        }
    });
}

function getContactos(idPropia){
    ajax({
        url: `${url}usuarios/contactos/${idPropia}`,
        method:"GET",
        fsuccess:(json)=>{
            contactos.splice(0,contactos.length,...json)
            renderContactos(contactos)
        },
        ferror:(error)=>{
            // console.log(error)
            $listaChats.innerHTML = `<h2 class="search_noresult">No se encontraron conversaciones</h2>`; // Mostrar mensaje si no hay contactos
        }
    })
}

function renderMensajes(mensajes){

    if($chatAbierto.classList.contains("chat_abierto")){
        $chatAbierto.classList.remove("chat_abierto")
    }

    if(!comprobarNuevosMensajes){
        $chatAbierto.innerHTML = "";
        $chatAbierto.innerHTML += "<ul class='mensajes'></ul>";
    }


    $chatAbierto.querySelector(".mensajes").innerHTML = mensajes.reduce((anterior, actual, index, array) => {
        // Comprobar si la fecha del mensaje actual es distinta de la del mensaje anterior
        const fechaAnterior = index > 0 ? array[index - 1].fecha : null; // Fecha del mensaje anterior o null si es el primero
        const mostrarFecha = fechaAnterior !== actual.fecha; // Comparar fechas
    
        return anterior + `
            ${mostrarFecha ? `<p class="fecha-mensajes">${actual.fecha}</p>` : ""}
            <li class="mensaje-${actual.id_emisor == idPropia ? "enviado" : "recibido"}">
                <p style="white-space: pre-line;">${actual.texto}</p>
                <span>${actual.hora.slice(0, 5)}</span>
            </li>
        `;
    }, '');

    if(!comprobarNuevosMensajes){
        $chatAbierto.innerHTML += `
            <section class="chat_nuevo_mensaje">
                <article class="nuevo_msg_input">
                    <textarea name="nuevoMsg" id="nuevoMsg" placeholder="Escribe tu mensaje"></textarea>
                    <button class="btn btn__enviar_nuevoMsg">
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </article>
            </section>
        `
        comprobarNuevosMensajes = true

        $mensajes = $chatAbierto.querySelector('.mensajes')
        $mensajes.scrollTop = $mensajes.scrollHeight; // Desplazar al final del chat
    }
}

function renderContactos(contactos){
    $listaChats.innerHTML = contactos.reduce((anterior,actual)=> anterior + `
        <li class="chat" data-id="${actual.id}">
            <figure class="chat_img">
                <img src="./view/src/assets/img/favicon.png" alt="Imagen de perfil del contacto">
            </figure>
            <section class="chat_texto">
                <p class="chat_nombre">${actual.nombre} ${actual.apellidos}</p>                
            </section>
        </li>
    `,'');
}

function enviarMensaje(){
    const $inputMsg = $chatAbierto.querySelector("#nuevoMsg")
    ajax({
        url: `${url}mensajes`,
        method:"POST",
        fsuccess:()=>{
            getMensajes(idOtro)
        },
        ferror:(error)=>{
            console.log(error)
        },
        data: {
            id_emisor: idPropia,
            id_receptor: idOtro,
            texto: $inputMsg.value
        }
    })
}

$d.addEventListener("DOMContentLoaded"  , () => {
    getContactos(idPropia)
    $listaChats.addEventListener("click", ev=>{
        ev.preventDefault()

        if(ev.target.classList.contains("chat")){
            const $todosLosChats = $listaChats.querySelectorAll(".chat")
            $todosLosChats.forEach(chat => {
                chat.classList.remove("chat_selected")
            })

            ev.target.classList.add("chat_selected")

            $chatAbierto.innerHTML = "<div class='loader'></div>";
            comprobarNuevosMensajes = false
            idOtro = ev.target.dataset.id
            getMensajes(idOtro); // Usamos una función que llama a getMensajes con la id del contacto

            setInterval(() => {
                getMensajes(idOtro); // Usamos una función que llama a getMensajes con la id del contacto
            }, 5000);
            
            $chatAbierto.classList.add("mostrar")
        }
    })    

    $chatAbierto.addEventListener("click", ev=>{
        if(ev.target.classList.contains("btn__enviar_nuevoMsg")){
            enviarMensaje()
            comprobarNuevosMensajes = false
        }
    })
})

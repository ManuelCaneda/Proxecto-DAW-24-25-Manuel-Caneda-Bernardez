const $d = document,
      $listaChats = $d.querySelector(".lista_chats")
      $todosLosChats = $listaChats.querySelectorAll(".chat"),
      $chatAbierto = $d.querySelector(".chat_abierto");

const mensajesEnviados = [],
      mensajesRecibidos = [],
      idContactos = [],
      contactos = [],
      idPropia = $d.querySelector(".header__perfil").dataset.id,
      url = "http://proyecto.local/api/",
      mensajes = [],
      ultimoMensaje = [];

let idOtro = 13,
    comprobarNuevosMensajes = false


function ajax(options){
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

function getMensajes(idOtro){
    ajax({
        url: `${url}mensajes`,
        method:"GET",
        fsuccess:(json)=>{
            mensajes.splice(0,mensajes.length,...json.filter(msg =>
                ((msg.id_emisor == idPropia && msg.id_receptor == idOtro) ||
                 (msg.id_emisor == idOtro && msg.id_receptor == idPropia))
            ));         
            renderMensajes(mensajes)

            const $mensajes = $chatAbierto.querySelector('.mensajes');
            $mensajes.scrollTop = $mensajes.scrollHeight;
        },
        ferror:(error)=>{
            console.log(error)
        }
    })
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
            console.log(error)
        }
    })
}

function renderMensajes(mensajes){

    if(!comprobarNuevosMensajes){
        $chatAbierto.innerHTML = "";
        $chatAbierto.innerHTML += "<ul class='mensajes'></ul>";
    }


    $chatAbierto.querySelector(".mensajes").innerHTML = mensajes.reduce((anterior,actual)=>anterior + `
        <li class="mensaje-${actual.id_emisor == idPropia ? "enviado" : "recibido"}">
            <p style="white-space: pre-line;">${actual.texto}</p>
            <span>${actual.hora.slice(0,5)}</span>
        </li>
    `,'')

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
    }
}

function getUltimoMensaje(idOtro){
    ajax({
        url: `${url}mensajes`,
        method:"GET",
        fsuccess:(json)=>{
            ultimoMensaje.splice(0,ultimoMensaje.length,...json.filter(msg =>
                ((msg.id_emisor == idPropia && msg.id_receptor == idOtro) ||
                 (msg.id_emisor == idOtro && msg.id_receptor == idPropia))
            ));
            console.log(ultimoMensaje)
        },
        ferror:(error)=>{
            console.log(error)
        }
    })
}

function renderContactos(contactos){
    $listaChats.innerHTML = contactos.reduce((anterior,actual)=>{
        getUltimoMensaje(actual.id)

        return anterior + `
        <li class="chat" data-id="${actual.id}">
            <figure class="chat_img">
                <img src="./view/src/assets/img/favicon.png" alt="Imagen de perfil del contacto">
            </figure>
            <section class="chat_texto">
                <article class="info_chat">
                    <p class="chat_nombre">${actual.nombre} ${actual.apellidos}</p>
                    <p class="chat_msg_hora">""</p>
                </article>
                <p class="chat_lastMsg">${ultimoMensaje.texto}</p>
            </section>
        </li>
    `},'');
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
            $todosLosChats.forEach(chat => {
                chat.classList.remove("chat_selected")
            })

            ev.target.classList.add("chat_selected")

            $chatAbierto.innerHTML = "<div class='loader'></div>";
            comprobarNuevosMensajes = false
            idOtro = ev.target.dataset.id
            setInterval(() => {
                getMensajes(idOtro); // Usamos una función anónima que llama a getMensajes con idOtro
            }, 2000);

            $chatAbierto.classList.add("mostrar")
        }
    })    

    $chatAbierto.addEventListener("click", ev=>{
        if(ev.target.classList.contains("btn__enviar_nuevoMsg")){
            enviarMensaje()
        }
    })
})
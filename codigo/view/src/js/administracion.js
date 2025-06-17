const $d = document,
      $main = $d.querySelector('main'),
      $titulo = $d.querySelector('h2'),
      $contenido = $d.querySelector('.contenido-administracion')

const url = "https://mcaneda.iescotarelo.es/api/"

const usuarios = [],
      anuncios = [],
      valoraciones = []

let nombre = ""
const botonesAdmin = ["usuarios","anuncios","valoraciones","volver"]

/* USUARIOS */

function renderUsuarios(usuarios) {
    $contenido.innerHTML = '<table class="tabla-gestion-usuarios" border="1" border-collapse></table>'

    const $tabla = $contenido.querySelector('.tabla-gestion-usuarios')
    
    $tabla.innerHTML = `<tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Email</th>
        <th>Acciones</th>
    </tr>`

    $tabla.innerHTML += usuarios.reduce((anterior,actual)=> anterior + `
        <tr>
            <td>${actual.id}</td>
            <td>${actual.nombre} ${actual.apellidos}</td>
            <td>${actual.email}</td>
            <td>
                <i class="fa-solid fa-comment" style="color: blue" data-id="${actual.id}"></i>
                <i class="fa-solid fa-user-pen" style="color: green" data-id="${actual.id}"></i>
                <i class="fa-solid fa-trash" style="color: red" data-id="${actual.id}"></i>
            </td>
        </tr>
    `,'')

    $contenido.innerHTML += `<button class="btn btn_volver_admin" style="margin-top: 10px;">Volver</button>`
}

function getUsuarios() {
    ajax({
        url: `${url}usuarios`,
        method: "GET",
        fsuccess: (json) => {
            usuarios.splice(0,usuarios.length,...json)
            renderUsuarios(usuarios.filter(usuario => usuario.tipo != 1))
        },
        ferror: (error) => {
            console.log(error)
        }
    })
}

function formEditarUsuario(id) {
    ajax({
        url: `${url}usuarios/${id}`,
        method: "GET",
        fsuccess: (json) => {
            $contenido.classList.add("editar_perfil_main")
            $contenido.innerHTML = `
            <h3>Editar Usuario</h3>
            <p class="submit_msg hidden"></p>
            <form action="" class="form_perfil">
                <p>
                    <label for="nombre">Nombre:</label>
                    <article class="input_perfil">
                        <input type="text" name="nombre" id="nombre" value="${json.nombre}">
                        <i class="fa-solid fa-pencil editar_campo_btn"></i>
                    </article>
                </p>
                <p>
                    <label for="aps">Apellidos:</label>
                    <article class="input_perfil">
                        <input type="text" name="aps" id="aps" value="${json.apellidos}">
                        <i class="fa-solid fa-pencil editar_campo_btn"></i>
                    </article>
                </p>
                <p>
                    <label for="email">Correo electrónico:</label>
                    <article class="input_perfil">
                        <input type="email" name="email" id="email" value="${json.email}">
                        <i class="fa-solid fa-pencil editar_campo_btn"></i>
                    </article>
                </p>
                ${(json.tipo==3) ? `
                    <p>
                        <label for="direccion">Dirección:</label>
                        <article class="input_perfil">
                            <input type="text" name="direccion" id="direccion" value="${json.direccion}">
                            <i class="fa-solid fa-pencil editar_campo_btn"></i>
                        </article>
                    </p>
                    <p>
                        <label for="horario_invierno">Horario de Invierno:</label>
                        <article class="input_perfil">
                            <input type="text" name="horario_invierno" id="horario_invierno" value="${json.horario_invierno}">
                            <i class="fa-solid fa-pencil editar_campo_btn"></i>
                        </article>
                    </p>
                    <p>
                        <label for="horario_verano">Horario de Verano:</label>
                        <article class="input_perfil">
                            <input type="text" name="horario_verano" id="horario_verano" value="${json.horario_verano}">
                            <i class="fa-solid fa-pencil editar_campo_btn"></i>
                        </article>
                    </p>
                `:''}
            </form>
            <p class="editar__btns">
                <button class="btn editar__btn" data-id="${json.id}" type="submit">Guardar</button>
                <a href=".">
                    <button class="btn cancelar__btn">Cancelar</button>
                </a>
            </p>`
        },
        ferror: (error) => {
            console.log(error)
        }
    })
}

function editarUsuario(id,data){
    const $submitMsg = $contenido.querySelector('.submit_msg')
    ajax({
        url:`${url}usuarios/${id}`,
        method:"PUT",
        fsuccess:(json)=>{
            $submitMsg.style.color="green"
            $submitMsg.textContent = "Perfil editado correctamente"
        },
        ferror:(error)=>{
            $submitMsg.style.color="red"
            $submitMsg.textContent = "Ha ocurrido un error, vuelve a intentarlo"
        },
        data:data
    })

    $submitMsg.classList.remove("hidden")
}

function deleteUsuario(id) {
    ajax({
        url: `${url}usuarios/${id}`,
        method: "DELETE",
        fsuccess: () => {
            $contenido.innerHTML = ''
            getUsuarios()
        },
        ferror: (error) => {
            console.log(error)
        }
    })
}

function formEnviarMsg(id) {
    $contenido.classList.add("editar_perfil_main")
    $contenido.innerHTML = `
    <h3>Enviar Mensaje</h3>
    <p class="submit_msg hidden"></p>
    <textarea name="mensaje" id="mensaje" cols="50" rows="10" placeholder="Escribe tu mensaje aquí..."></textarea>
    <button class="btn enviar_msg_btn" data-id="${id}">Enviar</button>
    <button class="btn-light btn_volver_admin" style="margin-top: 10px;">Volver</button>
    `
}

function enviarMensaje(data) {
    const $submitMsg = $contenido.querySelector('.submit_msg')
    ajax({
        url: `${url}mensajes`,
        method: "POST",
        fsuccess: (json) => {
            $submitMsg.style.color = "green"
            $submitMsg.innerHTML = "Mensaje enviado correctamente, puedes comprobar el chat en la pestaña de chats."
        },
        ferror: (error) => {
            console.log(error)
            $submitMsg.style.color = "red"
            $submitMsg.textContent = "Ha ocurrido un error al enviar el mensaje. Comprueba que el mensaje tiene por lo menos 4 caracteres."
        },
        data: data
    })

    $submitMsg.classList.remove("hidden")
}

/* ANUNCIOS */

function getAnuncios() {
    ajax({
        url: `${url}anuncios`,
        method: "GET",

        fsuccess: (json) => {
            anuncios.splice(0,anuncios.length,...json)
            renderAnuncios(anuncios)
        },
        ferror: (error) => {
            console.log(error)
        }
    })
}

function renderAnuncios(anuncios) {
    $contenido.innerHTML = '<table class="tabla-gestion-anuncios" border="1" border-collapse></table>'

    const $tabla = $contenido.querySelector('.tabla-gestion-anuncios')
    
    $tabla.innerHTML = `<tr>
        <th>ID</th>
        <th>Autor</th>
        <th>Título</th>
        <th>Descripción</th>
        <th>Precio</th>
        <th>Estado</th>
        <th>Acciones</th>
    </tr>`

    $tabla.innerHTML += anuncios.reduce((anterior,actual)=> anterior + `
        <tr>
            <td>${actual.id_anuncio}</td>
            <td>${actual.id_cliente}</td>
            <td>${actual.nombre}</td>
            <td>${actual.texto}</td>
            <td>${actual.precio}</td>
            <td>${actual.estado=="dev"?"En desarrollo":"Publicado"}</td>
            <td>
                <i class="fa-solid fa-pen" style="color: green" data-id="${actual.id_anuncio}"></i>
                <i class="fa-solid fa-trash" style="color: red" data-id="${actual.id_anuncio}"></i>
            </td>
        </tr>
    `,'')

    $contenido.innerHTML += `<button class="btn btn_volver_admin" style="margin-top: 10px;">Volver</button>`
}

function formEditarAnuncio(id) {
    ajax({
        url: `${url}anuncios/${id}`,
        method: "GET",
        fsuccess: (json) => {
            $contenido.classList.add("editar_perfil_main")
            $contenido.innerHTML = `
            <p class="submit_msg hidden"></p>
            <form action="" class="form_crear_anuncio">
                <p>
                    <label for="imagen">URL de la imagen:</label>
                    <input type="text" name="imagen" id="imagen" value="${json.imagen}">
                </p>
                <p>
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" id="nombre" value="${json.nombre}">
                </p>
                <p>
                    <label for="descripcion">Descripción:</label>
                    <textarea name="descripcion" id="descripcion" cols="30" rows="10">${json.texto}</textarea>
                </p>
                <p>
                    <label for="precio">Precio base:</label>
                    <input type="number" name="precio" id="precio" value="${json.precio}">
                </p>
                <button class="btn publicar_anuncio_btn" type="submit">Publicar</button>
            </form>
            <p class="editar__btns">
                <button class="btn-light editar__btn" type="submit">Guardar borrador</button>
                <button class="btn cancelar__btn">Volver</button>
            </p>`
        },
        ferror: (error) => {
            console.log(error)
        }
    })
}

function editarAnuncio(id,data){
    const $submitMsg = $contenido.querySelector('.submit_msg')
    ajax({
        url:`${url}anuncios/${id}`,
        method:"PUT",
        fsuccess:(json)=>{
            $submitMsg.style.color="green"
            $submitMsg.textContent = "Borrador de anuncio editado correctamente"
        },
        ferror:(error)=>{
            $submitMsg.style.color="red"
            $submitMsg.textContent = "Ha ocurrido un error, vuelve a intentarlo"
        },
        data:data
    })

    $submitMsg.classList.remove("hidden")
}

function publicarAnuncio(idAnuncio,data){
    const $submitMsg = $contenido.querySelector('.submit_msg')
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

function deleteAnuncio(id) {
    ajax({
        url: `${url}anuncios/${id}`,
        method: "DELETE",
        fsuccess: () => {
            $contenido.innerHTML = ''
            getAnuncios()
        },
        ferror: (error) => {
            console.log(error)
        }
    })
}

/* VALORACIONES */

function getUsuariosForValoraciones(){
    ajax({
        url: `${url}usuarios`,
        method: "GET",
        fsuccess: (json) => {
            usuarios.splice(0,usuarios.length,...json)
            getValoraciones(usuarios);
        },
        ferror: (error) => {
            console.log(error)
        }
    })

    //getValoraciones(usuarios); // Llama a getValoraciones con los usuarios obtenidos
}

function getValoraciones(usuarios) {
    ajax({
        url: `${url}valoraciones`,
        method: "GET",
        fsuccess: (json) => {
            valoraciones.splice(0,valoraciones.length,...json)
            renderValoraciones(valoraciones, usuarios);
        },
        ferror: (error) => {
            console.log(error)
        }
    })
}

function renderValoraciones(valoraciones, usuarios) {
    $contenido.innerHTML = '<table class="tabla-gestion-anuncios" border="1" border-collapse></table>'

    const $tabla = $contenido.querySelector('.tabla-gestion-anuncios')
    
    $tabla.innerHTML = `<tr>
        <th>ID</th>
        <th>ID Anuncio</th>
        <th>Autor</th>
        <th>Puntuación</th>
        <th>Contenido</th>
        <th>Acciones</th>
    </tr>`

    $tabla.innerHTML += valoraciones.reduce((anterior,actual)=> {
        const usuario = usuarios.find(u => u.id == actual.id_usuario);
        const nombreAutor = usuario ? `${usuario.nombre} ${usuario.apellidos}` : 'Desconocido';
        
        return anterior + `
            <tr>
                <td>${actual.id}</td>
                <td>${actual.id_anuncio}</td>
                <td>${nombreAutor}</td>
                <td>
                    <img src="./view/src/assets/img/valoraciones/${actual.puntuacion}-stars.png" alt="${actual.puntuacion}" style="width: 100px; height: 20px">
                </td>
                <td>${actual.texto}</td>
                <td>
                    <i class="fa-solid fa-trash" style="color: red" data-id="${actual.id}"></i>
                </td>
            </tr>
        `
    },'')

    $contenido.innerHTML += `<button class="btn btn_volver_admin" style="margin-top: 10px;">Volver</button>`
}

function deleteValoracion(id) {
    ajax({
        url: `${url}valoraciones/${id}`,
        method: "DELETE",
        fsuccess: () => {
            $contenido.innerHTML = ''
            getUsuariosForValoraciones()
        },
        ferror: (error) => {
            console.log(error)
        }
    })
}

function menuPrincipal(){
    $contenido.innerHTML = `
        <ul class="lista-gestion-administracion">
            <li>
                <button class="btn">Usuarios</button>
            </li>
            <li>
                <button class="btn">Anuncios</button>
            </li>
            <li>
                <button class="btn">Valoraciones</button>
            </li>
        </ul>
    `

    $titulo.textContent = '¿Qué quieres editar?'
}

$d.addEventListener('DOMContentLoaded', () => {
    $main.addEventListener('click', ev => {
        ev.preventDefault()

        if(ev.target.tagName === 'BUTTON' && botonesAdmin.includes(ev.target.textContent.toLowerCase())) {
            const $btn = ev.target
            $titulo.textContent = ($btn.textContent)
            let contenidoBtn = $btn.textContent.toLowerCase()
    
            switch (contenidoBtn) {
                case "usuarios":
                    getUsuarios()
                break
    
                case "anuncios":
                    getAnuncios()
                break
    
                case "valoraciones":
                    getUsuariosForValoraciones()
                break

                case "volver":
                    menuPrincipal()
                break
            }
        }
        
        if(ev.target.classList.contains('cancelar__btn')) {
            menuPrincipal()
        } else if(ev.target.classList.contains('editar__btn')) {
            switch ($titulo.textContent) {
                case "Usuarios":
                    $form = $contenido.querySelector('.form_perfil')
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
            
                    editarUsuario(id,cambios)
                break

                case "Anuncios":
                    $form = $contenido.querySelector('.form_crear_anuncio')               
                    let anuncio = {
                        imagen:$form.querySelector("#imagen").value,
                        nombre:$form.querySelector("#nombre").value,
                        texto:$form.querySelector("#descripcion").value,
                        precio:$form.querySelector("#precio").value,
                        estado:"dev"
                    }
            
                    editarAnuncio(id,anuncio)
                break

                case "Valoraciones":
                    deleteValoracion(id)
                break
            }
            
        } else if(ev.target.classList.contains('publicar_anuncio_btn')) {
            $form = $contenido.querySelector('.form_crear_anuncio')               
            let anuncio = {
                imagen:$form.querySelector("#imagen").value,
                nombre:$form.querySelector("#nombre").value,
                texto:$form.querySelector("#descripcion").value,
                precio:$form.querySelector("#precio").value,
                estado:"publicado"
            }
    
            publicarAnuncio(id,anuncio)
        } else if(ev.target.classList.contains('enviar_msg_btn')) {        
            let msg = {
                id_emisor:$d.querySelector('.header__perfil').dataset.id,
                id_receptor:ev.target.dataset.id,
                texto:$d.querySelector('textarea').value
            }
    
            enviarMensaje(msg)
        }
                    
        if(ev.target.classList.contains('editar__btn')) {
            
        }
    
        if(ev.target.classList.contains('publicar__btn')) {
            let anuncio = {
                imagen:$form.querySelector("#imagen").value,
                nombre:$form.querySelector("#nombre").value,
                texto:$form.querySelector("#descripcion").value,
                precio:$form.querySelector("#precio").value,
                estado:"dev"
            }
    
            editarAnuncio(anuncio)
        }
    })

    $contenido.addEventListener('click', ev => {
        if(ev.target.classList.contains('fa-trash')) {
            Swal.fire({
                title: "¿Estás seguro de que quieres eliminarlo? Esta acción no se puede deshacer.",
                showDenyButton: true,
                confirmButtonText: "Borrar",
                denyButtonText: `Cancelar`
              }).then((result) => {
            if (result.isConfirmed) {
                id = ev.target.dataset.id
                switch ($titulo.textContent) {
                    case "Usuarios":
                        deleteUsuario(id)
                    break
    
                    case "Anuncios":
                        deleteAnuncio(id)
                    break
    
                    case "Valoraciones":
                        deleteValoracion(id)
                    break
                }
            }
            });
            // if(window.confirm("¿Estás seguro de que quieres eliminarlo? Esta acción no se puede deshacer.")) {
            //     id = ev.target.dataset.id
            //     switch ($titulo.textContent) {
            //         case "Usuarios":
            //             deleteUsuario(id)
            //         break
    
            //         case "Anuncios":
            //             deleteAnuncio(id)
            //         break
    
            //         case "Valoraciones":
            //             deleteValoracion(id)
            //         break
            //     }
            // }
        }

        if(ev.target.classList.contains('fa-user-pen') || ev.target.classList.contains('fa-pen')) {
            id= ev.target.dataset.id
            switch ($titulo.textContent) {
                case "Usuarios":
                    formEditarUsuario(id)
                break

                case "Anuncios":
                    formEditarAnuncio(id)
                break
            }
        }

        if(ev.target.classList.contains('fa-comment')) {
            id = ev.target.dataset.id
            formEnviarMsg(id)    
        }
    })
})

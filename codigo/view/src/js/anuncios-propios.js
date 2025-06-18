const $d = document,
      $main = $d.querySelector("main"),
      $listaAnuncios = $d.querySelector(".anuncios_propios")

const anuncios = [];
let cliente

const url = "http://proyecto.local/api/"
const idPropio = $d.querySelector(".header__perfil").dataset.id

function getCliente(){
    ajax({
        url:`${url}usuarios/${idPropio}`,
        method:"GET",
        fsuccess:(json)=>{
            cliente = {...json}
            getAnuncios(cliente)
        },
        ferror:(error)=>{
            console.log(error)
        }
    })
}

function getAnuncios(cliente){
    $listaAnuncios.innerHTML = "<div class='loader'></div>"
    ajax({
        url:`${url}anuncios/cliente/${idPropio}`,
        method:"GET",
        fsuccess:(json)=>{
            anuncios.splice(0,anuncios.length,...json)
            renderAnuncios(anuncios, cliente)
        },
        ferror:(error)=>{
            renderAnuncios([], cliente)
        }
    })
}

function renderAnuncios(anuncios, cliente){    
    const $loader = $d.querySelector(".loader")
    $loader.remove()

    if(anuncios.length > 0){
        $listaAnuncios.innerHTML = anuncios.reduce((anterior,actual)=> anterior + `
            <li class="card_anuncio">
                <figure class="anuncio_img">
                    <img src="${actual.imagen}" alt="">
                </figure>
                <section class="anuncio_info">
                    <hgroup>
                        <h2 class="anuncio_title">${actual.nombre}</h2>
                        <h4 class="anuncio_owner">Por ${cliente.nombre} ${cliente.apellidos}</h4>
                    </hgroup>
                    <p class="anuncio_price">${actual.precio}&euro;</p>
                </section>
                <p class="anuncio_desc">${(actual.texto).slice(0,100)}${(actual.texto).length>=100?"...":""}</p>
                <section class="anuncio_estado">
                    <p class="anuncio_estado_texto">${(actual.estado=="dev")?"En desarrollo":"Publicado"}</p>
                    <figure class="anuncio_estado_icon">
                        <img src="./view/src/assets/img/${actual.estado=="dev"?"dev":"check"}.png" alt="Icono de check verde">
                    </figure>
                </section>
                <section class="crear_anuncio_btns">
                <a href="?controller=page&action=editarAnuncio&id=${actual.id_anuncio}">
                    <button class="anuncio_btn btn">Editar información</button>
                </a>
                    <button class="btn fa-solid fa-trash" data-id="${actual.id_anuncio}">
                        
                    </button>
                </section>
            </li>
            `
        ,'')
    }
    
    $listaAnuncios.innerHTML += `
        <li class="card_anuncio add_card">
            <figure class="add_card_icon">
                <img src="./view/src/assets/img/plus.png" alt="">
            </figure>
        </li>
    `
    
}

function deleteAnuncio(anuncioId){
    ajax({
        url:`${url}anuncios/${anuncioId}`,
        method:"DELETE",
        fsuccess:(json)=>{
            getAnuncios(cliente)
        },
        ferror:(error)=>{
            console.log(error)
        }
    })
}

$d.addEventListener("DOMContentLoaded"  , () => {
    getCliente()

    $main.addEventListener("click", ev=>{
        if(ev.target.classList.contains("add_card")){
            ev.preventDefault()
            window.location.href = "?controller=page&action=crearAnuncio"
        }

        if(ev.target.classList.contains("fa-trash")){
            ev.preventDefault()
            Swal.fire({
                title: "¿Estás seguro de que quieres eliminar este anuncio? Esta acción no se puede deshacer.",
                showDenyButton: true,
                confirmButtonText: "Borrar",
                denyButtonText: `Cancelar`
              }).then((result) => {
                if (result.isConfirmed) {
                    id = ev.target.dataset.id
                    deleteAnuncio(id)
                }
            });
        }
    })
})

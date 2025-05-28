const $d = document,
      $main = $d.querySelector("main"),
      $titulo = $d.querySelector("h1"),
      $listaAnuncios = $d.querySelector(".anuncios_destacados"),
      $busquedaInput = $d.querySelector(".header__buscador input"),
      $busquedaBtn = $d.querySelector(".header__buscador button");

const anuncios = [];
const url = "http://proyecto.local/api/"

function getAnuncios(){
    $titulo.textContent = "Destacados"
    ajax({
        url:`${url}anuncios/publicados/?limit=4`,
        method:"GET",
        fsuccess:(json)=>{
            anuncios.splice(0,anuncios.length,...json)
            renderAnuncios(anuncios)
        },
        ferror:(error)=>{
            console.log(error)
        }
    })
}

function getAnunciosBySearch(){
    busqueda = $busquedaInput.value
    $titulo.textContent = `Resultados de la búsqueda: ${busqueda}`
    ajax({
        url:`${url}anuncios/busqueda/${busqueda}`,
        method:"GET",
        fsuccess:(json)=>{
            anuncios.splice(0,anuncios.length,...json)
            renderAnuncios(anuncios)
        },
        ferror:(error)=>{
            $listaAnuncios.innerHTML = `<h2 class="search_noresult">No se encontraron anuncios</h2>`
        }
    })
}

function renderAnuncios(anuncios){
    $listaAnuncios.innerHTML = anuncios.reduce((anterior,actual)=>anterior + `
            <li class="card_anuncio">
            <figure class="anuncio_img">
                <img src="${actual.imagen}" alt="">
            </figure>
            <section class="anuncio_info">
                <hgroup>
                    <h2 class="anuncio_title">${actual.nombre}</h2>
                    <h4 class="anuncio_owner">${actual.autor}</h4>
                </hgroup>
                <p class="anuncio_price">${actual.precio}&euro;</p>
            </section>
            <p class="anuncio_desc">${actual.texto}</p>
            <a href="?controller=page&action=verAnuncio&id=${actual.id_anuncio}" class="anuncio_btn">
                <button class="anuncio_btn btn">Más información</button>
            </a>
        </li>
        `
    ,'')
}

$d.addEventListener("DOMContentLoaded", () => {
    getAnuncios()

    $busquedaBtn.addEventListener("click", ev=>{
        ev.preventDefault()
        $listaAnuncios.innerHTML = "<div class='loader'></div>";
        if($busquedaInput.value.length > 0)
            getAnunciosBySearch()
        else 
            getAnuncios()
    })
})
const $d = document,
      $listaAnuncios = $d.querySelector(".anuncios_destacados");

const anuncios = [];

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

function getAnuncios(){
    ajax({
        url:"http://proyecto.local/api/anuncios",
        method:"GET",
        fsuccess:(json)=>{
            anuncios.splice(0,anuncios.length,...json)
            renderAnuncios(anuncios)
            console.log(anuncios)
        },
        ferror:(error)=>{
            console.log(error)
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
                    <h4 class="anuncio_owner">${actual.nombre}</h4>
                </hgroup>
                <p class="anuncio_price">${actual.precio}&euro;</p>
            </section>
            <p class="anuncio_desc">${actual.texto}</p>
            <button class="anuncio_btn btn">Más información</button>
        </li>
        `
    ,'')
}

$d.addEventListener("DOMContentLoaded"  , () => {
    getAnuncios(anuncios)
})
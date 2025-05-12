const $d = document,
      $listaAnuncios = $d.querySelector(".anuncios_destacados");

const anuncios = [];

const idPropio = $d.querySelector(".header__perfil").dataset.id

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
        url:`http://proyecto.local/api/anuncios/${idPropio}`,
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
    if(anuncios.length == 0){
        $listaAnuncios.innerHTML += `<h2>No tienes anuncios</h2>`
    } else {
        $listaAnuncios.innerHTML = anuncios.reduce((anterior,actual)=>anterior + `
            <li class="card_anuncio">
                <figure class="anuncio_img">
                    <img src="https://www.aislamos.com/wp-content/uploads/2024/08/facebook.jpg" alt="">
                </figure>
                <section class="anuncio_info">
                    <hgroup>
                        <h2 class="anuncio_title">Aislamientos</h2>
                        <h4 class="anuncio_owner">Por Aislamos</h4>
                    </hgroup>
                    <p class="anuncio_price">200&euro;</p>
                </section>
                <p class="anuncio_desc">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam officia provident nam, amet est pariatur ducimus hic mollitia quos libero quisquam vitae eum labore doloribus. Libero enim esse soluta ad.</p>
                <section class="anuncio_estado">
                    <p class="anuncio_estado_texto">Publicado</p>
                    <figure class="anuncio_estado_icon">
                        <img src="./view/src/assets/img/check.png" alt="Icono de check verde">
                    </figure>
                </section>
                <button class="anuncio_btn btn">Editar información</button>
            </li>
            `
        ,'')
    
        if(anuncios.length < 5){
            $listaAnuncios.innerHTML += `
            <h2>No tienes anuncios</h2>
            `
        }
    }
}

$d.addEventListener("DOMContentLoaded"  , () => {
    getAnuncios(anuncios)
})
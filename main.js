!function () {
    let items = JSON.parse(localStorage.getItem("carrito")) || []
    const CONTADOR = document.getElementById("contador")
    const TOTAL = document.getElementById("total")
    const PRODUCTOS_TOTALES = document.getElementById("productos_totales")
    let cant_products = null
    let existeItem = null

    /* console.log(JSON.parse(localStorage.getItem("carrito"))); */
    window.addEventListener("DOMContentLoaded", main)


    async function main() {
        mostrarProductos()

        if (items.length > 0 ||  items.length == 0 ) {
            actualizar_Carrito(items)
            CONTADOR.textContent = items.length
        }

        deteccion_clicks()
        getYear()
    }


    function getYear() {
        // Inicio de Obtencion de Año Actual 
        const $YEAR = document.getElementById("year")
        const FULL_YEAR = new Date().getFullYear()
        $YEAR.textContent = FULL_YEAR
        // Fin de Obtencion de Año Actual    
    }




    async function mostrarProductos() {
        const $CONTENEDOR = document.getElementById("contenedor")
        const $TEMPLATE = document.getElementById("template").content
        const FRAGMENTO = document.createDocumentFragment()

        const RPTA = await fetch("../../administrador/producto/items.php")
        const DATA = await RPTA.json()
        console.log(DATA);

        /*     for (let i = 0; i < 9; i++) 
            {
                const clone = $template.cloneNode(true)
                clone.querySelector(".card").id = i
                fragmento.appendChild(clone)
            }
            $contenedor.appendChild(fragmento) */

        DATA.forEach(item => {
            const CLONE = $TEMPLATE.cloneNode(true)
            CLONE.querySelector(".card").id = item.idProducto
            CLONE.querySelector(".producto").textContent = item.nombre
            CLONE.querySelector(".precio").textContent = item.precio
            CLONE.querySelector(".imagen").src = `../imgs/${item.foto}`
            FRAGMENTO.appendChild(CLONE)
        });
        $CONTENEDOR.appendChild(FRAGMENTO)
    }


    function deteccion_clicks() {
        const ASIDE = document.getElementById("aside")


        window.addEventListener("click", async e => {
            /* console.log(e.target); */

            if (e.target.classList.contains("close")) {
                ASIDE.style.right = `-${ASIDE.clientWidth + 10}px`
            }
            else if (e.target.classList.contains("open")) {
                ASIDE.style.right = "0"
            }
            else if (e.target.classList.contains("plus")) {
                cant_products = e.target.nextElementSibling

                const ROW_ID = e.target.parentNode.parentNode.parentNode.parentNode.id

                const INFO_ROW = await detalle(ROW_ID)

                if (parseInt(cant_products.textContent) < INFO_ROW[0].stock) {
                    cant_products.textContent = parseInt(cant_products.textContent) + 1
                    for (const item of items)
                        if (item.id == ROW_ID) item.cont += 1

                    actualizar_Carrito(items)

                    console.log(items);
                }

            }
            else if (e.target.classList.contains("minus")) {
                cant_products = e.target.previousElementSibling
                cant_products.textContent = parseInt(cant_products.textContent) - 1

                const ROW_ID = e.target.parentNode.parentNode.parentNode.parentNode.id

                if (cant_products.textContent < 1) {
                    items = items.filter(item => item.id != ROW_ID)
                }
                else {
                    for (const item of items)
                        if (item.id == ROW_ID) item.cont -= 1
                }

                actualizar_Carrito(items)

            }
            else if (e.target.classList.contains("add") || e.target.classList.contains("view")) {
                const ID = e.target.parentNode.parentNode.parentNode.parentNode.id
                const IMAGE = e.target.parentNode.parentNode.previousElementSibling.src
                const NAME = e.target.parentNode.previousElementSibling.querySelector(".producto").textContent
                const PRICE = e.target.parentNode.previousElementSibling.querySelector(".precio").textContent
                // console.log(e.target.parentNode.parentNode.previousElementSibling.src);

                if (e.target.classList.contains("view")) {
                    const data = detalle(ID)
                    datos_modal(data)
                    return
                }


                if (items.length > 0) existeItem = items.find(item => item.id == ID);

                if (existeItem) return

                const OBJETO = {
                    "id": ID,
                    "image": IMAGE,
                    "name": NAME,
                    "price": PRICE,
                    "cont": 1
                }

                items.push(OBJETO)
                CONTADOR.textContent = items.length

                actualizar_Carrito(items)
            }

        });
    }


    function actualizar_Carrito(arr) {
        const filaProducto = document.getElementById("filaProducto").content
        const itemsComprados = document.getElementById("itemsComprados")
        const fragmento = document.createDocumentFragment()
        let guardar_total = 0
        let productos_total = 0

        limpiar_Carrito()

        if (arr.length > 0) {

            arr.forEach(item => {
                const clonar = filaProducto.cloneNode(true)
                clonar.querySelector(".col-12").id = item.id
                clonar.querySelector("img").src = item.image
                clonar.querySelector(".p_name").textContent = item.name
                clonar.querySelector(".p_price").textContent = item.price
                clonar.querySelector(".cantidad").textContent = item.cont
                fragmento.appendChild(clonar)

                productos_total += parseInt(item.cont)
                guardar_total += parseFloat(item.price) * parseInt(item.cont)
            });

            itemsComprados.appendChild(fragmento);

            TOTAL.textContent = "S/. " + guardar_total.toFixed(2)
            PRODUCTOS_TOTALES.textContent = productos_total
            CONTADOR.textContent = arr.length
        }
        else {
            TOTAL.textContent = ""
            PRODUCTOS_TOTALES.textContent = ""
            CONTADOR.textContent = 0
        }

        guardar_en_Storage(arr);
    }


    function limpiar_Carrito() {
        const ITEMS_COMPRADOS = document.getElementById("itemsComprados")
        while (ITEMS_COMPRADOS.firstChild) {
            ITEMS_COMPRADOS.removeChild(ITEMS_COMPRADOS.firstChild)
        }
    }


    function guardar_en_Storage(arr) {
        localStorage.setItem("carrito", JSON.stringify(arr))
    }


    async function detalle(id) {
        const RPTA = await fetch(`../../administrador/producto/detalles.php?id=${id}`)
        const DATA = await RPTA.json()
        return DATA;
    }

    async function datos_modal(obj) {
        const IMG_MODAL = document.getElementById("img_modal"),
            TITLE_MODAL = document.getElementById("title_modal"),
            PRICE_MODAL = document.getElementById("price_modal"),
            DESCRIPTION_MODAL = document.getElementById("description_modal"),
            PRESENTACION_MODAL = document.getElementById("presentacion_modal"),
            STOCK_MODAL = document.getElementById("stock_modal")

        const DATA = await obj;
        console.log(DATA);

        console.log(DATA[0].nombre);
        console.log(DATA[0].precio);

        IMG_MODAL.src = `../imgs/${DATA[0].foto}`
        TITLE_MODAL.textContent = DATA[0].nombre
        DESCRIPTION_MODAL.textContent = DATA[0].descripcion
        PRESENTACION_MODAL.textContent = DATA[0].PRnombre
        PRICE_MODAL.textContent = `Precio: S/. ${DATA[0].precio}`
        STOCK_MODAL.textContent = `Stock: ${DATA[0].stock }`
    }

}();
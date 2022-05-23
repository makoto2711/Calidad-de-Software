!function () {
    let items = JSON.parse(localStorage.getItem("carrito")) || []
    const contador = document.getElementById("contador")
    const total = document.getElementById("total")
    const pro_total = document.getElementById("productos_totales")
    let cant_products = null
    let existeItem = null

    /* console.log(JSON.parse(localStorage.getItem("carrito"))); */
    window.addEventListener("DOMContentLoaded", main)


    async function main() 
    {
        mostrarProductos()
        
        if (items.length > 0) 
        {
            actualizar_Carrito(items)
            contador.textContent = items.length
        }

        deteccion_clicks()
        getYear()       
    }


    function getYear() {
        // Inicio de Obtencion de Año Actual 
        const $year = document.getElementById("year")
        const fullYear = new Date().getFullYear()
        $year.textContent = fullYear
        // Fin de Obtencion de Año Actual    
    }


    

    async function mostrarProductos() 
    {
        const $contenedor = document.getElementById("contenedor")
        const $template = document.getElementById("template").content
        const fragmento = document.createDocumentFragment()

        const rpta = await fetch("../../administrador/producto/items.php")
        const data = await rpta.json()
        console.log(data);
      
    /*     for (let i = 0; i < 9; i++) 
        {
            const clone = $template.cloneNode(true)
            clone.querySelector(".card").id = i
            fragmento.appendChild(clone)
        }
        $contenedor.appendChild(fragmento) */

        data.forEach(item => 
        {
            const clone = $template.cloneNode(true)
            clone.querySelector(".card").id = item.idProducto
            clone.querySelector(".producto").textContent = item.nombre
            clone.querySelector(".precio").textContent = item.precio 
            clone.querySelector(".imagen").src = `../imgs/${item.foto}` 
            fragmento.appendChild(clone)
        });
        $contenedor.appendChild(fragmento)
    }


    function deteccion_clicks() {
        const aside = document.getElementById("aside")


        window.addEventListener("click", e => {
            /* console.log(e.target); */

            if (e.target.classList.contains("close")) {
                aside.style.right = `-${aside.clientWidth + 10}px`
            }
            else if (e.target.classList.contains("open")) {
                aside.style.right = "0"
            }
            else if (e.target.classList.contains("plus")) {
                cant_products = e.target.nextElementSibling
                cant_products.textContent = parseInt(cant_products.textContent) + 1

                const row_id = e.target.parentNode.parentNode.parentNode.parentNode.id

                for (const item of items)
                    if (item.id == row_id) item.cont += 1

                actualizar_Carrito(items)

                console.log(items);
            }
            else if (e.target.classList.contains("minus")) {
                cant_products = e.target.previousElementSibling
                cant_products.textContent = parseInt(cant_products.textContent) - 1

                const row_id = e.target.parentNode.parentNode.parentNode.parentNode.id

                if (cant_products.textContent < 1) 
                {
                    items = items.filter(item => item.id != row_id)
                }
                else 
                {
                    for (const item of items)
                        if (item.id == row_id) item.cont -= 1
                }

                actualizar_Carrito(items)

            }
            else if (e.target.classList.contains("add") || e.target.classList.contains("view")) {
                const id = e.target.parentNode.parentNode.parentNode.parentNode.id
                const image = e.target.parentNode.parentNode.previousElementSibling.src
                const name = e.target.parentNode.previousElementSibling.querySelector(".producto").textContent
                const price = e.target.parentNode.previousElementSibling.querySelector(".precio").textContent
                // console.log(e.target.parentNode.parentNode.previousElementSibling.src);

                if (e.target.classList.contains("view")) 
                {
                    const data = detalle(id)
                    datos_modal(data)
                    return
                }


                if (items.length > 0) existeItem = items.find(item => item.id == id);

                if (existeItem) return

                const objeto = {
                    "id": id,
                    "image": image,
                    "name": name,
                    "price": price,
                    "cont": 1
                }

                items.push(objeto)
                contador.textContent = items.length

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

            total.textContent = "S/. " + guardar_total
            pro_total.textContent = productos_total
        }
        else
        {
            total.textContent = ""
            pro_total.textContent = ""
        }

        guardar_en_Storage(arr);
    }


    function limpiar_Carrito() {
        const itemsComprados = document.getElementById("itemsComprados")
        while (itemsComprados.firstChild) {
            itemsComprados.removeChild(itemsComprados.firstChild)
        }
    }


    function guardar_en_Storage(arr) {
        localStorage.setItem("carrito", JSON.stringify(arr))
    }

    
    async function detalle(id) {
        const rpta = await fetch(`../../administrador/producto/detalles.php?id=${id}`)
        const data = await rpta.json()
        return data;
    }

    async function datos_modal(obj) {
        const   img_modal = document.getElementById("img_modal"),
                title_modal = document.getElementById("title_modal"),
                price_modal = document.getElementById("price_modal"),
                description_modal = document.getElementById("description_modal"),
                presentacion_modal = document.getElementById("presentacion_modal"),
                stock_modal = document.getElementById("stock_modal")

        const data = await obj;
        console.log(data);

        console.log(data[0].nombre);
        console.log(data[0].precio);

        img_modal.src = `../imgs/${data[0].foto}`
        title_modal.textContent = data[0].nombre
        description_modal.textContent = data[0].descripcion
        presentacion_modal.textContent = data[0].PRnombre
        price_modal.textContent = `S/. ${data[0].precio}`
        stock_modal.textContent = `Stock: ${data[0].stock
}`
    }

}();
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuesta</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>
    <header class="d-flex justify-content-center align-item-center m-5">
        <h3>Encuesta PHP</h3>
    </header>

    <section>
        <div class="row d-flex justify-content-center">
            <div class="col-md-6">
                <select class="form-select" name="ip_encuesta" id="ip_encuesta">
                    <option disabled value="" selected>Seleccione una opcion</option>
                </select>
            </div>
        </div>
    </section>

    <section>
        <div class="row mx-auto col-6">
            <form id="form_encuesta">
                <input type="hidden" id="id_formulario" name="id_formulario" value=""/>
                <div id="container_preguntas"></div>
            </form>
        </div>
        <div class="row d-flex justify-content-center mt-5 mb-5">
            <button id="btn-guardar" class="btn btn-info" style="width: 40%;">Guardar</button>
        </div>
    </section>
</body>

<script>
    window.addEventListener("load", (event) => {
        getEncuestas();
    });

    document.getElementById("btn-guardar").addEventListener("click", guardarEncuesta)

    const ALTER_RESPUESTAS = [1, 2, 3, 4, 5]

    async function getEncuestas()
    {
        try {
            const endpoint = "ajax.php?c=encuesta&a=getEncuestas"
            const response = await fetch(endpoint)
            const encuestas = await response.json()

            const {error, data} = encuestas
            if (error) {
                throw new Error(error) 
            }
            
            // Anexar Options al Select
            const sl_encuesta = document.getElementById('ip_encuesta')
            for (let encuesta of data) {
                const option = document.createElement("option")
                option.innerHTML = encuesta.nombre_encuesta
                option.value = encuesta.codigo_encuesta
                sl_encuesta.appendChild(option)
            }

            sl_encuesta.addEventListener("change", getPreguntas)
        } catch (error) {
            alert(`Ocurrio un error: ${error}`)
        }
    }

    async function getPreguntas(event)
    {
        try {
            const id = event.target.value
            const endpoint = `ajax.php?c=encuesta&a=getPreguntasByEncuesta&id=${id}`
            const response = await fetch(endpoint)
            const preguntas = await response.json()

            const {error, data} = preguntas
            if (error) {
                throw new Error(error) 
            }

            // Actualizar id formulario
            document.getElementById("id_formulario").value = id

            // Anexar preguntas al DOM
            const form = document.getElementById('form_encuesta')
            const div_container = document.createElement("div")
            div_container.setAttribute("id", "container_preguntas")
            for (let pregunta of data) {
                // Div contenedor de la pregunta
                const div = document.createElement("div")
                div.classList.add("mt-4")

                // Label de la Pregunta
                const label = document.createElement("label")
                label.innerHTML = pregunta.descripcion
                label.classList.add("pb-2")

                // Select de valores por pregunta
                const select = document.createElement("select")
                select.setAttribute("name", `preguntas[${pregunta.num_pregunta}]`)
                select.classList.add("form-select")

                // Options del select
                for (let i of ALTER_RESPUESTAS) {
                    const option = document.createElement("option")
                    option.innerHTML = i
                    option.value = `${pregunta.num_pregunta}-${i}`
                    select.appendChild(option)
                }

                // Agregar nodos 
                div.appendChild(label)
                div.appendChild(select)
                div_container.appendChild(div)
            }

            // Agregar div contenedor al formulario
            form.removeChild(document.getElementById("container_preguntas"))
            form.appendChild(div_container)
        } catch (error) {
            alert(`Ocurrio un error: ${error}`)
        }
    }

    function guardarEncuesta(event)
    {
        try {
            event.preventDefault()

            // Validar ingreso de formulario
            if (document.getElementById("id_formulario").value == '') {
                alert("Por favor, selecciona un formulario")
                return false
            }

            const form = document.getElementById('form_encuesta')
            const endpoint = `ajax.php?c=encuesta&a=save`
            fetch(endpoint, {
                method: "POST",
                body: new FormData(form)
            })
            .then((res) => res.json())
            .catch((error) => alert(error))
            .then((response) => {
                let {error, message} = response
                if (error) {
                    alert(message)
                    return false
                }
                location.href = "estadisticas.php"
            });
        } catch (error) {
            alert(`Ocurrio un error: ${error}`)
        }
    }


</script>


</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadisticas</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>
<body>
    <header class="d-flex justify-content-center align-item-center m-5">
        <h3>Estadisticas de las encuestas</h3>
    </header>

    <section>
        <div class="row d-flex justify-content-center">
            <div class="col-md-10">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">Número de encuestados</th>
                        <th scope="col">Promedio</th>
                    </tr>
                </thead>
                <tbody id="tb_estadistica">
                </tbody>
            </table>
            </div>
        </div>
    </section>

</body>

<script>

window.addEventListener("load", (event) => {
    getEstadisticas();
});

async function getEstadisticas()
{
    try {
        const endpoint = "ajax.php?c=encuesta&a=getEstadisticasAjax"
        const response = await fetch(endpoint)
        const estadisticas = await response.json()

        const {error, data} = estadisticas
        if (error) {
            throw new Error(error) 
        }

        if (data.length == 0) {
            alert("No existen registros ...")
            return false
        }

        for (let estadistica of data) {
            const tr = document.createElement("tr")
            let td = document.createElement("td")
            td.innerHTML = estadistica.codigo_encuesta
            tr.appendChild(td)
            td = document.createElement("td")
            td.innerHTML = estadistica.nombre_encuesta
            tr.appendChild(td)
            td = document.createElement("td")
            td.innerHTML = estadistica.count
            tr.appendChild(td)
            td = document.createElement("td")
            td.innerHTML = estadistica.promedio
            tr.appendChild(td)
            document.getElementById("tb_estadistica").appendChild(tr)
        }
    } catch (error) {
        alert(`Ocurrio un error: ${error}`)
    }
}

</script>

</html>
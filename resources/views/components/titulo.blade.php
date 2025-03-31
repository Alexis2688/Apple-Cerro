<style>
    h1 {

        /* Selector de etiqueta*/
    }
    .titulo{
        color: navy;
        font-weight: 600;
        font-size: 38px;
    }
    #titulo-seccion {
        /*Selecor de ID */
    }
</style>
<h1 class="titulo" id="titulo-seccion">
    {{ $slot }}
</h1>
<script>
    // Seleccionar el elemento
    const titulo = document.querySelector("#titulo-seccion");
    // Agregar un evento al elemento
    titulo.addEventListener("click", function() {
        // Definir la lógica del método que responde al evento
        // Muestra un popup en la página.
        alert("Hiciste click en el titulo");
        // Muestra el mensaje en la consola del navegador
        console.log("Hiciste click en el titulo");
    });
</script>

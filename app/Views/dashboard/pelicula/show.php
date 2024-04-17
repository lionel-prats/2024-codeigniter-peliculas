<?php echo $this->extend("Layouts/dashboard"); ?>

<?php echo $this->section("contenido"); ?>
    <table border="1" cellspacing="0" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo $pelicula->id; ?></td>
                <td><?php echo $pelicula->titulo; ?></td>
                <td><?php echo $pelicula->descripcion; ?></td>
            </tr>
        </tbody>
    </table>
    <br>
    <h3>Imagenes</h3>
    <ul>
        <?php foreach($pelicula_imagenes as $imagen): ?>
            <li>
                <img 
                    style="width: 7rem; height: 7rem;"
                    alt="<?php echo "imagen_pelicula_" . $pelicula->id; ?>"
                    src="<?php echo "/uploads/peliculas/$imagen->imagen"; ?>" 
                >
                <form action="<?php echo route_to("pelicula.borrar_imagen", $imagen->id); ?>" method="POST">
                    <button>Borrar Imagen</button>
                </form>
            </li>
        <?php endforeach ?>
    </ul>
    <h3>Etiquetas</h3>
    <?php foreach($etiquetas as $etiqueta): ?>

        <!-- BLOQUE para hacer una peticion POST via PHP para borrar la etiqueta de una pelicula -->
        <!-- <form 
            method="POST"
            action="<?php //echo route_to("pelicula.etiqueta_delete", $pelicula->id, $etiqueta->id); ?>" 
        >
            <input type="submit" value="<?php //echo $etiqueta->titulo; ?>">
        </form> -->
        <!-- fin BLOQUE -->
        
        <button 
            class="delete-etiqueta"
            data-url="
                <?php echo route_to("pelicula.etiqueta_delete", $pelicula->id, $etiqueta->id); ?>
                <?php //echo route_to("pelicula.test", 1, 2); ?>
            "
        >
            <?php echo $etiqueta->titulo; ?>
        </button>
        
        <br>
        <br>
    <?php endforeach ?>
    <a href="/dashboard/pelicula">Get Back</a>

    <script>
        document.querySelectorAll(".delete-etiqueta").forEach((button) =>{
            button.onclick = (e) => {
                fetch(button.getAttribute("data-url"), {
                    method: "POST"
                }).then(res => /* res.json() */  window.location.reload())  
                .then(res => {
                    if(res.deleted) {
                        // estamos en la vista"http://localhost:8080/dashboard/pelicula/show/$pelicula_id"
                        // con esta instruccion, se recarga la pagina en la que estamos parados cada vez el usuario elimine la etiqueta de la pelicula cuyo detalle estamos viendo (v115) 
                        window.location.reload()
                    }
                })
            }
        })
    </script>

<?php echo $this->endSection(); ?>
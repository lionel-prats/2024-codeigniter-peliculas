<?php
    // include|require del layout /app/Views/Layout/dashboard.php
    echo $this->extend("Layouts/dashboard"); 
?>


<?php 
    // seccion "contenido" (/app/Views/Layout/dashboard.php)
    echo $this->section("contenido"); 
?>
    <a href="<?php echo base_url("/dashboard/pelicula/new"); ?>" 
        class="btn btn-success mb-3"
    >New</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Descripción</th>
                <th>Categoría</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($peliculas as $pelicula): ?>
                <tr>
                    <td><?php echo $pelicula->id; ?></td>
                    <td><?php echo $pelicula->titulo; ?></td>
                    <td><?php echo $pelicula->descripcion; ?></td>
                    <td><?php echo $pelicula->categoria; ?></td>
                    <td>
                        <a 
                            href="/dashboard/pelicula/show/<?php echo $pelicula->id; ?>" class="btn btn-secondary btn-sm"
                        >Show</a>
                        <a 
                            href="/dashboard/pelicula/edit/<?php echo $pelicula->id; ?>"
                            class="btn btn-warning btn-sm"
                        >Edit</a>
                        <a 
                            href="<?php echo route_to("pelicula.etiquetas", $pelicula->id); ?>"
                            class="btn btn-primary btn-sm"
                        >Tags</a>
                        <form action="/dashboard/pelicula/delete/<?php echo $pelicula->id; ?>" method="POST">
                            <input 
                                type="submit" value="Delete"
                                class="btn btn-danger btn-sm mt-1"    
                            >
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <?php echo $pager->links(); // v130 ?>
    <?php //echo $pager->simpleLinks(); // v140 ?>

    <br>
    <a href="<?php echo route_to("pelicula.test", 15, 38); ?>">/dashboard/test/15/38</a>
    <br>
    <a href="/testing/show/10">/testing/show/10</a>
    <br>
    <a href="/testing2/new">/testing2/new</a>
<?php
    // fin seccion "contenido" (/app/Views/Layout/dashboard.php) 
    echo $this->endSection(); 
?>
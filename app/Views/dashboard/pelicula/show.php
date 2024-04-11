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
                <?php echo $imagen->imagen . "." . $imagen->extension; ?>
            </li>
        <?php endforeach ?>
    </ul>
    <h3>Etiquetas</h3>
    <?php foreach($etiquetas as $etiqueta): ?>
        <button><?php echo $etiqueta->titulo; ?></button>
        <br>
        <br>
    <?php endforeach ?>
    <a href="/dashboard/pelicula">Get Back</a>
<?php echo $this->endSection(); ?>
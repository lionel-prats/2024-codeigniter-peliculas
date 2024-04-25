<?php echo $this->extend("Layouts/blog"); ?>
<?php echo $this->section("contenido"); ?>
    <div class="card">
        <div class="card-body">
            <h1><?php echo $pelicula->titulo; ?></h1>
            <hr>
            <p><?php echo $pelicula->descripcion; ?></p>
        </div>
    </div>
<?php echo $this->endSection(); ?>
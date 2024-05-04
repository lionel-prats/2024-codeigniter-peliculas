<?php echo $this->extend("Layouts/blog"); ?>
<?php echo $this->section("contenido"); ?>
    <div class="card mb-3">
        <div class="card-body">
            <h1><?php echo $pelicula->titulo; ?></h1>
            <hr>
            <a class="btn btn-primary" href="#"><?php echo $pelicula->categoria; ?></a>
            <p><?php echo $pelicula->descripcion; ?></p>
            <?php if($pelicula_imagenes): ?>
                <h3>Imagenes</h3>
                <?php else: ?>
                <h3>La película no tiene imágenes cargadas</h3>
            <?php endif ?>
            <div class="container">
                <div class="row">
                    <?php foreach($pelicula_imagenes as $imagen): ?>
                        <div class="col-4 p-2">
                            <img 
                                class="w-100 h-20r" alt="<?php echo "imagen_pelicula_" . $pelicula->id; ?>" 
                                src="<?php echo "/uploads/peliculas/$imagen->imagen"; ?>"
                            >
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
            <?php if($pelicula_etiquetas): ?>
                <h3>Etiquetas</h3>
            <?php else: ?>
                <h3>La película no tiene etiquetas cargadas</h3>
            <?php endif ?>
            <div class="py-2 d-flex gap-3">
                <?php foreach($pelicula_etiquetas as $etiqueta): ?>
                    <a href="#" class="btn btn-sm btn-indigo"><?php echo $etiqueta->titulo; ?></a>
                <?php endforeach ?>
            </div>
        </div>
    </div>
    <a class="btn btn-info mb-5" href="<?php echo base_url("blog"); ?>">Volver</a>
<?php echo $this->endSection(); ?>
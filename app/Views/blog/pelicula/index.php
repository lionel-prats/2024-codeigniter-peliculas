<?php echo $this->extend("Layouts/blog"); ?>
<?php echo $this->section("contenido"); ?>
    <h1>Películas</h1>
    <hr>
    <div class="card my-3 text-bg-primary">
        <div class="card-body">
            <form method="GET">
                <div class="d-flex gap-2 mb-2">
                    <select name="categoria_id" class="form-control flex-grow-1">
                        <option value="">Categoría</option>
                    </select>
                    <select name="etiqueta_id" class="form-control">
                        <option value="">Etiqueta</option>
                    </select>
                </div>
                <div class="d-flex gap-2">
                    <input type="text" name="buscar" class="form-control" placeholder="Buscar...">
                    <input type="submit" value="Enviar" class="btn btn-secondary">
                </div>
            </form>
        </div>
    </div>
    <?php foreach($peliculas as $pelicula): ?>
        <div class="card mb-3">
            <div class="card-body">
                <h4><?php echo $pelicula->titulo; ?></h4>
                <p><?php echo $pelicula->descripcion; ?></p>
                <a 
                    href="<?php echo base_url("blog/show/$pelicula->id"); ?>"
                    class="btn btn-primary"
                >Ver...</a>
            </div>
        </div>
    <?php endforeach; ?>
    <?php echo $pager->links(); ?>
<?php echo $this->endSection(); ?>
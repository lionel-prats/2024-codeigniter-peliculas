<small class="badge text-bg-danger mb-2">Bloque "/Views/partials/_peliculas.php", invocado desde <?php echo $desde ?? "???"; ?></small>
<?php foreach($peliculas as $pelicula): ?>
    <div class="card mb-3">
        <div class="card-body">
            <h4><?php echo $pelicula->titulo; ?></h4>
            <!-- target="_blank" -->
            <a 
                class="btn btn-sm btn-secondary" 
                href="<?php echo route_to("blog.pelicula.index_por_categoria", $pelicula->categoria_id);?>"
            ><?php echo $pelicula->categoria; ?></a>
            
            <p><?php echo "$pelicula->descripcion (categoría $pelicula->categoria_id)"; ?></p>
            <?php if($pelicula->imagen): ?>
                <img 
                    class="img-size-10 mb-3"
                    src="<?php echo "/uploads/peliculas/$pelicula->imagen"; ?>" 
                    alt="Imagen Película"
                >
            <?php endif ?>
            <div class="mb-3">
                <?php foreach($pelicula->etiquetas as $etiqueta): ?>
                    <a 
                        class="btn btn-sm btn-indigo" 
                        href="<?php echo route_to("blog.pelicula.index_por_etiqueta", $etiqueta->id);?>">
                    <?php echo $etiqueta->titulo; ?></a>
                <?php endforeach ?>
            </div>
            <a 
                href="<?php 
                    echo base_url("blog/show/$pelicula->id . $add_query_string"); 
                ?>"
                class="btn btn-primary"
            >Ver...</a>
        </div>
    </div>
<?php endforeach; ?>
<?php echo $pager->links(); ?>
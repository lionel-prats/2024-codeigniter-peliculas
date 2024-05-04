<?php echo $this->extend("Layouts/blog"); ?>
<?php echo $this->section("contenido"); ?>
    <h1><?php echo $titulo_vista; ?></h1>
    <hr>
    <?php echo view("partials/_peliculas", ["desde" => "\"/Views/blog/pelicula/index_por_etiqueta.php\" (v161)"]); 
    ?>
<?php echo $this->endSection(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $tituloVista; ?></title>
    <!-- <link rel="stylesheet" href="<?php //echo base_url() ?>bootstrap/dist/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="<?php echo base_url("bootstrap/dist/css/bootstrap.min.css") ?>">
</head>
<body>
    <nav class="navbar navbar-expand-lg mb-3">
        <div class="container-fluid">
            <a href="/" class="navbar-brand">Code4</a>
            <div class="navbar-collapse">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="<?php echo base_url("dashboard/categoria"); ?>" class="nav-link">Categorías</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url("dashboard/etiqueta"); ?>" class="nav-link">Etiquetas</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url("dashboard/pelicula"); ?>" class="nav-link">Películas</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1 class="title"><?php echo $tituloVista; ?></h1>
            </div>
            <div class="card-body">
                <?php echo view("partials/_session"); ?>
                <?php echo $this->renderSection("contenido"); ?>
            </div>
        </div>
    </div>
    <script src="<?php echo base_url("bootstrap/dist/js/bootstrap.min.js") ?>"></script>
</body>
</html>
<?php //echo $this->extend("Layouts/dashboard"); ?>
<?php //echo $this->section("contenido"); ?>
<?php //echo $this->endSection(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo_vista; ?></title>
    <link rel="stylesheet" href="<?php echo base_url("assets/bootstrap/dist/css/bootstrap.min.css") ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/styles/style.css") ?>">
</head>
<body>
    <nav class="navbar navbar-expand-lg mb-3">
        <div class="container-fluid">
            <a href="/" class="navbar-brand">Code4</a>
            <div class="navbar-collapse">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="<?php echo base_url("blog"); ?>" class="nav-link">Películas</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <?php echo $this->renderSection("contenido"); ?>
    </div>
    <script src="<?php echo base_url("bootstrap/dist/js/bootstrap.min.js") ?>"></script>
</body>
</html>
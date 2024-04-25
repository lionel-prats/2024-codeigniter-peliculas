<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $tituloVista; ?></title>
    <link rel="stylesheet" href="<?php echo base_url("bootstrap/dist/css/bootstrap.min.css") ?>">
</head>
<body>
    <div class="container mt-5 w-50">
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
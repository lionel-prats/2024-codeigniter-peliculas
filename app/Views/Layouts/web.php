<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $tituloVista; ?></title>
    <link rel="stylesheet" href="<?php echo base_url("bootstrap/dist/css/bootstrap.min.css") ?>">
    <style>
        .flex{
            display: flex;
        }
        .justify-content-between {
            justify-content: space-between;
        }
        .w-45 {
            width: 45vw;
        }
        .pr-2{
            padding-right: .5rem;
        }
        .p-2{
            padding: .5rem;
        }
        .title {
            color: #6B9471;
        }
        .error-message {
            background-color: #e24152;
            color: white;
        }
        .success-message {
            background-color: #6B9471;
            color: yellow;
        }
    </style>
</head>
<body>
    <?php echo view("partials/_session"); ?>
    <h1 class="title"><?php echo $tituloVista; ?></h1>
    <?php echo $this->renderSection("contenido"); ?>
</body>
</html>
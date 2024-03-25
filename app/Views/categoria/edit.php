<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $tituloVista; ?></title>
</head>
<body>
    <form action="/categoria/update/<?php echo $categoria["id"]; ?>" method="POST">
        <?php echo view("categoria/_form"); ?>
    </form>
    <br>
    <a href="/categoria">Get Back</a>
</body>
</html>
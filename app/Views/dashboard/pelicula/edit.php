<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $tituloVista; ?></title>
</head>
<body>
    
    <form action="/dashboard/pelicula/update/<?php echo $pelicula["id"]; ?>" method="POST">
        <?php echo view("dashboard/pelicula/_form"); ?>
    </form>
    <br>
    <a href="/dashboard/pelicula">Get Back</a>
</body>
</html>
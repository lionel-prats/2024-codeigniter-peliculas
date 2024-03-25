<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Película</title>
</head>
<body>
    <form action="/pelicula/update/<?php echo $pelicula["id"]; ?>" method="POST">
        <?php echo view("pelicula/_form"); ?>
    </form>
    <br>
    <a href="/pelicula">Get Back</a>
</body>
</html>
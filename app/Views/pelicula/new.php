<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $tituloVista; ?></title>
</head>
<body>
    <form action="/pelicula/create" method="POST">
        <?php echo view("pelicula/_form"); ?>
    </form>
    <br>
    <a href="/pelicula">Get Back</a>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle Película</title>
</head>
<body>
    <table border="1" cellspacing="0" cellpadding="10">
        <thead>
            <tr>
                <th>Título</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo $pelicula["titulo"]; ?></td>
                <td><?php echo $pelicula["descripcion"]; ?></td>
            </tr>
        </tbody>
    </table>
    <br>
    <a href="/pelicula">Get Back</a>
</body>
</html>
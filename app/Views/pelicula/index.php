<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado Películas</title>
</head>
<body>
    <h1>Listado Peliculas</h1>
    
    <a href="/pelicula/new">New</a>
    <br>
    <br>

    <table border="1" cellspacing="0" cellpadding="10">
        <thead>
            <tr>
                <th>Título</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($peliculas as $pelicula): ?>
                <tr>
                    <td><?php echo $pelicula["titulo"]; ?></td>
                    <td><?php echo $pelicula["descripcion"]; ?></td>
                    <td>
                        <a href="/pelicula/show/<?php echo $pelicula["id"]; ?>">Detail</a>
                        <br>
                        <a href="/pelicula/edit/<?php echo $pelicula["id"]; ?>">Edit</a>
                        <form action="/pelicula/delete/<?php echo $pelicula["id"]; ?>" method="POST">
                            <input type="submit" value="Delete">
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    

</body>
</html>
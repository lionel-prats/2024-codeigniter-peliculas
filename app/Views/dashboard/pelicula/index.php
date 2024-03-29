<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $tituloVista; ?></title>
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
    </style>
</head>
<body>
    <h1><?php echo $tituloVista; ?></h1>
    <div class="flex justify-content-between w-45">
        <a href="/dashboard/pelicula/new">New</a>
        <div>
            <a href="/" class="pr-2">Home</a>
            <a href="/dashboard/categoria">Categorías</a>
        </div>
    </div>
    <br>
    <br>

    <table border="1" cellspacing="0" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($peliculas as $pelicula): ?>
                <tr>
                    <td><?php echo $pelicula["id"]; ?></td>
                    <td><?php echo $pelicula["titulo"]; ?></td>
                    <td><?php echo $pelicula["descripcion"]; ?></td>
                    <td>
                        <a href="/dashboard/pelicula/show/<?php echo $pelicula["id"]; ?>">Detail</a>
                        <br>
                        <a href="/dashboard/pelicula/edit/<?php echo $pelicula["id"]; ?>">Edit</a>
                        <form action="/dashboard/pelicula/delete/<?php echo $pelicula["id"]; ?>" method="POST">
                            <input type="submit" value="Delete">
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <br>
    <a href="<?php echo route_to("pelicula.test", 15, 38); ?>">/dashboard/test/15/38</a>
    <br>
    <a href="/testing/show/10">/testing/show/10</a>
    <br>
    <a href="/testing2/new">/testing2/new</a>
    

</body>
</html>
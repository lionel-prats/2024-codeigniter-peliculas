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

    <?php if(session("ip") && session("ip2") && session("session_key")): ?>
        <code>Variable de sesion $ip == <?php echo session("ip"); ?></code>
        <br>
        <code>Variable de sesion $ip2 == <?php echo session()->get("ip2"); ?></code>
        <br>
        <code>Variable de sesion $session_key["origin"] == <?php echo session()->get("session_key")["origin"]; ?></code>
        <br>
        <code>Variable de sesion $session_key["owner"] == <?php echo session()->get("session_key")["owner"]; ?></code>
        <br>
        <code>Variable de sesion $session_key["shadow_pass"] == <?php echo session()->get("session_key")["shadow_pass"]; ?></code>
        <br>
        <a href="<?php echo route_to("pelicula.destruir-session", 15, 38); ?>">Destruir datos de sesión</a>
    <?php endif ?>

    <?php echo view("partials/_session"); ?>

    <h1><?php echo $tituloVista; ?></h1>
    <div class="flex justify-content-between w-45">
        <a href="/dashboard/categoria/new">New</a>
        <div>
            <a href="/" class="pr-2">Home</a>
            <a href="/dashboard/pelicula">Películas</a>
        </div>
    </div>
    <br>
    <br>

    <table border="1" cellspacing="0" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($categorias as $categoria): ?>
                <tr>
                    <td><?php echo $categoria["id"]; ?></td>
                    <td><?php echo $categoria["titulo"]; ?></td>
                    <td>
                        <a href="/dashboard/categoria/show/<?php echo $categoria["id"]; ?>">Detail</a>
                        <br>
                        <a href="/dashboard/categoria/edit/<?php echo $categoria["id"]; ?>">Edit</a>
                        <form action="/dashboard/categoria/delete/<?php echo $categoria["id"]; ?>" method="POST">
                            <input type="submit" value="Delete">
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    

</body>
</html>
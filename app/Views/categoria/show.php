<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $tituloVista; ?></title>
</head>
<body>
    <table border="1" cellspacing="0" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo $categoria["id"]; ?></td>
                <td><?php echo $categoria["titulo"]; ?></td>
            </tr>
        </tbody>
    </table>
    <br>
    <a href="/categoria">Get Back</a>
</body>
</html>
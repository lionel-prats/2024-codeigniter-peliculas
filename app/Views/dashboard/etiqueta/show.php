<?php echo $this->extend("Layouts/dashboard"); ?>
<?php echo $this->section("contenido"); ?>
    <table border="1" cellspacing="0" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Categoria_id</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo $etiqueta->id; ?></td>
                <td><?php echo $etiqueta->titulo; ?></td>
                <td><?php echo $etiqueta->categoria_titulo; ?></td>
            </tr>
        </tbody>
    </table>
    <br>
    <a href="/dashboard/etiqueta">Get Back</a>
<?php echo $this->endSection(); ?>
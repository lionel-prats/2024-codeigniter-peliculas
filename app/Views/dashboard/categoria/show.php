<?php echo $this->extend("Layouts/dashboard"); ?>

<?php echo $this->section("contenido"); ?>
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
    <a href="/dashboard/categoria">Get Back</a>
<?php echo $this->endSection(); ?>